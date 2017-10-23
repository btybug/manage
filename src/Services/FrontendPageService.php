<?php
/**
 * Created by PhpStorm.
 * User: Arakelyan
 * Date: 01-Aug-17
 * Time: 13:59
 */

namespace Sahakavatar\Manage\Services;


use Illuminate\Http\Request;
use Sahakavatar\Cms\Services\GeneralService;
use Sahakavatar\Console\Repository\FrontPagesRepository;
use Sahakavatar\Settings\Repository\AdminsettingRepository;
use Sahakavatar\User\Repository\PermissionRoleRepository;

class FrontendPageService extends GeneralService
{
    private static $frontPages;
    private $frontPagesRepository;
    private $settingsRepository;
    private $permissionRoleRepository;

    public function __construct(
        FrontPagesRepository $frontPagesRepository,
        AdminsettingRepository $settingsRepository,
        PermissionRoleRepository $permissionRoleRepository
    )
    {
        self::$frontPages = $this->frontPagesRepository = $frontPagesRepository;
        $this->settingsRepository = $settingsRepository;
        $this->permissionRoleRepository = $permissionRoleRepository;
    }

    public static function checkAccess($page_id, $role_slug)
    {
        if ($role_slug == SUPERADMIN) return true;
        $page = self::$frontPages->find($page_id);
        $role = self::$frontPages->findBy('slug', $role_slug);
        if ($page && $role) {
            $access = $page->permission_role->where('role_id', $role->id)->first();
            if ($access) return true;
        }

        return false;
    }

    public static function FrontPagesParentPermissionWithRole($page_id, $role_id)
    {
        $page = new FrontPagesRepository();
        $result = $page->find($page_id);
        return $result->parent->permission_role()->where('role_id', $role_id)->first();

    }

    public function saveSettings(
        Request $request
    )
    {
        $page = $this->frontPagesRepository->findOrFail($request->id);
        $attributes = $page->getAttributes();
        $requestData = $request->except('_token', 'roles');
        $data = [];
        foreach ($attributes as $key => $value) {
            if (isset($requestData[$key])) {
                $data[$key] = $requestData[$key];
            }
        }
        $this->frontPagesRepository->update($page->id, $data);

        if ($request->get('page_access') && $request->roles)
            $this->permissionRoleRepository->optimizePageRoles($page, explode(',', $request->roles), 'front');

        return $page;
    }

    public function addNewPage(int $parentID = null)
    {
        $parent = null;
        if ($parentID) {
            $parent = $this->frontPagesRepository->find($parentID);
            if (!$parent) {
                return false;
            }
        }
        $header_enabled = $this->settingsRepository->findBy('settingkey', 'header_enabled');
        $footer_enabled = $this->settingsRepository->findBy('settingkey', 'footer_enabled');
        $defaultPageLayout = $this->settingsRepository->findBy('settingkey', 'page_layout');
        $defaultPageLayoutSettings = $this->settingsRepository->findBy('settingkey', 'placeholders');
        $slug = uniqid();
        $new = $this->frontPagesRepository->create([
            'user_id' => \Auth::id(),
            'title' => 'New Page',
            'slug' => $slug,
            'header' => ($header_enabled) ? $header_enabled->val : 0,
            'footer' => ($footer_enabled) ? $footer_enabled->val : 0,
            'page_layout' => $defaultPageLayout->val,
            'page_layout_settings' => json_decode($defaultPageLayoutSettings->val, true),
            'url' => '',
            'parent_id' => ($parent) ? $parent->id : null,
            'type' => 'custom'
        ]);
        $this->frontPagesRepository->update($new->id, [
            'url' => '/new-page(' . $new->id . ')',
        ]);

        return $new;
    }

    public function getPlaceholdersInUrl($pageLayoutSettings = [])
    {
        if ($pageLayoutSettings) {
            return http_build_query($pageLayoutSettings);
        }
    }


}