<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Controller;
use App\IATI\Services\Organization\OrganizationService;
use App\IATI\Services\Setting\SettingService;
use Illuminate\Support\Facades\Log;

/**
 * Class SettingController.
 */
class SettingController extends Controller
{
    protected $organizationService;
    protected $settingService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(OrganizationService $organizationService, SettingService $settingService, Log $logger)
    {
        $this->organizationService = $organizationService;
        $this->settingService = $settingService;
        $this->logger = $logger;
    }

    /**
     * Show the organization setting page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        try {
            $currencies = getCodeList('Currency', 'Organization', false);
            $languages = getCodeList('Language', 'Organization', false);
            $humanitarian = trans('setting.humanitarian_types');

            return view('admin.settings.index', compact('currencies', 'languages', 'humanitarian'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('/activities');
        }
    }
}
