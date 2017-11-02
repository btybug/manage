<?php namespace Btybug\Manage\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Sahakavatar\Cms\Repositories\MenuRepository;
use Btybug\Console\Http\Requests\Structure\MenuCreateRequest;
use Btybug\Console\Http\Requests\Structure\MenuDeleteRequest;
use Btybug\Console\Http\Requests\Structure\MenuEditRequest;
use Btybug\Console\Repository\AdminPagesRepository;
use Btybug\Console\Services\StructureService;
use Btybug\User\Repository\RoleRepository;


class MenusController extends Controller
{
    public function getIndex(
        Request $request,
        StructureService $structureService,
        RoleRepository $roleRepository,
        MenuRepository $menuRepository
    )
    {
        $slug = $request->p;
        $menus = $menuRepository->getWhereNotPlugins();
        $roles = $roleRepository->getAll();
        $menu = $structureService->getMenuByRequestOrFirst($request);

        return view('manage::frontend.menus.index', compact('menus', 'roles', 'menu', 'slug'));
    }

    public function postCreate(
        MenuCreateRequest $request,
        MenuRepository $menuRepository
    )
    {
        $menuRepository->create([
            'name' => $request->name,
            'creator_id' => \Auth::id(),
            'type' => 'custom',
        ]);

        return back()->with('message', "menu successfully created");
    }

    public function postDelete(
        MenuDeleteRequest $request,
        MenuRepository $menuRepository
    )
    {
        $result = $menuRepository->findOrFail($request->id);
        $success = $result->delete();
        return \Response::json(['success' => $success, 'url' => url('admin/console/structure/menus')]);
    }

    public function getEdit(
        $id, $slug,
        MenuRepository $menuRepository,
        AdminPagesRepository $adminPagesRepository,
        RoleRepository $roleRepository,
        StructureService $structureService
    )
    {
        $menu = $menuRepository->findOrFail($id);
        $page = $adminPagesRepository->first();
        $pageGrouped = $adminPagesRepository->getGroupedWithModule();
        $role = $roleRepository->findBy('slug', $slug);
        $data = $structureService->getMenuItems($menu, $role);

        return view('console::structure.menus.edit', compact(['pageGrouped', 'page', 'slug', 'data', 'menu']));
    }

    public function postEdit(
        $id, $slug,
        MenuEditRequest $request,
        StructureService $structureService,
        MenuRepository $menuRepository,
        RoleRepository $roleRepository
    )
    {
        $menu = $menuRepository->find($id);
        $role = $roleRepository->findBy('slug', $slug);
        $structureService->editMenu($menu, $role, $request);

        return redirect()->to('admin/console/structure/menus');
    }
}