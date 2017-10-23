<?php

namespace Sahakavatar\Manage\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Sahakavatar\Cms\Repositories\HookRepository;


/**
 * Class HooksController
 * @package Sahakavatar\Manage\Http\Controllers
 */
class HooksController extends Controller
{
    /**
     * @param HookRepository $hookRepository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex(
        HookRepository $hookRepository
    )
    {
        $hooks = $hookRepository->getAll();

        return view('manage::frontend.hooks.index', compact(["hooks"]));
    }

    public function getEdit(
        $id,
        HookRepository $hookRepository
    )
    {
        $hook = $hookRepository->findOrFail($id);
        return view('manage::frontend.hooks.edit', compact(["hook"]));
    }
}