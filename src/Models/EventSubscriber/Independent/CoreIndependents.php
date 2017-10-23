<?php
/**
 * Created by PhpStorm.
 * User: menq
 * Date: 6/30/17
 * Time: 9:06 AM
 */

namespace Sahakavatar\Manage\Models\EventSubscriber\Independent;


class CoreIndependents extends Independent
{

    public function Notification($event, $settings)
    {
        \Session::put('alert-class', 'alert-' . $settings['alert_class']);
        \Session::put('message', $settings['message']);
    }

    public function NotificationForm()
    {
        return [
            'alert_class' => [
                'type' => 'select',
                'label' => 'Alert class',
                'data' => ['success' => 'Success', 'info' => 'Info', 'warning' => 'Warning', 'danger' => 'Danger'],
                'value' => 'success'
            ],
            'message' => [
                'type' => 'text',
                'label' => 'Message',
                'value' => 'Hello world'
            ],

        ];
    }

    public function DatesBetween($event, $settings)
    {
        if (isset($settings['start_date'])) {
            $end = $settings['end_date'] == 'now' ? time() : strtotime($settings['end_date']);
            $start = strtotime($settings['start_date']);
            $difference = $end - $start;
            switch ($settings['result_type']) {
                case 'hours':
                    return round($difference / 3600, 1);
                    break;
                case 'seconds':
                    return $difference;
                    break;
                default:
                    return floor($difference / (60 * 60 * 24));
                    break;
            }
        }
        return false;
    }

    public function DatesBetweenForm()
    {
        return [
            'start_date' => [
                'type' => 'text',
                'label' => 'Start Date'
            ],
            'end_date' => [
                'type' => 'text',
                'label' => 'End Date',
                'value' => 'now'
            ],
            'result_type' => [
                'type' => 'select',
                'label' => 'Number of',
                'data' => ['days' => 'Days', 'hours' => 'Hours', 'seconds' => 'Seconds'],
                'value' => 'days'
            ],
        ];
    }

    public function checkUserAge($event, $settings)
    {
        if (isset($settings['age']) && Auth::check()
            && \Auth::user()->profile->age && \Auth::user()->profile->age < $settings['age']) {
            switch ($settings['move_to']) {
                case '404':
                    abort(404);
                    break;
                case '403':
                    abort(403);
                    break;
                case 'logout':
                    Auth::user()->logout();
                    break;
            }
        }
    }

    public function checkUserAgeForm()
    {
        return [
            'age' => [
                'type' => 'text',
                'label' => 'Age'
            ],
            'move_to' => [
                'type' => 'select',
                'label' => 'If < age',
                'data' => ['404' => 'Not found(404)', '403' => 'Access Denied(403)', 'logout' => 'Logout'],
                'value' => '403'
            ],
        ];
    }
}