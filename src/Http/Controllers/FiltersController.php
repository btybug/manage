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
use App\Models\ExtraModules\Structures;
use App\Repositories\AdminsettingRepository as Settings;
use File;
use Illuminate\Http\Request;


class FiltersController extends Controller
{
    public $filter;

    public function __construct()
    {
        $this->filter = Structures::getAllBbjsons();//json_decode(\File::get(app_path('Core/filter/bb.json')),true);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex(Request $request)
    {

        $type = $request->get('type', 'core');
        $structure = $request->get('structure', '0');
        $slug = $request->slug;

        try {
            $data = $this->filter[$type];
            $current = null;
            $isExists = null;
            $example = null;

            if ($slug && isset($data[$structure][$slug])) {
                $current = $data[$structure][$slug];
            } else {
                $current = array_first(array_first($data));
                $structure = key($data);
            }

            if ($current) {
//                $current['example'] = "<?php echo " . $current['example'] . "; ? >";
//               dd($current);
                (starts_with($current['example'], '<?php echo')) ? $isExists = true : $isExists = false;
            }

        } catch (\Exception $e) {
            abort(404);
        }

        return view('manage::frontend.filters.index', compact(['data', 'current', 'slug', 'isExists', 'type', 'structure']));
    }
}