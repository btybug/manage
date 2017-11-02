<?php
/**
 * Created by PhpStorm.
 * User: menq
 * Date: 6/28/17
 * Time: 12:06 PM
 */

namespace Btybug\Manage\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class EventsController extends Controller
{
    public function getIndex()
    {
        $subscriber = \Subscriber::getSubscriptions();
        return view('manage::events.index', compact('subscriber'));
    }

    public function postGetFunctionData(Request $request)
    {
        $namespace = $request->get('namespace');
        if ($namespace) {
            $data = \Subscriber::getForm($namespace);
            return \Response::json(['data' => $data, 'error' => false]);
        }
        return \Response::json(['error' => true, 'message' => 'namespace is mandatory']);
    }

    public function postSave(Request $request)
    {
        dd($request->all());
    }

    public function postGetEventFunctionRelation(Request $request)
    {
        $f_name = $request->get('function_namespace');
        $e_name = $request->get('event_namespace');
        $form = \Subscriber::getForm($f_name);
        $subscripts = \Subscriber::getSubscriptions()->getData();
        $tabs = [];
        if (isset($subscripts[$e_name])) {
            foreach ($subscripts[$e_name] as $key => $value) {
                if (strpos($key, $f_name) === 0) {
                    $tabs[] = $value;
                }

            }
        }
        return \Response::json(['form' => $form, 'tabs' => $tabs]);
    }

    public function postSaveEventFunctionRelation(Request $request)
    {
        $f_name = $request->get('function_namespace');
        $e_name = $request->get('event_namespace');
        $settings = $request->get('setting');
        $subscripts = \Subscriber::clean($e_name, $f_name);
        foreach ($settings as $setting) {
            \Subscriber::add($e_name, $f_name, $setting);
        }
        \Subscriber::save();
        return \Response::json(['error' => false]);

    }

}