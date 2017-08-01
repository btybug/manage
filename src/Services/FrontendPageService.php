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

class FrontendPageService extends GeneralService
{
    private $frontPagesRepository;
    private $settingsRepository;

    public function __construct(
        FrontPagesRepository $frontPagesRepository,
        AdminsettingRepository $settingsRepository
    )
    {
        $this->frontPagesRepository = $frontPagesRepository;
        $this->settingsRepository = $settingsRepository;
    }

    public function saveSettings(
        Request $request
    )
    {
        $page = $this->frontPagesRepository->findOrFail($request->id);
        $this->frontPagesRepository->update($page->id, [
            'page_layout' => $request->page_section ? $request->page_section : NULL,
            'page_layout_settings' => $request->placeholders ? $request->placeholders : NULL,
            'header' => $request->header,
            'footer' => $request->footer,
            'url' => $request->url,
            'title' => $request->title,
            'status' => $request->status,
            'page_access' => $request->page_access,
            'main_content' => $request->main_content
        ]);
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
        $defaultPageLayout = $this->settingsRepository->findBy('settingkey', 'frontend_page_section');
        $slug = uniqid();
        $new = $this->frontPagesRepository->create([
            'user_id' => \Auth::id(),
            'title' => 'New Page',
            'slug' => $slug,
            'header' => ($header_enabled) ? $header_enabled->val : 0,
            'footer' => ($footer_enabled) ? $footer_enabled->val : 0,
            'page_layout' => $defaultPageLayout->val,
            'url' => '',
            'parent_id' => ($parent) ? $parent->id : null,
            'type' => 'custom'
        ]);
        $this->frontPagesRepository->update($new->id, [
            'url' => '/new-page(' . $new->id . ')',
        ]);

        return $new;
    }

    public function getPlaceholdersInUrl(array $pageLayoutSettings)
    {
        if ($pageLayoutSettings) {
            return http_build_query($pageLayoutSettings);
        }
    }

}