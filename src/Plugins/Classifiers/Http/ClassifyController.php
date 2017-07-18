<?php
/**
 * Created by PhpStorm.
 * User: Comp1
 * Date: 1/9/2017
 * Time: 4:01 PM
 */

namespace Sahakavatar\Manage\Plugins\Classifiers\Http;
use App\Http\Controllers\Controller;

class ClassifyController extends Controller
{
    public function getIndex()
    {
        return view('Classifiers::index');
}
}