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

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Response;
use Sahakavatar\Cms\Helpers\helpers;
use Sahakavatar\Manage\Models\FrontendPage;
use Sahakavatar\Settings\Models\Settings;
use Sahakavatar\User\User;
use Validator;
use View;

/**
 * Class PageController
 *
 * @package Sahakavatar\Tools\Http\Controllers
 */
class PagesControllerOLD extends Controller
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

        $pages = FrontendPage::all();

        if ($pageID) {
            $page = FrontendPage::find($pageID);
        } else {
            $page = FrontendPage::first();
        }

        if ($page && !$page->page_section) $page->page_section = 0;

        $admins = User::admins()->pluck('username', 'id')->toArray();

        return view('manage::frontend.pages.index', compact(['page', 'pages', 'admins']));
    }

    public function postUserAvatar(Request $request)
    {
        return Response::json(['url' => BBGetUserAvatar($request->id)]);
    }

    public function postNew(Request $request)
    {
        $new = FrontendPage::create([
            'user_id' => \Auth::id(),
            'title' => 'New Page',
            'slug' => uniqid(),
            'url' => ''
        ]);

        if ($new) return redirect()->to($this->home . '?p=' . $new->id)->with('message', 'Congratulations: New Page Created Successfully');

        return redirect()->back()->with('message', 'Page not Created');
    }

    public function postEdit(Request $request)
    {
        $data = $request->except('_token', 'type');
        $validator = Validator::make($data, [
            'id' => 'exists:frontend_pages,id',
            'title' => 'required'
        ]);

        if ($validator->fails()) return redirect()->back()->withErrors($validator->errors());

        (starts_with($data['url'], '/')) ? false : $data['url'] = "/" . $data['url'];
        $page = FrontendPage::find($data['id']);
        $data['edited_by'] = Auth::id();
        $page->update($data);

        return redirect()->back()->with('message', 'Successfully Updated Page');
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
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function getDelete($id)
    {
        $page = Corepage::find($id);
        $page->delete();

        return redirect($this->home);
    }

    /**
     * @param Request $request
     */
    public function postDelete(Request $request)
    {
        $req = $request->all();
        $id = $req['id'];
        //$ids_arr = explode(',', $req['ids']);
        //if (is_array($ids_arr)) {
        //  foreach ($ids_arr as $id) {
        $page = Corepage::find($id);
        $page->delete();


        $this->helpers->removeUrl($id);
        //}
        //}
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

    /**
     * @param Request $request
     * @return string
     */
    public function postTemplateVariations(Request $request)
    {
        $req = $request->all();
        $variations = $this->getTemplateVariations($req['templateID']);

        return $this->helpers->ddbyarray($variations);
    }


    /**
     * @param $template_id
     * @param $section_id
     * @return array|null
     */
    public function getTemplateVariationsForSection($template_id, $section_id)
    {
        return BBGetSectionVariations($template_id, $section_id);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postUpdate(Request $request)
    {

        $page = $this->page->find($request->get('id'));
        if ($page) {
            foreach ($page->getAttributes() as $key => $v) {
                if ($request->get($key)) $data[$key] = $request->get($key);
            }
            $data['data_option'] = json_encode($request->except('_token'), true);
        }
        $rs = $page->update($data);
        if ($rs) return Response::json(['error' => false]);
        return Response::json(['error' => true]);
    }

    /**
     * @param $page
     * @param $template_id
     * @return View
     */
    public function getTemplate($page, $template_id)
    {
        $template = $this->helpers->getTemplateData($template_id);
        $file = $this->helpers->tplCreate($template_id, '', 'admin_preview');
        $template_data = view($file);

        // Customiser path
        $customiser = [];
        $customiser_path = 'appdata/resources/custom_templates/' . $template->folder_name . '/customiser.php';
        if (file_exists($customiser_path)) {
            $customiser = (include $customiser_path);
        }

        $settings = [];
        // Get template settings
        $templateSettings = Settings::where(
            ['settingkey' => $page . '_' . $template_id, 'section' => 'template_settings']
        );
        if ($templateSettings->first() !== null) {
            $settings = unserialize($templateSettings->first()->val);
        }

        return view(
            'tools::pages.customise',
            compact('template_id', 'template', 'template_data', 'page', 'settings', 'customiser')
        );
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postUpdateCustomiser(Request $request)
    {
        $page = $request->input('page');
        $template = $request->input('template');

        $templateSettings = Settings::where(
            ['settingkey' => $page . '_' . $template, 'section' => 'template_settings']
        );

        $data = $request->all();
        unset($data['_token'], $data['page'], $data['template']);

        if ($templateSettings->first() !== null) {
            $setting = Settings::find($templateSettings->first()->id);
        } else {
            $setting = new Settings;
        }

        $setting->section = 'template_settings';
        $setting->settingkey = $page . '_' . $template;
        $setting->val = serialize($data);
        // Save
        $setting->save();

        // Redirect to customiser
        return redirect(url('/admin/tools/page/template/' . $page . '/' . $template));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postUpdateInavtive(Request $request)
    {
        if (empty($request->get('groups'))) {
            $groups = Groups::all();
        } else {
            $g = explode(',', $request->get('groups'));
            $groups = Groups::WhereIn('id', $g)->get();
        }

        $page = $request->get('page');
        if (isset($page) && empty($page)) {
            $pages = Corepage::lists('title', 'id')->toArray();
        } else {
            $pages = Corepage::where('id', '!=', $request->get('page'))->lists('title', 'id')->all();
        }

        $view = View::make('tools::pages._ajaxgroups')->with('inactiveGroups', $groups)->with('pages', $pages)->render();

        return Response::json(['html' => $view, 'error' => false]);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function postLayouts(Request $request)
    {
        $id = $request->get('id');
        $layout = Layouts::find($id);

        return $layout;
    }


    /**
     * @param Request $request
     * @return int
     */
    public function postLayoutSidebarCounts(Request $request)
    {
        $layout = Layouts::find($request->get('id'));
        if ($layout) {
            $count = $layout->has_sidebar1 + $layout->has_sidebar2;

            return $count;
        }

        return 0;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function loadTpl(Request $request)
    {
        $id = $request->get('id');

        $slug = explode('.', $id);
        $template_id = $slug[0];
        $variation_id = $slug[1];
        $variation = Tpl::findVariation($id);

        $tpl = Tpl::find($template_id);
        $section = $tpl->section();

        $data = $tpl->render(compact(['variation', 'section']));

        return Response::json(['data' => $data]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postLoadLayout(Request $request)
    {

        $id = $request->get('id');
        $data = Layouts::find($id)->getAttributes();

        $body = $data['body'];
        $layout_view = $data['layoutView'];
        $sidebars = Sidebar::get();

        return view('tools::pages._partials.layout', compact(['layout_view', 'body', 'sidebars']));//$data;

        /*if ($layout = Layouts::find($id)) {
            return Response::json(['data' => $layout, 'error' => false]);
        }

        return Response::json(['message' => 'Layout not found', 'error' => true]);*/
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postLoadArea(Request $request)
    {
        $data_type = $request->get('data_type');

        $sidebar = SidebarTypes::find($data_type);
        if ($sidebar) {
            $variations = $sidebar->sidebars()->lists('sidebars.id', 'sidebars.name')->all();

            return Response::json(['data' => $variations, 'error' => false]);
        }

        return Response::json(['message' => 'An error occurred', 'error' => true]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postApplyArea(Request $request)
    {
        $id = $request->get('id');

        return Response::json(['data' => BBRenderSidebars($id), 'error' => false]);
    }

    public function postMembershipList(Request $request, $id)
    {
        $membership = MemberGroups::general()->get();

        $html = view('tools::pages._partials.membership_list')->with('membership', $membership)->render();

        return Response::json(['data' => $html, 'error' => false]);
    }

    public function postList(Request $request, $id)
    {
        $pages = $this->page->getPageListExcept($id);

        return Response::json(['data' => $pages, 'error' => false]);
    }

    public function postPartialAccess(Request $request, $id)
    {
        $page = $this->page->getPage($id);

        dd(Layouts::find($page['model']['layout_id'])->getAttributes());
        dd($data = Layouts::find($id)->getAttributes());
    }
}
