<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\DefaultFormRequest;
use App\Http\Requests\Setting\PublisherFormRequest;
use App\IATI\Services\ApiLog\ApiLogService;
use App\IATI\Services\Organization\OrganizationService;
use App\IATI\Services\Setting\SettingService;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\DatabaseManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

/**
 * Class SettingController.
 */
class SettingController extends Controller
{
    protected OrganizationService $organizationService;
    protected SettingService $settingService;
    protected ApiLogService $apiLogService;
    protected DatabaseManager $db;

    /**
     * Create a new controller instance.
     *
     * @param OrganizationService $organizationService
     * @param SettingService      $settingService
     * @param ApiLogService   $apiLogService
     * @param DatabaseManager     $db
     */
    public function __construct(OrganizationService $organizationService, SettingService $settingService, ApiLogService $apiLogService, DatabaseManager $db)
    {
        $this->organizationService = $organizationService;
        $this->settingService = $settingService;
        $this->apiLogService = $apiLogService;
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
            $currencies = getCodeListArray('Currency', 'OrganizationArray');
            $languages = getCodeList('Language', 'Organization');
            $humanitarian = trans('setting.humanitarian_types');
            $budgetNotProvided = getCodeList('BudgetNotProvided', 'Activity');
            $userRole = Auth::user()->role->role;

            return view('admin.settings.index', compact('currencies', 'languages', 'humanitarian', 'budgetNotProvided', 'userRole'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.index')->with('error', trans('responses.error_has_occurred_page', ['event'=>trans('events.rendering'), 'suffix'=>trans('responses.setting')]));
        }
    }

    /**
     * @return JsonResponse
     */
    public function getSetting(): JsonResponse
    {
        try {
            $setting = $this->settingService->getSetting();

            return response()->json(['success' => true, 'message' => ucfirst(trans('responses.event_successfully', ['prefix'=>trans('settings.settings_label'), 'event'=>trans('events.fetched')])), 'data' => $setting]);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => trans('responses.error_has_occurred', ['event'=>trans('events.fetching'), 'suffix'=>trans('responses.the_data')])]);
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

            $publisherData['publisher_id'] = Auth::user()->organization->publisher_id;
            $publisherData['publisher_verification'] = ($this->verifyPublisher($publisherData))['validation'];
            $publisherData['token_verification'] = ($this->verifyApi($publisherData))['validation'];
            $message = $publisherData['publisher_verification'] ?
                ($publisherData['token_verification'] ? trans('responses.event_successfully', ['prefix'=>trans('responses.api_token'), 'event'=>trans('events.verified')]) : trans('responses.api_token_incorrect') . ' ' . trans('responses.enter_valid_api_token'))
                : trans('responses.api_token_incorrect') . ' ' . trans('responses.make_sure_publisher_is_approved');
            $success = $publisherData['publisher_verification'] && $publisherData['token_verification'];

            return response()->json(['success' => $success, 'message' => $message, 'data' => $publisherData]);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => trans('responses.error_has_occurred', ['event'=>trans('events.verifying'), 'suffix'=>trans('elements_common.publisher')])]);
        }
    }

    /**
     * Store publishing info a valid registration.
     *
     * @param PublisherFormRequest $request
     *
     * @return JsonResponse
     * @throws \Throwable
     */
    public function storePublishingInfo(PublisherFormRequest $request): JsonResponse
    {
        try {
            $publisherData = $request->all();
            $publisherData['publisher_id'] = Auth::user()->organization->publisher_id;
            $publisher_verification = $this->verifyPublisher($publisherData);
            $token_verification = $this->verifyApi($publisherData);

            if (isset($token_verification['success'])) {
                $publisherData['publisher_verification'] = $publisher_verification['validation'];
                $publisherData['token_verification'] = $token_verification['validation'];

                $this->db->beginTransaction();

                $this->settingService->storePublishingInfo($publisherData);

                $this->db->commit();

                return response()->json(['success' => true, 'message' => ucfirst(trans('responses.event_successfully', ['prefix'=>trans('responses.publisher_settings'), 'event'=>trans('events.stored')])), 'data' => $publisherData]);
            }

            return response()->json(
                [
                    'success' => false,
                    'message' => trans('responses.error_has_occurred', ['event'=>trans('events.verifying'), 'suffix'=>trans('responses.the_data')]),
                    'data'    => $publisherData,
                    'error'   => ['token' => $token_verification, 'publisher_verification' => $publisher_verification],
                ]
            );
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => trans('responses.error_has_occurred', ['event'=>trans('events.storing'), 'suffix'=>trans('responses.setting')])]);
        }
    }

    /**
     * Store default data of organization.
     *
     * @param DefaultFormRequest $request
     *
     * @return JsonResponse
     * @throws \Throwable
     */
    public function storeDefaultForm(DefaultFormRequest $request): JsonResponse
    {
        try {
            $this->db->beginTransaction();

            $setting = $this->settingService->storeDefaultValues($request->all());

            $this->db->commit();

            return response()->json(['success' => true, 'message' => ucfirst(trans('responses.event_successfully', ['prefix'=>trans('responses.default_settings'), 'event'=>trans('events.stored')])), 'data' => $setting]);
        } catch (\Exception $e) {
            $this->db->rollBack();
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => trans('responses.error_has_occurred', ['event'=>trans('events.storing'), 'suffix'=>trans('responses.setting')])]);
        }
    }

    /**
     * Verify publisher.
     *
     * @param array $data
     *
     * @return array
     * @throws GuzzleException
     */
    public function verifyPublisher(array $data): array
    {
        try {
            $client = new Client(
                [
                    'base_uri' => env('IATI_API_ENDPOINT'),
                    'headers'  => [
                        'X-CKAN-API-Key' => env('IATI_API_KEY'),
                    ],
                ]
            );
            $requestOption = [
                'auth'            => [env('IATI_USERNAME'), env('IATI_PASSWORD')],
                'query'           => ['id' => $data['publisher_id']],
                'connect_timeout' => 500,
            ];

            $res = $client->request('GET', env('IATI_API_ENDPOINT') . '/action/organization_show', $requestOption);
            $this->apiLogService->store(generateApiInfo('GET', env('IATI_API_ENDPOINT') . '/action/organization_show', $requestOption, $res));
            $response = json_decode($res->getBody()->getContents(), false, 512, JSON_THROW_ON_ERROR)->result;

            return ['success' => true, 'validation' => (bool) $response];
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return ['success' => 'error', 'message' => $e->getMessage()];
        }
    }

    /**
     * Verify publisher.
     *
     * @param array $data
     *
     * @return array
     * @throws GuzzleException
     */
    public function verifyApi(array $data): array
    {
        try {
            if ($data['api_token']) {
                $client = new Client(
                    [
                        'base_uri' => env('IATI_API_ENDPOINT'),
                        'headers'  => [
                            'X-CKAN-API-Key' => $data['api_token'],
                        ],
                    ]
                );
                $requestOptions = [
                    'auth'            => [env('IATI_USERNAME'), env('IATI_PASSWORD')],
                    'connect_timeout' => 500,
                ];

                $res = $client->request('GET', env('IATI_API_ENDPOINT') . '/action/organization_list_for_user', $requestOptions);
                $this->apiLogService->store(generateApiInfo('GET', env('IATI_API_ENDPOINT') . '/action/organization_list_for_user', $requestOptions, $res));
                $response = json_decode($res->getBody()->getContents(), false, 512, JSON_THROW_ON_ERROR)->result;

                return ['success' => true, 'validation' => in_array($data['publisher_id'], array_column($response, 'name'), true)];
            }

            return ['success' => true, 'validation' => false];
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return ['success' => false, 'message' => $e->getMessage()];
        }
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
                'message' => ucfirst(trans('responses.event_successfully', ['prefix'=>trans('responses.setting_status'), 'event'=>trans('events.retrieved')])),
                'data' => $status,
            ]);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
