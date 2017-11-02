<?php
/**
 * Created by PhpStorm.
 * User: Arakelyan
 * Date: 31-Jul-17
 * Time: 17:50
 */

namespace Btybug\Manage\Repository;

use Sahakavatar\Cms\Repositories\GeneralRepository;
use Btybug\Manage\Models\Classifier;


class ClassifierRepository extends GeneralRepository
{

    public function model()
    {
        return new Classifier();
    }

}