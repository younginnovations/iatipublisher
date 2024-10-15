<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Setting;

use App\Constants\Enums;
use App\Exceptions\PublisherIdChangeByIatiAdminException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\DefaultFormRequest;
use App\Http\Requests\Setting\PublisherFormRequest;
use App\IATI\Models\Organization\OrganizationOnboarding;
use App\IATI\Services\Organization\OrganizationOnboardingService;
use App\IATI\Services\Organization\OrganizationService;
use App\IATI\Services\Setting\SettingService;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\DatabaseManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use JsonException;
use Throwable;

/**
 * Class SettingController.
 */
class SettingController extends Controller
{
    protected OrganizationService $organizationService;
    protected SettingService $settingService;

    protected DatabaseManager $db;

    /**
     * Create a new controller instance.
     *
     * @param  OrganizationService  $organizationService
     * @param  SettingService  $settingService
     * @param  DatabaseManager  $db
     * @param  OrganizationOnboardingService  $organizationOnboardingService
     */
    public function __construct(OrganizationService $organizationService, SettingService $settingService, DatabaseManager $db, protected OrganizationOnboardingService $organizationOnboardingService)
    {
        $this->organizationService = $organizationService;
        $this->settingService = $settingService;
        $this->db = $db;
    }

    /**
     * Show the organization setting page.
     *
     * @return Factory|View|Application|RedirectResponse
     */
    public function index(): Factory|View|Application|RedirectResponse
    {
        try {
            $currencies = getCodeList('Currency', 'Organization', filterDeprecated: true);
            $languages = getCodeList('Language', 'Organization', filterDeprecated: true);
            $humanitarian = trans('setting.humanitarian_types');
            $budgetNotProvided = getCodeList('BudgetNotProvided', 'Activity', filterDeprecated: true);
            $defaultCollaborationType = getCodeList('CollaborationType', 'Activity', filterDeprecated: true);
            $defaultFlowType = getCodeList('FlowType', 'Activity', filterDeprecated: true);
            $defaultFinanceType = getCodeList('FinanceType', 'Activity', filterDeprecated: true);
            $defaultAidType = getCodeList('AidType', 'Activity', filterDeprecated: true);
            $defaultTiedStatus = getCodeList('TiedStatus', 'Activity', filterDeprecated: true);
            $userRole = Auth::user()->role->role;

            return view('admin.settings.index', compact('currencies', 'languages', 'humanitarian', 'budgetNotProvided', 'userRole', 'defaultCollaborationType', 'defaultFlowType', 'defaultFinanceType', 'defaultAidType', 'defaultTiedStatus'));
        } catch (Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.index')->with('error', 'Error while rendering setting page');
        }
    }

    /**
     * @return JsonResponse
     *
     * @throws GuzzleException
     */
    public function getSetting(): JsonResponse
    {
        $setting = null;

        try {
            $setting = $this->settingService->getSetting();

            $publisherData = [
                'publisher_id' => $setting->publishing_info['publisher_id'],
                'api_token'    => Arr::get($setting->publishing_info, 'api_token', false),
            ];

            $verifyPublisherInfo = $this->verifyPublisher($publisherData);
            $verifyApiInfo = $this->verifyApi($publisherData);
            [$tokenStatus] = $this->getTokenStatusAndMessage($verifyPublisherInfo, $verifyApiInfo);

            $publishing_info = $setting->publishing_info;
            $publishing_info['token_status'] = $tokenStatus;

            $setting->publishing_info = $publishing_info;
            $setting->save();

            return response()->json(['success' => true, 'message' => 'Settings fetched successfully', 'data' => $setting]);
        } catch (Exception $e) {
            logger()->error($e->getMessage());

            if ($e instanceof GuzzleException && $e->getCode() === 404) {
                return response()->json([
                    'success' => false,
                    'message' => 'Publisher does not exist in registry.',
                    'errors' => [
                        'publisher_id' => 'Publisher does not exist in registry.',
                    ],
                    'data' => $setting,
                ]);
            }

            return response()->json(['success' => false, 'message' => 'Error occurred while fetching the data']);
        }
    }

    /**
     * Store publishing info a valid registration.
     *
     * @param PublisherFormRequest $request
     *
     * @return JsonResponse
     * @throws GuzzleException
     */
    public function verify(PublisherFormRequest $request): JsonResponse
    {
        try {
            $publisherData = $request->all();
            $verifyPublisherInfo = $this->verifyPublisher($publisherData);
            $verifyApiInfo = $this->verifyApi($publisherData);

            $publisherData['publisher_verification'] = $verifyPublisherInfo['validation'];
            $publisherData['token_verification'] = $verifyApiInfo['validation'];

            [$tokenStatus, $message] = $this->getTokenStatusAndMessage($verifyPublisherInfo, $verifyApiInfo);
            $publisherData['token_status'] = $tokenStatus;

            return response()->json(['success' => true, 'message' => $message, 'data' => $publisherData]);
        } catch (Exception $e) {
            logger()->error($e);

            $publisherData['publisher_verification'] = false;
            $publisherData['token_verification'] = false;

            if ($e instanceof GuzzleException && $e->getCode() === 404) {
                return response()->json([
                    'success' => false,
                    'message' => 'Publisher does not exist in registry.',
                    'data' => $publisherData,
                     'errors' => [
                        'publisher_id' => 'Publisher does not exist in registry.',
                     ],
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Error occurred while verify publisher',
                'data' => $publisherData,
            ]);
        }
    }

    /**
     * Store publishing info a valid registration.
     *
     * @param PublisherFormRequest $request
     *
     * @return JsonResponse
     * @throws Throwable
     */
    public function storePublishingInfo(PublisherFormRequest $request): JsonResponse
    {
        $this->db->beginTransaction();

        try {
            $settingData = $request->all();

            $verifyPublisherInfo = $this->verifyPublisher($settingData);
            $verifyApiInfo = $this->verifyApi($settingData);

            if (isset($verifyApiInfo['success'])) {
                [$tokenStatus] = $this->getTokenStatusAndMessage($verifyPublisherInfo, $verifyApiInfo);
                $settingData['publisher_verification'] = $verifyPublisherInfo['validation'];
                $settingData['token_status'] = $tokenStatus;
                $settingData['token_verification'] = $tokenStatus === Enums::TOKEN_CORRECT;

                if ($tokenStatus === Enums::TOKEN_INCORRECT) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Your API token is invalid',
                        'data'    => $settingData,
                        'error'   => ['token' => $verifyApiInfo, 'publisher_verification' => $verifyPublisherInfo],
                    ]);
                }

                if (isSuperAdmin()) {
                    $this->organizationService->updateBySuperadmin($settingData);
                } else {
                    $this->settingService->storePublishingInfo($settingData);
                }

                if ($this->organizationOnboardingService->checkPublishingSettingsComplete($settingData)) {
                    $this->organizationOnboardingService->updateOrganizationOnboardingStepToComplete(Auth::user()->organization_id, OrganizationOnboarding::PUBLISHING_SETTINGS, true);
                }

                $this->db->commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Publisher setting stored successfully',
                    'data'    => $settingData,
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Error occurred while verifying data',
                'data'    => $settingData,
                'error'   => ['token' => $verifyApiInfo, 'publisher_verification' => $verifyPublisherInfo],
            ]);
        } catch (Exception $e) {
            $this->db->rollBack();

            logger()->error($e);

            $settingData['publisher_verification'] = false;
            $settingData['token_verification'] = false;

            if ($e instanceof PublisherIdChangeByIatiAdminException) {
                return response()->json(['success' => false, 'message' => 'Publisher Id or API Token incorrect.', 'data' => $settingData]);
            }

            if ($e instanceof GuzzleException && $e->getCode() === 404) {
                return response()->json(['success' => false, 'message' => 'Publisher does not exist in registry.', 'data' => $settingData]);
            }

            return response()->json(['success' => false, 'message' => 'Error occurred while verify publisher', 'data' => $settingData]);
        }
    }

    /**
     * Store default data of organization.
     *
     * @param DefaultFormRequest $request
     *
     * @return JsonResponse
     * @throws Throwable
     */
    public function storeDefaultForm(DefaultFormRequest $request): JsonResponse
    {
        try {
            $this->db->beginTransaction();

            $setting = $this->settingService->storeDefaultValues($request->all());

            $defaultValuesCompleted = $this->organizationOnboardingService->checkDefaultValuesComplete($setting->default_values);
            $this->organizationOnboardingService->updateOrganizationOnboardingStepToComplete(Auth::user()->organization_id, OrganizationOnboarding::DEFAULT_VALUES, $defaultValuesCompleted);

            $this->db->commit();

            return response()->json(['success' => true, 'message' => 'Default setting stored successfully', 'data' => $setting]);
        } catch (Exception $e) {
            $this->db->rollBack();
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'Error occurred while storing setting']);
        }
    }

    /**
     * Verify publisher.
     *
     * @param array $data
     *
     * @return array
     * @throws GuzzleException
     * @throws JsonException
     */
    public function verifyPublisher(array $data): array
    {
        $result = $this->settingService->verifyPublisher($data);
        $state = $result ? $result->state : 'approval_needed';

        return ['success' => true, 'validation' => (bool) $result, 'state' => $state];
    }

    /**
     * Verify publisher.
     *
     * @param array $data
     *
     * @return array
     * @throws GuzzleException
     * @throws JsonException
     */
    public function verifyApi(array $data): array
    {
        if ($data['api_token']) {
            $response = $this->settingService->verifyApi($data);

            return ['success' => true, 'validation' => in_array($data['publisher_id'], array_column($response, 'name'), true)];
        }

        return ['success' => true, 'validation' => false];
    }

    /**
     * Get setting status.
     *
     * @return JsonResponse
     */
    public function getSettingStatus(): JsonResponse
    {
        try {
            $status = $this->settingService->getStatus();

            return response()->json([
                'success' => true,
                'message' => 'Setting status successfully retrieved.',
                'data' => $status,
            ]);
        } catch (Exception $e) {
            logger()->error($e->getMessage());

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Returns token status and message.
     *
     * @param array $verifyPublisherInfo
     * @param array $verifyApiInfo
     *
     * @return string[]
     */
    private function getTokenStatusAndMessage(array $verifyPublisherInfo, array $verifyApiInfo): array
    {
        $message = 'API token incorrect. Please enter valid API token.';
        $tokenStatus = Enums::TOKEN_INCORRECT;

        if ($verifyPublisherInfo['success'] && $verifyPublisherInfo['validation']) {
            if ($verifyApiInfo['success'] && $verifyApiInfo['validation']) {
                $message = 'API token verified successfully.';
                $tokenStatus = Enums::TOKEN_CORRECT;
            } elseif ($verifyPublisherInfo['state'] === 'approval_needed') {
                $message = 'Your account is pending approval by the IATI team - someone should be in touch within two working days.';
                $tokenStatus = Enums::TOKEN_PENDING;
            }
        }

        return [$tokenStatus, $message];
    }
}
