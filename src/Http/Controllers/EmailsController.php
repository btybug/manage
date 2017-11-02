<?php
/**
 * Created by PhpStorm.
 * User: Comp1
 * Date: 6/15/2017
 * Time: 11:47 AM
 */

namespace Btybug\Manage\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Btybug\Manage\Models\EmailGroups;
use Btybug\Manage\Models\Emails;
use Btybug\Modules\Models\Forms;
use Yajra\Datatables\Datatables;

class EmailsController extends Controller
{
    const VALID = 0;
    const INVALID = 1;
    const NOTCHECKED = 2;

    /**
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex($id = 0)
    {
        $groups = EmailGroups::all();
        if (!$id) {
            $first = EmailGroups::first();
            if ($first) {
                $id = $first->id;
            }
        }
        return view('manage::emails.index', compact('groups', 'id'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getSettings()
    {
        Emails::setConfig();
        $model = Setting::where('section', 'mail_settings')->pluck('val', 'settingkey');
        return view('manage::emails.settings', compact('model'));
    }


    public function postSettings(Request $request)
    {
        $data = $request->except('_token');
        $MailSettings = [];
        foreach ($data as $key => $datum) {
            $MailSettings['section'] = 'mail_settings';
            $MailSettings['settingkey'] = $key;
            $MailSettings['val'] = $datum;
            if (Setting::where('section', 'mail_settings')->where('settingkey', $key)->exists()) {
                Setting::where('section', 'mail_settings')->where('settingkey', $key)->update($MailSettings);
            } else {
                Setting::create($MailSettings);
            }

        }
        $MailSettings['section'] = 'mail_settings';
        $MailSettings['settingkey'] = 'is_invalid';
        $MailSettings['val'] = self::NOTCHECKED;
        if (Setting::where('section', 'mail_settings')->where('settingkey', 'is_invalid')->exists()) {
            Setting::where('section', 'mail_settings')->where('settingkey', 'is_invalid')->update($MailSettings);

        } else {
            Setting::create($MailSettings);
        }
        return redirect()->back();
    }

    public function postGetFormLists(Request $request)
    {
        $forms = Forms::all()->pluck('name', 'slug')->toArray();
        $html = \View::make('manage::emails._partial.form_lists', compact('forms'))->render();
        return \Response::json(['error' => false, 'html' => $html]);
    }

    /**
     * @param null $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getUpdate($id = null)
    {
        $forms = Forms::all()->pluck('name', 'slug')->toArray();
        $email = Emails::findOrFail($id);
        return view('manage::emails.update', compact('email', 'forms'));
    }

    public function postUpdate(Request $request)
    {
        $email = Emails::findOrFail($request->id);
        $email->update($request->except('_token'));
        return redirect()->back();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getData($id)
    {
        $emails = Emails::where('group_id', $id);
        $obj = Datatables::of($emails);
        $obj->addColumn(
            'action', function ($email) {
            return '<a href="' . url('/admin/manage/emails/update', $email->id) . '" class="btn btn-default btn-warning btn-xs"><i class="fa fa-cog set-iconz"></i></a>
<a data-href="' . url('/admin/manage/emails/delete-email', $email->id) . '"  data-key="' . $email->id . '" data-type="Email ' . $email->name . '" type="button" class="btn btn-danger delete-button btn-primary btn-xs"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>';
        }
        );
        $obj = $obj->make(true);
        return $obj;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postCreateGroup(Request $request)
    {

        $validator = \Validator::make($request->all(), ['name' => 'required|unique:email_groups,name']);

        if (!$validator->fails()) {
            $name = $request->get('name', false);
            $slug = strtolower(str_replace(' ', '_', $name));
            $data = ['name' => $name, 'slug' => $slug, 'type' => 'custom'];
            $group = EmailGroups::create($data);
            $html = \View::make('manage::emails._partial.group_input', compact('group'))->render();
            return \Response::json(['error' => false, 'html' => $html]);
        }
        return \Response::json(['error' => true, 'message' => $validator->messages()]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postCreateEmail(Request $request)
    {
        $data = $request->except('_token');
        $validator = \Validator::make($request->all(), [
            'name' => 'required|unique:emails,name',
            'group_id' => 'required|integer|exists:email_groups,id']);
        if (!$validator->fails()) {
            $email = Emails::create($data);
            return \Response::json(['error' => false]);
        }
        return \Response::json(['error' => true, 'message' => $validator->messages()]);
    }

    public function postDeleteEmail($id)
    {
        if (Emails::find($id)->delete()) {
            return \Response::json(['success' => true]);
        }
        return \Response::json(['success' => false]);

    }

    public function postCheckEmail(Request $request)
    {
        $data = $request->except('_token');
        $v = \Validator::make($data, ['email' => 'required|email']);
        if ($v->fails()) {
            return \Response::json(['error' => true, 'code' => 4]);
        }
        try {
            Emails::setConfig(true);
            \Mail::send('emails.1', ['key' => 'checking settings'], function ($message) use ($data) {
                $message->to($data['email'], 'jon')->subject('test!');
            });
        } catch (\Exception $e) {
            if (Setting::where('section', 'mail_settings')->where('settingkey', 'is_invalid')->exists()) {
                Setting::where('section', 'mail_settings')->where('settingkey', 'is_invalid')->update([
                    'section' => 'mail_settings',
                    'settingkey' => 'is_invalid',
                    'val' => self::INVALID
                ]);
            } else {
                Setting::create([
                    'section' => 'mail_settings',
                    'settingkey' => 'is_invalid',
                    'val' => self::INVALID
                ]);
            }
            return \Response::json(['code' => self::INVALID, 'message' => $e->getMessage()]);
        }
        if (Setting::where('section', 'mail_settings')->where('settingkey', 'is_invalid')->exists()) {
            Setting::where('section', 'mail_settings')->where('settingkey', 'is_invalid')->update([
                'section' => 'mail_settings',
                'settingkey' => 'is_invalid',
                'val' => self::VALID]);
        } else {
            Setting::create([
                'section' => 'mail_settings',
                'settingkey' => 'is_invalid',
                'val' => self::VALID
            ]);
        }

        return \Response::json(['code' => self::VALID]);
    }

    public function getFormShortcodes(Request $request)
    {
        $shortcodes = [];
        $form = Forms::where('slug', $request->form_slug)->first();
        if ($form) {
            $tableData = BBGetTableColumn($form->fields_type);
            foreach ($tableData as $column)
                $shortcodes[$column] = '[special key=' . $column . ']';
        }
        $html = view('manage::emails._partial.specific_shortcodes', compact(['shortcodes']))->render();
        return \Response::json(['html' => $html]);
    }
}

