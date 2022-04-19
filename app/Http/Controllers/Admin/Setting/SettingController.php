<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\DefaultFormRequest;
use App\Http\Requests\Setting\PublisherFormRequest;
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
     * Show the application setting page.
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
            Log::error($e);
        }
    }

    /**
     * Get setting of the corresponding organization.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getSetting()
    {
        try {
            $setting = $this->settingService->getSetting();

            return response()->json(['success' => 'Settings stored successfully', 'data' => $setting]);
        } catch (\Exception $e) {
            Log::error($e);
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    public function storePublishingInfo(PublisherFormRequest $request)
    {
        try {
            $this->settingService->storePublishingInfo($request->all());

            return response()->json(['success' => 'Settings stored successfully']);
        } catch (\Exception $e) {
            Log::error($e);
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    public function storeDefaultForm(DefaultFormRequest $request)
    {
        try {
            $this->settingService->storeDefaultValues($request->all());

            return response()->json(['success' => 'Settings stored successfully']);
        } catch (\Exception $e) {
            Log::error($e);
        }
    }
}
