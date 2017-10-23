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
use Datatables;
use File;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Sahakavatar\User\Models\Roles;
use Table;
use TableView;
use Validator;

class old extends Controller
{
    public function getIndex(
        Request $request
    )
    {
        $type = "backend";
        $menu = $request->get('p');
        $menus = [];

        if (count($menus)) if (!$menu) $menu = $menus[0]->getBasename('.json');

        $roles = Roles::where('slug', '!=', 'user')->get();


        return view('manage::frontend.menus.index', compact(['type', 'menus', 'roles', 'menu']));
    }

    public function getCreate()
    {
        $pages = $this->page->getPages();

        return view('manage::frontend.menus.create', compact(['pages']));
    }

    public function postCreate(Request $request)
    {
        $data = $request->all();
        $data = [
            'name' => $data['name'],
            'html_data' => $data['html_data'],
            'json_data' => $data['json_data'],
            'section' => 'frontend'
        ];
        $v = \Validator::make($data, ['name' => 'required', 'html_data' => 'required', 'json_data' => 'required']);
        if ($v->fails()) return redirect()->back()->withErrors($v->errors());

        if ($menu = Menu::create($data)) {
            $this->helper->updatesession('Menu saved successfully!!!', 'alert-success');

            return redirect()->to('admin/manage/frontend/menus');
        }

        $this->helper->updatesession('Try later!!!', 'alert-danger');

        return redirect()->back();
    }

    public function getUpdate($id)
    {
        $menu = Menu::find($id);

        if (!$menu) return redirect()->back();

        $pages = $this->page->getPages();

        return view('manage::frontend.menus.edit', compact(['pages', 'menu']));
    }

    /**
     * This function update menu table with new data
     *
     * @param Request $request
     * @return type
     */
    public function postUpdate(Request $request)
    {
        $data = $request->all();
        $menu = Menu::find($data['id']);

        if (!$menu) return \Response::json(['error' => true, 'message' => 'Menu does not exists']);

        $data = [
            'name' => $data['name'],
            'html_data' => $data['html_data'],
            'json_data' => $data['json_data']
        ];

        $v = \Validator::make($data, ['name' => 'required', 'html_data' => 'required', 'json_data' => 'required']);
        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors());
        }

        $updated = $menu->update($data);
        if ($updated) {
            $this->helper->updatesession('Menu ' . $data['name'] . ' updated successfully!!!', 'alert-success');

            return redirect()->to('admin/manage/frontend/menus');
        }

        $this->helper->updatesession('Try later!!!', 'alert-danger');
        return redirect()->back();
    }

    /**
     * Change the parent of menu and put it under different parent
     *
     * @param Request $request , Having menu id and its parent id
     * @return term object
     */
    public function postAddmenuitem(Request $request)
    {
        $req = $request->all();
        $details = json_decode(stripslashes($req['itemDetails']), true);
        $data = [];
        foreach ($details as $detail) {
            $data[$detail['name']] = $detail['value'];
        }

        $link_type = $data['link_type'];
        if ($link_type == 'corepage') {
            $data['url'] = $data['editcorepage'];
        } elseif ($link_type == 'custompage') {
            $data['url'] = $data['editcustompage'];
        } else {
            $data['url'] = $data['text_link'];
        }

        if (!isset($data['new_link'])) {
            $data['new_link'] = 'off';
        }

        $item_id = $data['item_id'];

        //Remove extra values from data
        unset($data['editcorepage']);
        unset($data['editcustompage']);
        unset($data['text_link']);
        unset($data['item_id']);

        //Different Validations for Add and update record
        $validator = Validator::make(
            $data,
            [
                'title' => 'required|max:255|min:3',
            ]
        );

        if ($validator->fails()) {
            return ['code' => '401', 'errors' => $validator->errors()->all()];
        } else {

            //Add or update menu
            if ($item_id > 0) {
                $this->menuedata->updateRich($data, $item_id);
                $menuitem = $this->menuedata->find($item_id);
            } else {
//                 dd($data);
                $menuitem = $this->menuedata->create($data);
            }

            return ['code' => '200', 'menuitem' => $this->chelper->list_menues([$menuitem])];
        }
    }

    /**
     * Change the parent of menu and put it under different parent
     *
     * @param Request $request , Having menu id and its parent id
     * @return term object
     */
    public function postChangeparent(Request $request)
    {
        $req = $request->all();
        $menu_id = $req['id'];
        $parent = $req['parent_id'];
        $this->menuedata->updateRich(['parent_id' => $parent], $menu_id);
        $menuitem = $this->menuedata->find($menu_id);

        return ['code' => '200', 'menuitem' => $this->chelper->list_menues([$menuitem])];
    }

    /**
     * Delete Menu item and all its Childs from System
     *
     * @param Request $request ,Have Term Id in Request
     * @return null
     */
    public function postDelmenuitem(Request $request)
    {
        $req = $request->all();
        $id = $req['id'];
        if ($id) {
            $item = $this->menuedata->find($id);
            if ($item) {
                $item->children()->delete();
                $this->menuedata->delete($id);
            }
        }
    }

    public function getHtml($id)
    {
        return menuHtml($id, 'before');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getDelete($id)
    {
        $menu = Menu::find($id);

        if (!$menu) return redirect()->back();

        $menu->delete();
        $this->helper->updatesession('Menu ' . $menu->name . ' deleted successfully!!!', 'alert-success');

        return redirect()->back();
    }

//Bulk Delete
    public function postDelete(Request $request)
    {
        $req = $request->all();
        $ids_arr = explode(",", $req['ids']);
        if (is_array($ids_arr)) {
            foreach ($ids_arr as $id) {
                $this->menu->delete($id);
            }
        }
    }

    public function getData()
    {

        $data = $this->menu->all();
        $obj = Datatables::of($data);
        $obj->addColumn(
            'action',
            $this->dhelp->actionBtns(
                [
                    'edit' => ['link' => '/admin/manage/frontend/menus/update/{!! $id !!}'],
                    'delete' => ['link' => '/admin/manage/frontend/menus/delete/{!! $id !!}'],

                ]
            )
        );
        $obj = $obj->make(true);

        return $obj;
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function getMenufile($id)
    {
        $menu = $this->dhelp->formatCustomFld($this->menu->find($id));
        $menudata = $this->chelper->list_menues($this->menuedata->findMenusData($menu->id));
        $data = $this->chelper->getMenuHtml($menudata, true, 'title', 'menus');
        File::put('public/tmp/menu.html', $data);

        return response()->download('public/tmp/menu.html');
    }

    /**
     * Provides All Front end Menues for showing in Side bars
     *
     */
    public function getSidebarmenus()
    {
        $menus = $this->menu->findAllBy('section', 'front_end');

        $data = [];

        foreach ($menus as $menu) {
            $filename = config('paths.FRONT_MENU') . $menu->id . '.json';
            $filename_html = config('paths.FRONT_MENU') . $menu->id . '.html';

            if (File::exists($filename)) {
                $json_data = File::get($filename);
            } else {
                $json_data = '';
            }

            if (File::exists($filename_html)) {
                $html_data = File::get($filename_html);
            } else {
                $html_data = '';
            }
            $menu_css = ClassesVariations::find($menu->menu_class);
            if ($menu_css) {
                $menu_css = $menu_css->css_data;
            } else {
                $menu_css = '';
            }
            $data[] = [
                'id' => $menu->id,
                'title' => $menu->title,
                'json_data' => $json_data,
                'html_data' => $html_data,
                'cssc_lass' => $menu_css
            ];

        }

        return view('manage::frontend.menus.sidebarmenus', compact(['data']));
    }


}
