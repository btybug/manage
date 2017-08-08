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
use Sahakavatar\Manage\Repository\ClassifierRepository;

class ClassifierService extends GeneralService
{
    private $classifierRepository;
    private $classifierItemPageRepository;

    public function __construct(
        ClassifierRepository $classifierRepository,
        ClassifierItemPageRepository $classifierItemPageRepository
    )
    {
        $this->classifierRepository = $classifierRepository;
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

    public function classifierItems()
    {
        return $this->classifierRepository
            ->model()
            ->classifierItem()
            ->pluck('title', 'id')
            ->toArray();
    }

}