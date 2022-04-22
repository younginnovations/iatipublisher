<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\DefaultFormRequest;
use App\Http\Requests\Setting\PublisherFormRequest;
use App\IATI\Services\Organization\OrganizationService;
use App\IATI\Services\Setting\SettingService;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
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

    /*
     * Get setting of the corresponding organization
     *
     * @return JsonResponse
     */
    public function getSetting(): JsonResponse
    {
        try {
            $setting = $this->settingService->getSetting();

            return response()->json(['status' => true, 'message' => 'Settings fetched successfully', 'data' => $setting]);
        } catch (\Exception $e) {
            Log::error($e);

            return response()->json(['status' => false, 'message' => 'Error occurred while fetching the data']);
        }
    }

    /**
     * Store publishing info a valid registration.
     *
     * @param  array  $data
     *
     * @return JsonResponse
     */
    public function storePublishingInfo(PublisherFormRequest $request): JsonResponse
    {
        try {
            $data = $request->all();
            if ($data['publisher_id'] != Auth::user()->organization->publisher_id) {
                return response()->json(['error' => 'Publisher ID cannot be changed', 'data' => $data]);
            }

            $publisher_verification = $this->verifyPublisher($data);
            $token_verification = $this->verifyApi($data);

            if ($publisher_verification['status'] && $token_verification['status']) {
                $data['publisher_verification'] = $publisher_verification['validation'];
                $data['token_verification'] = $token_verification['validation'];
                $this->settingService->storePublishingInfo($data);

                return response()->json(['status' => true, 'message' => 'Publisher setting stored successfully', 'data' => $data]);
            }

            return response()->json(['status' => false, 'message' => 'Error occurred while verifying data', 'data' => $data, 'error'=> ['token' => $token_verification, 'publisher_verification' => $publisher_verification]]);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            Log::error($e);

            return response()->json(['error' => $e]);
        } catch (RequestException $e) {
            Log::error($e->getResponse());

            return response()->json(['error' => $e]);
        } catch (\Exception $e) {
            Log::error($e);

            return response()->json(['status' => false, 'message' => 'Error occurred while storing setting']);
        }
    }

    /**
     * Store default data of organization.
     *
     * @param  request
     *
     * @return JsonResponse
     */
    public function storeDefaultForm(DefaultFormRequest $request): JsonResponse
    {
        try {
            $this->settingService->storeDefaultValues($request->all());

            return response()->json(['status' => true, 'message' => 'Default setting stored successfully']);
        } catch (\Exception $e) {
            Log::error($e);

            return response()->json(['status' => false, 'message' => 'Error occurred while storing setting']);
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
                    'headers' => [
                        'X-CKAN-API-Key' => env('IATI_API_KEY'),
                    ],
                ]
            );

            $res = $client->request('GET', env('IATI_API_ENDPOINT') . '/action/organization_show', [
                'auth' => [env('IATI_USERNAME'), env('IATI_PASSWORD')],
                'query' => ['id' => $data['publisher_id']],
                'connect_timeout' => 500,
            ]);

            $response = json_decode($res->getBody()->getContents())->result;

            return ['status' => true, 'validation' => $response ? true : false];
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return ['status' => 'error', 'message' => $e->getMessage()];
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
            $client = new Client(
                [
                    'base_uri' => env('IATI_API_ENDPOINT'),
                    'headers' => [
                        'X-CKAN-API-Key' => $data['api_token'],
                    ],
                ]
            );

            $res = $client->request('GET', env('IATI_API_ENDPOINT') . '/action/organization_list_for_user', [
                'auth' => [env('IATI_USERNAME'), env('IATI_PASSWORD')],
                'connect_timeout' => 500,
            ]);

            $response = json_decode($res->getBody()->getContents())->result;

            return ['status' => true, 'validation' => in_array($data['publisher_id'], array_column($response, 'name')) ? true : false];
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return ['status' => false, 'message' => $e->getMessage()];
        }
    }
}
