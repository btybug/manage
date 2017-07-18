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

use App\helpers\dbhelper;
use App\helpers\helpers;
use App\Http\Controllers\Controller;
use App\Repositories\AdminsettingRepository as Settings;
use File;
use Illuminate\Http\Request;

/**
 * Class SettingsController
 * @package App\Modules\Frontend\Http\Controllers
 */
class GeneralController extends Controller
{

    /**
     * @var dbhelper|null
     */
    private $dbhelper = null;
    /**
     * @var helpers|null
     */
    private $helpers = null;

    /**
     * @var Settings|null
     */
    private $settings = null;

    /**
     * SettingsController constructor.
     * @param dbhelper $dbhelper
     * @param Settings $settings
     */
    public function __construct (dbhelper $dbhelper, Settings $settings)
    {
        $this->dbhelper = $dbhelper;
        $this->settings = $settings;
        $this->helpers = new helpers();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex ()
    {
        $system = $this->settings->getSystemSettings();

        return view('manage::frontend.general.index', compact(['system']));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postSettings (Request $request)
    {

        $input = $request->except('_token');
        if ($request->file('site_logo')) {
            File::cleanDirectory('resources/assets/images/logo/');
            $name = $request->file('site_logo')->getClientOriginalName();
            $request->file('site_logo')->move('resources/assets/images/logo/', $name);

            $input['site_logo'] = $name;
        }

        $this->settings->updateSystemSettings($input);
        $this->helpers->updatesession('System successfully saved');

        return redirect()->back();
    }
}