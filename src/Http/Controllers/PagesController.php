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

namespace Sahakavatar\Manage\Http\Controllers;

use Sahakavatar\Cms\Services\CmsItemReader;
use Sahakavatar\Cms\Helpers\helpers;
use App\Http\Controllers\Controller;
use Sahakavatar\Cms\Models\ContentLayouts\MainBody;
use Sahakavatar\Manage\Models\Classifier;
use Sahakavatar\Manage\Models\ClassifierItemPage;
use Sahakavatar\Manage\Models\FrontendPage;
use Sahakavatar\Modules\Models\Fields;
use Sahakavatar\Settings\Models\Settings;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Response;
use Validator;
use View;

/**
 * Class PageController
 *
 * @package Sahakavatar\Tools\Http\Controllers
 */
class PagesController extends Controller
{

    // private $page;
    /**
     * @var helpers|null
     */
    private $helpers = null;
    /**
     * @var null|string
     */
    private $home = null;

    /**
     * PageController constructor.
     *
     * @param Page $page
     * @param Manage $manager
     * @param Termrepository $term
     * @param WidgetRepository $widgetRepository
     */
    public function __construct()
    {
        $this->helpers = new helpers;
        $this->home = '/admin/manage/frontend/pages';
    }

    /**
     * @param string $type
     * @return View
     */
    public function getIndex(Request $request)
    {
        $pageID = $request->get('p');
        $type = $request->get('type', 'core');
        $tags = [];
        $classifierPageRelations = [];
        $pages = FrontendPage::where('type', $type)->whereNull('parent_id')->get();

        if ($pageID) {
            $page = FrontendPage::find($pageID);
        } else {
            $page = FrontendPage::where('type', $type)->first();
        }

        if ($page && !$page->page_section) $page->page_section = 0;

        $admins = User::admins()->pluck('username', 'id')->toArray();
        $classifies = Classifier::all();
//        dd($page->id,ClassifierItemPage::where('front_page_id', $page->id)->groupBy('classifier_id')->get());
//        if ($page) $classifierPageRelations = ClassifierItemPage::where('front_page_id', $page->id)->groupBy('classifier_id')->get();

        if ($page) $tags = $page->tags;

        return view('manage::frontend.pages.index', compact(['page', 'pages', 'admins', 'classifies', 'tags', 'cloudTags', 'type', 'classifierPageRelations']));
    }

    public function getSettings($id)
    {
        $page = FrontendPage::find($id);
        $admins = User::admins()->pluck('username', 'id')->toArray();
        $tags = $page->tags;
        $classifies = Classifier::all();
        $classifierPageRelations = ClassifierItemPage::where('front_page_id', $page->id)->groupBy('classifier_id')->get();
        return view('manage::frontend.pages.settings', compact(['page', 'admins', 'tags', 'id', 'classifies', 'classifierPageRelations']));
    }

    public function postSettings(Request $request)
    {
        $page = FrontendPage::find($request->id);
        if (!$page) {
            abort(404);
        }
        $page->page_layout = $request->page_section ? $request->page_section : NULL;
        $page->page_layout_settings = $request->get('placeholders')
            ? $request->get('placeholders') : NULL;
        $page->header = $request->header;
        $page->footer = $request->footer;
        $page->url = $request->url;
        $page->title = $request->title;
        $page->status = $request->status;
        $page->page_access = $request->page_access;
        $page->main_content = $request->main_content;
        $page->save();
        if(isset($request->redirect_type) && $request->redirect_type == 'view') {
            return redirect('/admin/manage/frontend/pages/page-test-preview/'.$page->id."?pl_live_settings=page_live&pl=" . $page->page_layout . '&' . $page->getPlaceholdersInUrl());
        }
        return redirect()->back()->with('message', 'Page settings has been saved successfully.');
    }

    public function getGeneral($id)
    {
        return view('manage::frontend.pages.general', compact('id'));
    }

    public function postData(Request $request)
    {
        $id = $request->id;
        if ($page = FrontendPage::find($id)) {
            if ($page && !$page->page_section) $page->page_section = 0;
            $admins = User::admins()->pluck('username', 'id')->toArray();
            $html = View("manage::frontend.pages._partials.page-data", compact(['html', 'page', 'admins']))->render();

            return \Response::json(['error' => false, 'html' => $html]);
        }
        return \Response::json(['error' => true]);
    }

    public function postUserAvatar(Request $request)
    {
        return Response::json(['url' => BBGetUserAvatar($request->id)]);
    }

    public function postClassify(Request $request)
    {
        $classify = Classifier::find($request->id);
        $type = $request->type;
        if ($classify) {
            $termsList = $classify->classifierItem()->pluck('title', 'id')->toArray();
            $html = View('manage::frontend.pages._partials.classify-items', compact(['termsList', 'classify', 'type']))->render();

            return Response::json(['error' => false, 'html' => $html]);
        }
        return Response::json(['error' => false]);
    }

    public function postNew(Request $request)
    {
        $new = FrontendPage::addNewPage();

        if ($new) return redirect()->to($this->home . '?type=custom')->with('message', 'Congratulations: New Page Created Successfully');

        return redirect()->back()->with('message', 'Page not Created');
    }

    public function getAddChild($parent_id)
    {
        $new = FrontendPage::addNewPage($parent_id);

        if ($new) return redirect()->to($this->home . '?type=custom')->with('message', 'Congratulations: New Page Created Successfully');

        return redirect()->back()->with('message', 'Page not Created');
    }

    public function postEdit(Request $request)
    {
        $data = $request->except('_token', 'type', 'tags', 'classify');
        $validator = Validator::make($data, [
            'id' => 'exists:frontend_pages,id',
            'title' => 'required',
            'url' => 'required|unique:frontend_pages,url,' . $data['id']
        ]);

        if ($validator->fails()) return redirect()->back()->withErrors($validator->errors());

        if (isset($data['url'])) {
            (starts_with($data['url'], '/')) ? false : $data['url'] = "/" . $data['url'];
        }

        $page = FrontendPage::find($data['id']);
        if (!$page) return redirect()->back()->with('message', 'Page Not Found!!!');

        $data['edited_by'] = Auth::id();
        $page->update($data);
        FrontendPage::addTags($request->tags, $page->id);
        ClassifierItemPage::createClassifierPageRelations($request->classify, $page->id);

        return redirect()->back()->with('message', 'Successfully Updated Page');
    }

    public function postDetach(Request $request)
    {
        $slug = $request->slug;
        $data = explode('.', $slug);

        if ($page = FrontendPage::find($data[1])) {
            try {
                $page->tags()->detach($data[0]);
            } catch (\Exception $e) {
                return \Response::json(['success' => false, 'url' => back()]);
            }

            return \Response::json(['success' => true, 'url' => back()]);
        }

        return \Response::json(['success' => false, 'url' => back()]);
    }

    public function postDelete(Request $request)
    {
        $page = FrontendPage::find($request->slug);

        if (!$page) abort(500);

        $result = $page->delete();

        return \Response::json(['success' => true, 'message' => "Page successfully deleted"]);
    }


    public function getPreview($layout_id = null, $page_id = null)
    {
        $side_bars = [];
        if (!$layout_id) {
            return null;
        }

        $layout = $this->page->getLayout($layout_id);
        // Include Configuration files
        $assets = [
            'header' => [
                'bootstrap'
            ],
            'footer' => []
        ];
        // Assets Rendering
        if (isset($assets['header'])) {
            Assets::registerCollection('header', $assets['header']);
        }

        if (isset($assets['footer'])) {
            Assets::registerCollection('footer', $assets['footer']);
        }

        $customiser_css = '';
        $preview_class = 'studioifream';

        if ($page_id != null) {
            $side_bars = $this->page->getPageSideBars($page_id);
        }

        $header = BBactiveHeader();
        $footer = BBactiveFooter();

        $sidebar1 = (isset($side_bars['sidebar1'])) ? $side_bars['sidebar1'] : 'Sidebar 1';
        $sidebar2 = (isset($side_bars['sidebar2'])) ? $side_bars['sidebar2'] : 'Sidebar 2';
        $content = 'Content';


        //dd($side_bars);
        return view(
            'layouts.preview',
            compact(
                [
                    'layout',
                    'customiser_css',
                    'header',
                    'footer',
                    'sidebar1',
                    'sidebar2',
                    'content',
                    'preview_class',
                    'side_bars'
                ]
            )
        );
    }

    /**
     * @param Request $request
     * @return array
     */
    public function postAddchild(Request $request)
    {
        $theme = Themes::active()->getActiveLayout();
        $data = $request->all();
        $data['layout_id'] = $theme['key'];
        $rs = $this->page->Addchild($data);
        if ($rs['code'] == '401') {
            return redirect()->back()
                ->withErrors($rs['errors'])
                ->withInput();
        } else {
            $page = $rs['page'];
            $this->helpers->updatesession('Page Added Successfully!', 'alert-success');

            return redirect($this->home . "/update/" . $page->id);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function postChangeparent(Request $request)
    {
        $req = $request->all();
        $parent_id = ($req['item_parent_id'] != 'undefined') ? $req['item_parent_id'] : '0';
        $pag_id = $req['item_id'];

        $page = $this->page->find($pag_id);
        $parent_page = $this->page->find($parent_id);
        if ($parent_page->code == 'home') {
            $new_url = "home/" . class_basename($page->view_url);
        } else {
            $new_url = $parent_page['view_url'] . "/" . class_basename($page->view_url);
        }
        $page = $this->page->updateRich(['parent_id' => $parent_id, 'view_url' => $new_url], $pag_id);

        return $this->page->find($pag_id);
    }

    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postCreate(Request $request)
    {
        $req = $request->all();
        unset($req['_token']);
        $validator = Validator::make(
            $request->all(),
            [
                'title' => 'required|max:255|min:3',
                'view_url' => 'required|max:25|min:3|unique:core_pages,view_url',
            ]
        );
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        } else {
            $req['code'] = str_slug($req['view_url'], "-");
            $this->page->create($req);
            $this->helpers->updatesession('Page Added Successfully!', 'alert-success');
            return redirect($this->home);
        }
    }

    /**
     * @param $id
     * @return View
     */
    public function getUpdate($id)
    {
        $data = $this->page->getPage($id);
        return view('create::front_pages.edit', $data);
    }

    public function getPagePreview($page_id, Request $request)
    {
        $layout = $request->get('pl');
        $main_view = $request->get('mw');
        $isLivePreview = $request->get('pl_live_settings');

        $page = FrontendPage::find($page_id);
        $url = null;
        if (!$page) return redirect()->back();
        if (!str_contains($page->url, '{param}')) $url = $page->url;

        $layouts = CmsItemReader::getAllGearsByType('page_sections')
            ->where('place', 'frontend')
            ->pluck("title", "slug");

        $main_views = CmsItemReader::getAllGearsByType('main_view')
            ->where('place', 'frontend')
            ->pluck("title", "slug");
        // $html = \View::make("ContentLayouts.$layout.$layout")->with(['settings'=>$this->options])->render();
        $lay = ContentLayouts::findVariation($layout);

        if (!$lay) {
            return view('manage::frontend.pages.page-preview', ['data' => compact(['page_id', 'layout', 'page', 'url', 'layouts', 'isLivePreview', 'main_views', 'main_view'])]);
        }

        $view['view'] = "manage::frontend.pages.page-preview";
        $view['variation'] = $lay;
        $data = explode('.', $layout);

        return ContentLayouts::find($data[0])->renderSettings($view, compact(['page_id', 'layout', 'page', 'url', 'layouts', 'isLivePreview', 'main_views', 'main_view']));
    }

    public function getPageTestPreview($page_id, Request $request)
    {
        $layout = $request->get('pl');
        $main_view = $request->get('mw');
        $isLivePreview = $request->get('pl_live_settings');
        if (!$layout) {
            $default = Settings::where('section', 'setting_system')->where('settingkey', 'frontend_page_section')->first();
            if ($default) {
                return redirect('/admin/manage/frontend/pages/page-test-preview/1?pl_live_settings=page_live&pl=' . $default->val);
            }

        }
        $page = FrontendPage::find($page_id);
        $url = null;
        if (!$page) return redirect()->back();
        if (!str_contains($page->url, '{param}')) $url = $page->url;

        $layouts = CmsItemReader::getAllGearsByType('page_sections')
            ->where('place', 'frontend')
            ->pluck("title", "slug");

        $main_views = CmsItemReader::getAllGearsByType('main_view')
            ->where('place', 'frontend')
            ->pluck("title", "slug");
        $settings = $request->except('_token');
        $settings['main_content'] = $page->main_content;
        $data = compact(['page_id', 'layout', 'page', 'url', 'layouts', 'isLivePreview', 'main_views', 'main_view', 'settings']);
        return view('manage::frontend.pages.page-test-preview', compact('settings', 'data'));
    }

    public function postPagePreview($page_id, Request $request)
    {
        $pageLayoutSettings = $request->except(['pl', 'image', 'pl_live_settings', 'layout_id']);
        $data = $request->except(['pl', 'image']);
        $layout_id = $request->get('layout_id');
        $mw = $request->get('mw');
        $header = $request->get('header', 0);
        $footer = $request->get('footer', 0);
        $page = FrontendPage::find($page_id);
        if ($layout_id && !ContentLayouts::findVariation($layout_id)) return \Response::json(['error' => true, 'message' => 'Page Section not found  !!!']);
        if ($mw && !MainBody::findVariation($mw)) return \Response::json(['error' => true, 'message' => 'Main view not found  !!!']);
        $data['page_id'] = $page_id;

        $v = \Validator::make($data, ['page_id' => "exists:frontend_pages,id"]);

        if ($v->fails()) return \Response::json(['error' => true, 'message' => $v->messages()]);
        if ($page) {
            $page->page_layout_settings = (!empty($pageLayoutSettings))  ? $pageLayoutSettings : null;
            $page->page_layout = $layout_id ? $layout_id : NULL;
            $page->save();
            return \Response::json(['error' => false, 'message' => 'Page Layout settings Successfully assigned', 'url' => url('admin/manage/frontend/pages/settings', [$page->id])]);
        }

        return \Response::json(['error' => true, 'message' => 'Page not found  !!!']);
    }

    public function getFieldsByGroup(Request $request)
    {
        $form = Forms::find($request->get('id'));

        if($form){
            if($form->form_type == 'user'){
                $fields = Fields::where('table_name',$form->fields_type)->where('status', Fields::ACTIVE)->where('available_for_users',1)->get()->toArray();
            }else{
                $fields = Fields::where('table_name',$form->fields_type)->where('status', Fields::ACTIVE)->get()->toArray();
            }
            
            return \Response::json(['fields' => $fields]);
        }

        return \Response::json(['error' => true,'message' => 'Form not found']);
    }
}
