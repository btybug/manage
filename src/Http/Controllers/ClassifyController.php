<?php
/**
 * Copyright (c) 2017.
 * *
 *  * Created by PhpStorm.
 *  * User: Edo
 *  * Date: 10/3/2016
 *  * Time: 10:44 PM
 *
 */

namespace Btybug\Manage\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Urlmanager;
use Datatables;
use Illuminate\Http\Request;
use Sahakavatar\Cms\Helpers\helpers;
use Btybug\Manage\Models\Classifier;
use Btybug\Manage\Models\ClassifierItem;
use Btybug\Manage\Models\ClassifierItemPage;
use Btybug\Manage\Models\FrontendPage;

/**
 * Class ClassifyController
 * @package Sahakavatar\Create\Http\Controllers
 */
class ClassifyController extends Controller
{
    public $masterClassifier = null;
    /**
     * @var null|string
     */
    private $home = null;
    /**
     * @var helpers|null
     */
    private $helpers = null;

    public function __construct()
    {
        $this->home = '/admin/manage/frontend/classify';
        $this->helpers = new helpers;
        $this->masterClassifier = FrontendPage::where('slug', MASTER_CLASSIFIER)->first();
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex(Request $request)
    {
        $id = $request->get('p');
        $classifiers = Classifier::all();
        $count = 0;
        if (count(ClassifierItem::all())) {
            $count = ClassifierItem::all()->last()->id;
        }

        $classifierItems = [];

        if (count($classifiers)) {
            $model = Classifier::find($id);
            if ($model) {
                $classifierItems = $model->classifierItem()->where('parent_id', NULL)->get();
            } else {
                $model = $classifiers->first();
                $classifierItems = $classifiers->first()->classifierItem()->where('parent_id', NULL)->get();
            }
        }
        return view('manage::frontend.classify.list', compact(['classifiers', 'classifierItems', 'count', 'model']));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreate(Request $request)
    {
        $classifyData = $request->except('_token', 'terms');

        $v = \Validator::make($classifyData, ['title' => "required|unique:classifiers,title|unique:frontend_pages,title"]);

        if ($v->fails()) return redirect()->back()->withErrors($v->messages());
        $classifyData['id'] = uniqid();
//        $classifyData['type'] = 'multiple';
        $classifier = new Classifier($classifyData);
        $classifier->buildSlug();
        $classifier->save();

        $newPageSaved = FrontendPage::create([
            'user_id' => \Auth::id(),
            'title' => $classifyData['title'],
            'slug' => uniqid(),
            'type' => 'classify',
            'parent_id' => $this->masterClassifier->id,
            'url' => '/all-classify/' . $classifier->slug
        ]);

        if ($newPageSaved) {
            $urlManager = new Urlmanager([
                'front_page_id' => $newPageSaved->id,
                'url' => $newPageSaved->url,
                'type' => 'classify'
            ]);
            $urlManager->save();
        }
        $newPageClassifier = new ClassifierItemPage([
            'front_page_id' => $newPageSaved->id,
            'classifier_id' => $classifier->id
        ]);
        $newPageClassifier->save();

        if ($request->hasFile('image')) {
            $imageName = uniqid() . '.' .
                $request->file('image')->getClientOriginalExtension();

            $path = '/public/img/classify/';
            $request->file('image')->move(
                base_path($path), $imageName
            );

            $classifier->update([
                'image' => $path . $imageName
            ]);
        }

        return redirect()->back();
    }

    public function postEdit($id, Request $request)
    {
        $classifyData = $request->except('_token', 'terms');
        $v = \Validator::make($classifyData, ['title' => "required|unique:classifiers,title," . $id . ",id"]);

        if ($v->fails()) return redirect()->back()->withErrors($v->messages());

        $classify = Classifier::find($id);
        if ($classify) {
            $page = $classify->page()->where('type', 'classify')->first();
            if ($request->hasFile('image')) {
                if (\File::exists(base_path($classify->image)))
                    unlink(base_path($classify->image));

                $imageName = uniqid() . '.' .
                    $request->file('image')->getClientOriginalExtension();

                $path = '/public/img/classify/';
                $request->file('image')->move(
                    base_path($path), $imageName
                );
                $classifyData['image'] = $path . $imageName;
            }

            if ($classify->update($classifyData)) {
                $page->title = $classify->title;
                $page->save();
            }
        }

        return redirect()->back();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     * @throws \Throwable
     */
    public function postTaxonomyForm(Request $request)
    {
        $term = $request->get('terms');
        if ($term) {
            $items = [];
            $id = $request->get('id', null);
            $classifier = Classifier::find($request->classifier);
            $model = ClassifierItem::find($id);
            if ($classifier) {
                $items = $classifier->classifierItem()->where('id', '!=', $id)->pluck('title', 'id')->toArray();
            }
            ($id) ? $url = "/admin/manage/frontend/classify/term-edit/$id" : $url = "/admin/manage/frontend/classify/term-create";

            $html = \view("manage::frontend.classify._partials._term_form", compact(['model', 'url', 'classifier', 'items']))->render();
        } else {
            $id = $request->get('id', null);
            $model = Classifier::find($id);
            ($id) ? $url = "/admin/manage/frontend/classify/edit/$id" : $url = "/admin/manage/frontend/classify/create";

            $html = \view("manage::frontend.classify._partials._form", compact(['model', 'url']))->render();
        }

        return \Response::json(['error' => false, 'html' => $html]);
    }

    public function postTermEdit($id, Request $request)
    {
        $classifyData = $request->except('_token');
        $v = \Validator::make($classifyData, ['title' => "required"]);

        if ($v->fails()) return redirect()->back()->withErrors($v->messages());

        $classifierItem = ClassifierItem::find($id);
        if ($classifierItem) {
            $page = $classifierItem->page()->where('type', 'classify')->first();
            if ($request->hasFile('image')) {
                if (\File::exists(base_path($classifierItem->image)))
                    unlink(base_path($classifierItem->image));

                $imageName = uniqid() . '.' .
                    $request->file('image')->getClientOriginalExtension();

                $path = '/public/img/classify/';
                $request->file('image')->move(
                    base_path($path), $imageName
                );
                $classifyData['image'] = $path . $imageName;
            }
//            if($classify->parent_id != $classifyData['parent_id']) {
//                $classify->buildSlug();
//            }

            if ($classifierItem->update($classifyData)) {
                $classifierItem->buildSlug();
                $classifierItem->save();

                $page->title = $classifierItem->title;
                $page->url = $classifierItem->slug;
                $page->parent_id = $classifierItem->parent()->first()->page()->where('type', 'classify')->first()->id;
                $page->save();
                $page->urlManager->url = $page->url;
                $page->urlManager->save();

                $classifierItem->rebuildChildren();
            }
        }


        return redirect()->back();
    }

    public function postTermCreate(Request $request)
    {
        $itemData = $request->except('_token');

        $v = \Validator::make($itemData, ['title' => "required"]);

        if ($v->fails()) return redirect()->back()->withErrors($v->messages());
        $itemData['id'] = uniqid();
        $classifierItem = new ClassifierItem($itemData);
        $classifierItem->buildSlug();
        $classifierItem->parent_id = isset($itemData['parent_id']) && $itemData['parent_id'] != '' ? $itemData['parent_id'] : NULL;
//        $classifierItem->parent_id = $classifierItem->parent()->first() ? $classifierItem->parent()->first()->id : NULL;//$classifierItem->classifier()->first()->id;
        $classifierItem->save();
        $newPageSaved = FrontendPage::create([
            'user_id' => \Auth::id(),
            'title' => $classifierItem->title,
            'slug' => uniqid(),
            'type' => 'classify',
            'parent_id' => $classifierItem->parent()->first()
                ? $classifierItem->parent()->first()->page()->where('type', 'classify')->first()->id
                : $classifierItem->classifier()->first()->page()->where('type', 'classify')->first()->id,
            'url' => $classifierItem->slug
        ]);

        $newPageClassifier = new ClassifierItemPage([
            'front_page_id' => $newPageSaved->id,
            'classifier_id' => $classifierItem->classifier()->first()->id,
            'classifier_item_id' => $classifierItem->id,
        ]);
        $newPageClassifier->save();

        if ($request->hasFile('image')) {
            $imageName = uniqid() . '.' .
                $request->file('image')->getClientOriginalExtension();

            $path = '/public/img/classify/';
            $request->file('image')->move(
                base_path($path), $imageName
            );

            $classifierItem->update([
                'image' => $path . $imageName
            ]);
        }

        return redirect()->back();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     * @throws \Throwable
     */
    public function postGenerateForm(Request $request)
    {
        $model = $request->except('_token');

        $html = \view("manage::frontend.classify._partials._term_item")->with('model', $model)->render();

        return \Response::json(['error' => false, 'html' => $html]);
    }

    public function postDelete(Request $request)
    {
        $deleted = false;
        $classify = Classifier::find($request->slug);
        if ($classify) {
            if (!empty($classify->image)) {
                unlink(base_path($classify->image));
            }
            $deleted = $classify->delete();
        }
        return \Response::json(['success' => $deleted, 'url' => url('/admin/manage/frontend/classify')]);
    }

    public function postDeleteItem(Request $request)
    {
        $deleted = false;
        $classifierItem = ClassifierItem::find($request->slug);
        if ($classifierItem) {
            $deleted = $classifierItem->delete();
        }
        return \Response::json(['success' => $deleted, 'url' => url('/admin/manage/frontend/classify')]);
    }

}
