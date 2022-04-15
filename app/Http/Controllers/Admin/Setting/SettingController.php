<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Controller;
use App\IATI\Services\Organization\OrganizationService;
use App\IATI\Services\Setting\SettingService;
use Illuminate\Http\Request;
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
        $this->middleware('auth');
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
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    public function store(Request $request)
    {
        try {
            $this->settingService->store($request->all());

            return response()->json(['success' => 'Settings stored successfully']);
        } catch (\Exception $e) {
            Log::error($e);
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $request
     */
    public function update(Request $request, int $id)
    {
        try {
            $data = $request->all();
            $this->settingService->update($id, $data);

            return response()->json(['success' => 'Settings updated successfully']);
        } catch (\Exception $e) {
            Log::error($e);
        }
    }
}
