<?php
/**
 * Created by PhpStorm.
 * User: Arakelyan
 * Date: 31-Jul-17
 * Time: 18:11
 */

namespace Sahakavatar\Manage\Services;

use Sahakavatar\Cms\Services\GeneralService;
use Sahakavatar\Manage\Repository\ClassifierItemPageRepository;

class ClassifierService extends GeneralService
{
    private $classifierItemPageRepository;

    public function __construct(
        ClassifierItemPageRepository $classifierItemPageRepository
    )
    {
        $this->classifierItemPageRepository = $classifierItemPageRepository;

    }

    public function getClassifierPageRelations(int $pageId)
    {
        return $this->classifierItemPageRepository
            ->model()
            ->where('front_page_id', $pageId)
            ->groupBy('classifier_id')
            ->get();
    }

}