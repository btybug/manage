<?php
/**
 * Created by PhpStorm.
 * User: Comp1
 * Date: 6/15/2017
 * Time: 2:21 PM
 */

namespace App\Modules\Manage\Models;


use App\Models\EventSubscriber\Independent\Independent;
use App\Models\Setting;
use Illuminate\Database\Eloquent\Model;
use App\Http\Middleware\CustomSCMiddleware;

class Emails extends Model
{
    protected $table = 'emails';

    protected $guarded = ['id'];

    protected $dates = ['created_at', 'updated_at'];

    public function group()
    {
        return $this->belongsTo('App\Modules\Manage\Models\EmailGroups', 'group_id');
    }

    public function onFormSubmit($event)
    {
        $this->getConnectionName();
         $middleware=new CustomSCMiddleware();
        $user = $event->user;
        $form = $event->form;
        $entry = $event->entry;

        if ($user && self::setConfig()) {
            \Eventy::action('emil.user', $user);
            \Eventy::action('emil.form', $form);
            \Eventy::action('emil.entry', $entry);
            $emails = self::where('event_code', 'form_submited')->where('trigger_on_form', $form->slug)->get();
            foreach ($emails as $email) {
                $key=$email->content;
                $html=\View::make('emails.1',compact('key'))->render();

                \Mail::queue('emails.1', ['key' =>$middleware->htmlContentHandler($html) ], function ($message) use ($user,$email) {
                    $message->from($email->from_, $name = null);
//                    $message->sender($email->subject, $name = null);
                    $message->to($user->email, $user->username);
                    if(!empty($email->cc)){
                        $ccEmails=explode(',',$email->cc);
                        foreach ($ccEmails as $ccEmail){
                            $message->cc($ccEmail, $name = null);
                        }

                    }
                    if(!empty($email->bcc)){
                        $bccEmails=explode(',',$email->bcc);
                        foreach ($bccEmails as $bccEmail){
                            $message->bcc($bccEmail, $name = null);
                        }

                    }
                    $message->replyTo($email->replyto, $name = null);
                    $message->subject($email->subject);
//                    $message->priority($level);
//                    $message->attach($pathToFile, array $options = []);
                });
            }
        }
    }

    public static function setConfig($flag = false)
    {
        $model = Setting::where('section', 'mail_settings')->pluck('val', 'settingkey')->toArray();
        $configuration = [
            'driver' => self::configKey($model, 'driver'),
            'host' => self::configKey($model, 'host'),
            'port' => self::configKey($model, 'port'),
            'from' => [
                'address' => self::configKey($model, 'from_address'),
                'name' => self::configKey($model, 'from_name'),

            ],
            'username' => self::configKey($model, 'username'),
            'password' => self::configKey($model, 'password'),
            'encryption' => 'tls',
            'sendmail' => '/usr/sbin/sendmail -bs',
        ];
        if (!$flag) {
            if (isset($model['is_invalid']) && (int)$model['is_invalid'] == 0) {
                \Config::set('mail', $configuration);
                return true;
            }

            return false;
        }

        return \Config::set('mail', $configuration);

    }

    public static function configKey(array $model, $key)
    {
        return isset($model[$key]) ? $model[$key] : null;
    }



    public function test($event)
    {
        dd($event);
    }
}