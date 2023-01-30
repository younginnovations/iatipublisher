<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\DefaultFormRequest;
use App\Http\Requests\Setting\PublisherFormRequest;
use App\IATI\Services\IatiApiLog\IatiApiLogService;
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
    protected IatiApiLogService $iatiApiLogService;
    protected DatabaseManager $db;

    /**
     * Create a new controller instance.
     *
     * @param OrganizationService $organizationService
     * @param SettingService      $settingService
     * @param IatiApiLogService   $iatiApiLogService
     * @param DatabaseManager     $db
     */
    public function __construct(OrganizationService $organizationService, SettingService $settingService, IatiApiLogService $iatiApiLogService, DatabaseManager $db)
    {
        $this->organizationService = $organizationService;
        $this->settingService = $settingService;
        $this->iatiApiLogService = $iatiApiLogService;
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

            return redirect()->route('admin.activities.index')->with('error', 'Error while rendering setting page');
        }
    }

    /**
     * @return JsonResponse
     */
    public function getSetting(): JsonResponse
    {
        try {
            $setting = $this->settingService->getSetting();

            return response()->json(['success' => true, 'message' => 'Settings fetched successfully', 'data' => $setting]);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

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

            $publisherData['publisher_id'] = Auth::user()->organization->publisher_id;
            $publisherData['publisher_verification'] = ($this->verifyPublisher($publisherData))['validation'];
            $publisherData['token_verification'] = ($this->verifyApi($publisherData))['validation'];
            $message = $publisherData['publisher_verification'] ?
                ($publisherData['token_verification'] ? 'API token verified successfully' : 'API token incorrect. Please enter valid API token.')
                : 'API token incorrect. Please make sure that your publisher is approved in IATI Registry.';
            $success = $publisherData['publisher_verification'] && $publisherData['token_verification'];

            return response()->json(['success' => $success, 'message' => $message, 'data' => $publisherData]);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'Error occurred while verify publisher']);
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

                return response()->json(['success' => true, 'message' => 'Publisher setting stored successfully', 'data' => $publisherData]);
            }

            return response()->json(
                [
                    'success' => false,
                    'message' => 'Error occurred while verifying data',
                    'data'    => $publisherData,
                    'error'   => ['token' => $token_verification, 'publisher_verification' => $publisher_verification],
                ]
            );
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'Error occurred while storing setting']);
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

            return response()->json(['success' => true, 'message' => 'Default setting stored successfully', 'data' => $setting]);
        } catch (\Exception $e) {
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
            $this->iatiApiLogService->store(generateApiInfo('GET', env('IATI_API_ENDPOINT') . '/action/organization_show', $requestOption, $res));
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
                $this->iatiApiLogService->store(generateApiInfo('GET', env('IATI_API_ENDPOINT') . '/action/organization_list_for_user', $requestOptions, $res));
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
                'message' => 'Setting status successfully retrieved.',
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
