<?php
/**
 * Created by PhpStorm.
 * User: Arakelyan
 * Date: 31-Jul-17
 * Time: 18:05
 */

namespace Sahakavatar\Manage\Repository;


use Sahakavatar\Cms\Repositories\GeneralRepository;
use Sahakavatar\Manage\Models\ClassifierItemPage;

class ClassifierItemPageRepository extends GeneralRepository
{
    public function model()
    {
        return new ClassifierItemPage();
    }

}