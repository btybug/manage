<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your module. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

//dd(\Subscriber::getSubscriptions());
//event(new \App\Events\CustomEvent());
Route::get('/', function() {
    return view("manage::index");
});

Route::group(['prefix' => 'event'],function () {
    Route::get('/','EventsController@getIndex');
    Route::post('/get-function-data','EventsController@postGetFunctionData');
    Route::post('/get-event-function-relations','EventsController@postGetEventFunctionRelation');
    Route::post('/save-event-function-relations','EventsController@postSaveEventFunctionRelation');
});
Route::get('/test/{id?}',function (\Illuminate\Http\Request $request){
    $v_id=$request->id;
    return view('test',compact('v_id'));
});

Route::get('/test-unit/{id?}',function (\Illuminate\Http\Request $request){
    $v_id=$request->id;
    return view('test-unit',compact('v_id'));
});
//Route::get('/frontend', function() {
//    return view("manage::frontend");
//});
Route::get('/structure', function() {
    return view("manage::structure");
});

Route::group(['prefix' => 'system'],function () {
    Route::get('/form-test','FormTestController@getIndex');
    Route::get('/', 'SystemController@getIndex');
    Route::post('/', 'SystemController@storeSystem');
    Route::get('/login-registration', 'SystemController@getLoginRegistration');
    Route::get('/notifications', 'SystemController@getNotifications');
    Route::get('/url-menger', 'SystemController@getUrlMenger');
    Route::get('/adminemails', 'SystemController@getAdminemails');
    Route::get('/lang', 'SystemController@getLang');
    Route::get('/api-settings', 'SystemController@getApi');
});

Route::group(['prefix' => 'frontend'],function () {

    Route::group(['prefix' => 'general'],function () {
        Route::get('/', 'GeneralController@getIndex');
        Route::post('/', 'GeneralController@postSettings');
    });

    Route::group(['prefix' => 'filters'],function () {
        Route::get('/', 'FiltersController@getIndex');
    });

    Route::group(['prefix' => 'pages'],function () {
        //front pages
        Route::get('/', 'PagesController@getIndex');
//        Route::post('/', 'PagesController@postEdit'); TODO delete
        Route::get('/settings/{id}', 'PagesController@getSettings');
        Route::post('/settings/{id}', 'PagesController@postSettings');
        Route::get('/general/{id}', 'PagesController@getGeneral');
        Route::post('/user-avatar', 'PagesController@postUserAvatar');
        Route::post('/classify', 'PagesController@postClassify');
        Route::post('/new', 'PagesController@postNew');
        Route::get('/new/{parent_id}', 'PagesController@getAddChild');
        Route::post('/detach', 'PagesController@postDetach');
        Route::post('/get-data', 'PagesController@postData');
        Route::post('/delete', 'PagesController@postDelete');

        Route::group(['prefix' => 'page-preview'],function () {
            Route::get('/{id}', 'PagesController@getPagePreview');
            Route::post('/{id}', 'PagesController@postPagePreview');
        });
        Route::get('/page-test-preview/{id}', 'PagesController@getPageTestPreview');
        Route::post('/page-test-preview/{id}', 'PagesController@postPagePreview');

        Route::post('/load-tpl', 'PagesController@loadTpl');
        Route::get('/preview/{layout_id?}/{page_id?}', 'PagesController@getPreview');
        Route::post('/addchild', 'PagesController@postAddchild');
        Route::post('/changeparent', 'PagesController@postChangeparent');
        Route::get('/delete/{id}', 'PagesController@getDelete');
        Route::get('/template/{page}/{template_id}', 'PagesController@getTemplate');
        Route::post('/delete', 'PagesController@postDelete');
        Route::post('/create', 'PagesController@postCreate');
        Route::get('/update/{id}', 'PagesController@getUpdate');
        Route::post('/update', 'PagesController@postUpdate');
        Route::post('/load-layout', 'PagesController@postLoadLayout');
        Route::post('/layouts', 'PagesController@postLayouts');
        Route::post('/template-variations', 'PagesController@postTemplateVariations');
        Route::post('/update-inavtive', 'PagesController@postUpdateInavtive');
        Route::post('/update-customiser', 'PagesController@postUpdateCustomiser');
        Route::post('/layout-sidebar-counts', 'PagesController@postLayoutSidebarCounts');
        Route::post('/load-area', 'PagesController@postLoadArea');
        Route::post('/apply-area', 'PagesController@postApplyArea');
        Route::post('/membership-list/{id?}', 'PagesController@postMembershipList');
        Route::post('/list/{id?}', 'PagesController@postList');
        Route::post('/partial-access/{id?}', 'PagesController@postPartialAccess');
        Route::post('/get-fields-by-group', 'PagesController@getFieldsByGroup');
    });
    Route::group(['prefix' => 'classify'],function () {

        Route::get('/', 'ClassifyController@getIndex');
        Route::post('/', 'ClassifyController@postEditTerm');

        Route::post('/create', 'ClassifyController@postCreate');
        Route::post('/edit/{id}', 'ClassifyController@postEdit');
        Route::post('/delete', 'ClassifyController@postDelete');
        Route::post('/delete-item', 'ClassifyController@postDeleteItem');
        Route::post('/term-create', 'ClassifyController@postTermCreate');
        Route::post('/term-edit/{id}', 'ClassifyController@postTermEdit');
//        Route::post('/variations', 'ClassifyController@postVariations');
//        Route::get('/edit/{id}', 'ClassifyController@getEdit');

        Route::get('/delete/{id}', 'ClassifyController@getDelete');
        Route::post('/delterm', 'ClassifyController@postDelterm');

        Route::post('/mngchild', 'ClassifyController@postMngchild');
        Route::post('/changeparent', 'ClassifyController@postChangeparent');
        Route::get('/data', 'ClassifyController@getData');
        Route::post('/get-taxonomy-form', 'ClassifyController@postTaxonomyForm');
        Route::post('/generate-term', 'ClassifyController@postGenerateForm');
    });

    Route::group(['prefix' => 'menus'],function () {
        Route::get('/', 'MenuFrontController@getIndex');
        Route::get('/create', 'MenuFrontController@getCreate');
        Route::post('/create', 'MenuFrontController@postCreate');
        Route::get('/update/{id}', 'MenuFrontController@getUpdate');
        Route::post('/update', 'MenuFrontController@postUpdate');
        Route::post('/addmenuitem', 'MenuFrontController@postAddmenuitem');
        Route::post('/changeparent', 'MenuFrontController@postChangeparent');
        Route::post('/delmenuitem', 'MenuFrontController@postDelmenuitem');
        Route::get('/html', 'MenuFrontController@getHtml');
        Route::get('/delete/{id}', 'MenuFrontController@getDelete');
        Route::get('/data', 'MenuFrontController@getData');
        Route::get('/menufile', 'MenuFrontController@getMenufile');
        Route::get('/sidebarmenus', 'MenuFrontController@getSidebarmenus');
    });


});
Route::group(['prefix'=>'emails'],function (){
    Route::get('/settings',"EmailsController@getSettings");
    Route::post('/settings',"EmailsController@postSettings");
    Route::get('/update/{id?}',"EmailsController@getUpdate");
    Route::post('/update/{id}',"EmailsController@postUpdate");
    Route::get('/data/{id}',"EmailsController@getData");
    Route::get('/{id?}',"EmailsController@getIndex");

    Route::post('/create-group',"EmailsController@postCreateGroup");
    Route::post('/get-forms-lists',"EmailsController@postGetFormLists");
    Route::post('/get-forms-shortcodes',"EmailsController@getFormShortcodes");
    Route::post('/create-email',"EmailsController@postCreateEmail");
    Route::post('/delete-email/{id}',"EmailsController@postDeleteEmail");
    Route::post('check-email-settings',"EmailsController@postCheckEmail");


});

