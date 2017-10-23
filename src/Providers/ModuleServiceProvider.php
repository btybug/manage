<?php

namespace Sahakavatar\Manage\Providers;

//use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{


    /**
     * Bootstrap the module services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        $this->loadTranslationsFrom(__DIR__ . '/../Resources/Lang', 'manage');
        $this->loadViewsFrom(__DIR__ . '/../Resources/Views', 'manage');

        $tubs = [
            'manage_settings' => [
                [
                    'title' => 'General',
                    'url' => '/admin/manage/system',
                ],
                [
                    'title' => 'Notifications',
                    'url' => '/admin/manage/system/notifications',
                ],
                [
                    'title' => 'URL menger',
                    'url' => '/admin/manage/system/url-menger',
                ],
                [
                    'title' => 'Admin Emails',
                    'url' => '/admin/manage/system/adminemails',
                ],
                [
                    'title' => 'Api settings',
                    'url' => '/admin/manage/system/api-settings',
                ],
                [
                    'title' => 'Language',
                    'url' => '/admin/manage/system/lang',
                ]
            ],
            'frontend_manage' => [
                [
                    'title' => 'General',
                    'url' => '/admin/manage/frontend/general',
                ],
                [
                    'title' => 'Pages',
                    'url' => '/admin/manage/frontend/pages',
                ],
                [
                    'title' => 'Menus',
                    'url' => '/admin/manage/frontend/menus',
                ],
                [
                    'title' => 'Classify',
                    'url' => '/admin/manage/frontend/classify',
                ],
                [
                    'title' => 'Filters',
                    'url' => '/admin/manage/frontend/filters',
                ],
                [
                    'title' => 'Hooks',
                    'url' => '/admin/manage/frontend/hooks',
                ]
            ],
            'page_edit' => [
                [
                    'title' => 'Settings',
                    'url' => '/admin/manage/frontend/pages/settings/{id}',
                ], [
                    'title' => 'General',
                    'url' => '/admin/manage/frontend/pages/general/{id}',
                ],
            ],
            'manage_emails' => [
                [
                    'title' => 'Emails',
                    'url' => '/admin/manage/emails/{id}',
                ], [
                    'title' => 'Settings',
                    'url' => '/admin/manage/emails/settings',
                ],
            ]
        ];
        \Eventy::action('my.tab', $tubs);
        \Sahakavatar\Cms\Models\Routes::registerPages('sahak.avatar/manage');

    }

    /**
     * Register the module services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(EventServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);
    }
}
