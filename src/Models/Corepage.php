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

namespace Sahakavatar\Manage\Models;

use Sahakavatar\Cms\Helpers\helpers;
use Illuminate\Database\Eloquent\Model;

//use Sahakavatar\Theme\SidebarTypes;
class Corepage extends Model
{
    protected $helpers;
    protected $table = 'core_pages';
    protected $guarded = ['id'];
    /**
     * The attributes which using Carbon.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

    protected static function boot ()
    {

        parent::boot();
        static::deleting(
            function ($model) {
                if (($model->urlmanager)) {
                    $manager = $model->urlmanager;
                    $manager->delete();
                }
            }
        );
    }


    public function getDates ()
    {
        return ['created_at', 'updated_at'];
    }

    public function template ()
    {
        return $this->belongsTo('Sahakavatar\Assets\Template', 'page_tpl');
    }

    public function customsidebar ()
    {
        // return $this->belongsTo('App\Models\Customsidebar','side_bar_id');
    }

    public function parent ()
    {
        return $this->belongsTo('Sahakavatar\Create\Models\Corepage', 'parent_id');
    }

    public function taxonomy ()
    {
        return $this->belongsTo('App\Models\Taxonomy', 'taxonomy_id');
    }

    public function groups ()
    {
        return $this->belongsToMany('Sahakavatar\User\Groups', 'page_groups', 'page_id', 'group_id');
    }

    public function urlmanager ()
    {
        return $this->hasOne('App\Models\Urlmanager', 'page_id');
    }

    public function dataOption ($data, $req)
    {

        if (empty($this->data_option)) {
            $layoutOptions = json_decode($data, true);
            $newOption = [];
            foreach ($layoutOptions as $layoutOption) {
                $newOption[key($layoutOption)] = $layoutOption[key($layoutOption)];
            }
            $this->data_option = json_encode($newOption);
        }
        if (isset($req['sidebarplcdetails'])) {
            $types = $req['sidebarplcdetails'];
            $layouts = SidebarTypes::whereIn('id', array_keys($types))->lists('slug', 'id');
            $data_option = json_decode($this->data_option, true);
            foreach ($layouts as $key => $value) {
                $data_option[$value] = $types[$key];
            }
            $this->data_option = json_encode($data_option);
        }

        return ($this->data_option);
    }

    public function members ()
    {
        return $this->belongsToMany('Sahakavatar\Membership\Models\MemberGroups', 'pages_memberships_permissions', 'page_id', 'membership_id');
    }

    /**
     * @param $type
     * @return array
     */
    public function getPagesbytype ($type)
    {
        $pages = [];
        $rs = self::where('page_type', $type)
            ->select(
                'id',
                'title',
                'code',
                'slug',
                'view_url',
                'system_page',
                'status',
                'visibility',
                'parent_id',
                'page_type'
            )
            ->where('parent_id', 0)
            ->orderBy('id', 'desc')
            ->get();

        foreach ($rs as $main_page) {
            $data = $main_page->toArray();

            if (count($main_page->childs)) {
                foreach ($main_page->childs as $subchilds) {
                    $subdata = $subchilds->toArray();
                    if (count($subchilds->childs)) {
                        foreach ($subchilds->childs as $childs) {
                            $subdata['children'][] = $this->childs($childs); //$this->getchilds($childs);
                        }
                    }
                    $data['children'][] = $subdata;
                }
            }
            $pages[] = $data;
        }

        return $pages;
    }

    public function childs ()
    {
        return $this->hasMany('Sahakavatar\Create\Models\Corepage', 'parent_id');
    }

    public function getPages ($parent_id = 0)
    {
        $pages = [];
        $rs = self::select(
            'id',
            'title',
            'code',
            'slug',
            'view_url',
            'system_page',
            'status',
            'visibility',
            'parent_id',
            'page_type'
        )
            ->where('parent_id', $parent_id)
            ->orderBy('id', 'desc')
            ->get();

        foreach ($rs as $main_page) {
            $data = $main_page->toArray();
            $data['url'] = $this->getUrl($main_page);

            if (count($main_page->childs)) {
                foreach ($main_page->childs as $subchilds) {
                    $subdata = $subchilds->toArray();

                    $subdata['url'] = $this->getUrl($subchilds);

                    if (count($subchilds->childs)) {
                        foreach ($subchilds->childs as $childs) {
                            $subdata['children'][] = $this->childs($childs); //$this->getchilds($childs);
                        }
                    }
                    $data['children'][] = $subdata;
                }
            }
            $pages[] = $data;
        }

        return $pages;
    }

    public function getUrl ($page)
    {
        $url = '';
        if (count($page->urlmanager)) {
            $url = url($page->urlmanager->url);
        }

        return $url;
    }

    /**
     * Provides Full Details of given page
     *
     * @param $id
     * @return array
     */
    public function getPage ($id)
    {
        $status = $this->getStatus();
        $visibility = $this->getVisibility();

        $page = self::find($id);
        if ($page) {
            \Eventy::action('curent.page', $page);
            $parent_url = '';
            if ($page->parnt) {
                $parent_url = @$page->parnt->view_url;
            }
            $model = $page->toArray();
//            $layouts = Layouts::lists('title', 'id');
            $userGroups = [];//Groups::lists('title', 'id')->toArray();
//            foreach ($layouts as $key => $value) {
//                $layout[$key] = $value;
//            }
            $selected_ug = $this->getSelectedUg($model['user_group']);

            $membership = [];//MemberGroups::general()->get();
            return compact(
                [
                    'model',
                    'page',
                    'parent_url',
                    'userGroups',
                    'status',
                    'visibility',
                    'user_groups',
                    'selected_ug',
                    'membership'
                ]
            );
        } else {
            return null;
        }
    }

    public function getStatus ()
    {
        return ['draft' => 'Draft', 'pending' => 'Pending Review', 'published_public_access' => 'Published - Public access', 'published_membership_access' => 'Published - membership access'];
    }

//    public function childs($obj)
//    {
//        $data = $obj->toArray();
//        $data['url'] = $this->getUrl($obj);
//        if (count($obj->childs)) {
//            foreach ($obj->childs as $childs) {
//                $child_arr = $childs->toArray();
//                $child_arr['url'] = $this->getUrl($childs);
//                $data['children'][] = $child_arr;
//            }
//        }
//
//        return $data;
//    }

    public function getVisibility ()
    {
        return ['Yes' => 'Yes', 'No' => 'No'];
    }

    public function getSelectedUg ($grps)
    {
        $selected_ug = [];
        $user_groups = ($grps != '') ? unserialize($grps) : '';
        if (is_array($user_groups)) {
            foreach ($user_groups as $group) {
                $selected_ug[$group] = $group;
            }
        }

        return $selected_ug;
    }

    public function updatePage ($request)
    {
        $check = Urlmanager::where('url', $request->view_url)
            ->where('page_id', '!=', $request->id)
            ->first();
        if ($check) {
            return false;
        } else {
            $data = $request->only(
                'title',
                'layout_id',
                'data_option',
                'view_url',
                'status',
                'visibility',
                'user_group'

            );
            $data['data_option'] = json_decode($data['data_option'], true);
            $data['data_option']['main_body'] = $request->get('variation');
            $data['data_option'] = json_encode($data['data_option'], true);
            $data['user_group'] = (isset($data['user_group'])) ? serialize($data['user_group']) : null;

            self::where('id', $request->id)->update($data);
            $this->helpers->updateUrl($request->id, $request->view_url, 'custom_page');

            return true;
        }
    }

    /**
     * Add New Page
     *
     * @param Request $request
     * @return array
     */
    public function Addchild ($request)
    {
        $req = $request;


        $validator = \Validator::make(
            $req,
            [
                'title'    => 'required|max:255|min:3',
                'view_url' => 'required|max:25|min:3|unique:urlmanager,url',
            ]
//            [
//                'view_url.alpha_num_spaces' => 'View Url can contain letters, numbers,spaces and hyphens (-).'
//            ]
        );
        if ($validator->fails()) {
            return ['code' => '401', 'errors' => $validator->errors()->all()];
        } else {
            $parent = self::find($req['parent_id']);
            $req['view_url'] = class_basename($req['view_url']);
            if ($parent) {
                $parent = $parent->toArray();
                $req['slug'] = $req['view_url'];
                $req['code'] = $parent['code'] . '_' . str_slug($req['title'], '_');
                if ($parent['code'] == 'home') {
                    $req['view_url'] = 'home/' . $req['view_url'];
                } else {
                    $req['view_url'] = $parent['view_url'] . '/' . $req['view_url'];
                }
            } else {
                $req['view_url'] = str_slug(strtolower($req['view_url']), '-');
                $req['code'] = str_slug($req['title'], '_');
            }
            $page = self::create($req);
            $this->helpers = new helpers();
            $this->helpers->addUrl($page->id, $req['view_url'], 'custom_page');

            return ['code' => '200', 'page' => $page];
        }

    }

    public function getPageSideBars ($id)
    {
        $data = [];
        $page = self::find($id);
        $data_option = json_decode($page->data_option, true);
        foreach ((array)$data_option as $key => $val) {
            if ($key != 'main_body') {
                $data[$key] = $this->getSideBar($val);
            }
        }

        return $data;
    }

    /**
     * @param $id
     * @return string
     */
    public function getSideBar ($id)
    {
        $side_bar_data = "";
        if (File::exists(config('paths.CACHE') . "sidebars/" . $id . ".blade.php")) {
            $side_bar_data = File::get(config('paths.CACHE') . "sidebars/" . $id . ".blade.php");
        }

        return $side_bar_data;
        /*$pages = $this->getPages(72);
        $data = '<a href="/my_account"/><div class="m-t-10">My Account</div></a>';
        foreach ($pages as $page) {
            $data .= ' <a href="' . $page['url'] . '"/><div>&nbsp;' . $page['title'] . '</div></a>';
            if (isset($page['children'])) {
                foreach ($page['children'] as $page) {
                    $data .= ' <a href="' . $page['url'] . '"/><div>&nbsp;&nbsp;' . $page['title'] . '</div></a>';
                    if (isset($page['children'])) {
                        foreach ($page['children'] as $page) {
                            $data .= ' <a href="' . $page['url'] . '"/><div>&nbsp;&nbsp;&nbsp;' . $page['title'] . '</div></a>';
                        }
                    }
                }
            }
        }*/

        //return $data;
    }

    /**
     * Read Layout Json against given id and
     * Return Layout object
     *
     * @param $layout_id
     * @return mixed
     */
    public function getLayout ($layout_id)
    {
        $layoutObject = BBgetLayoutJson($layout_id);
        $layout = (object)[];
        $layout->settings_css = '';
        $layout->settings_data = '';

        $layout->has_header = 0;
        if ($layoutObject['layoutView']['header']) {
            $layout->has_header = 1;
        }

        $layout->has_footer = 0;
        if ($layoutObject['layoutView']['footer']) {
            $layout->has_footer = 1;
        }

        $layout->has_sidebar1 = 0;
        if ($layoutObject['layoutView']['sidebar1']) {
            $layout->has_sidebar1 = 1;
        }

        $layout->has_sidebar2 = 0;
        if ($layoutObject['layoutView']['sidebar2']) {
            $layout->has_sidebar2 = 1;
        }

        $layout->body = $layoutObject['body'];

        return $layout;
    }
}
