<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\DefaultFormRequest;
use App\Http\Requests\Setting\PublisherFormRequest;
use App\IATI\Services\Organization\OrganizationService;
use App\IATI\Services\Setting\SettingService;
use GuzzleHttp\Client;
use Illuminate\Database\DatabaseManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
     * @param OrganizationService $organizationService
     * @param SettingService      $settingService
     * @param Log                 $logger
     * @param DatabaseManager     $db
     */
    public function __construct(OrganizationService $organizationService, SettingService $settingService, Log $logger, DatabaseManager $db)
    {
        $this->organizationService = $organizationService;
        $this->settingService = $settingService;
        $this->db = $db;
        $this->logger = $logger;
    }

    /**
     * Show the organization setting page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(): \Illuminate\Contracts\Support\Renderable
    {
        try {
            $currencies = getCodeListArray('Currency', 'OrganizationArray');
            $languages = getCodeList('Language', 'Organization');
            $humanitarian = trans('setting.humanitarian_types');

            return view('admin.settings.index', compact('currencies', 'languages', 'humanitarian'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('/activities');
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
            $success = $publisherData['publisher_verification'] && $publisherData['token_verification'] ? true : false;

            return response()->json(['success' => $success, 'message' => $message, 'data' => $publisherData]);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'Error occurred while verify publisher']);
        }
    }

    /**
     * Store publishing info a valid registration.
     *
     * @param array $data
     *
     * @return JsonResponse
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
     * @param request
     *
     * @return JsonResponse
     */
    public function storeDefaultForm(DefaultFormRequest $request): JsonResponse
    {
        try {
            $this->db->beginTransaction();

            $setting = $this->settingService->storeDefaultValues($request->all());

            $this->db->commit();

            return response()->json(['success' => true, 'message' => 'Default setting stored successfully', 'data' => $setting]);
        } catch (\Exception $e) {
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

            $res = $client->request('GET', env('IATI_API_ENDPOINT') . '/action/organization_show', [
                'auth'            => [env('IATI_USERNAME'), env('IATI_PASSWORD')],
                'query'           => ['id' => $data['publisher_id']],
                'connect_timeout' => 500,
            ]);

            $response = json_decode($res->getBody()->getContents())->result;

            return ['success' => true, 'validation' => $response ? true : false];
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

                $res = $client->request('GET', env('IATI_API_ENDPOINT') . '/action/organization_list_for_user', [
                    'auth'            => [env('IATI_USERNAME'), env('IATI_PASSWORD')],
                    'connect_timeout' => 500,
                ]);

                $response = json_decode($res->getBody()->getContents())->result;

                return ['success' => true, 'validation' => in_array($data['publisher_id'], array_column($response, 'name')) ? true : false];
            }

            return ['success' => true, 'validation' => false];
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
