<?php

declare(strict_types=1);

namespace App\IATI\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;

/**
 * Class MigrateSettingTrait.
 */
trait MigrateSettingTrait
{
    /**
     * Returns setting data for IATI organization.
     *
     * @param $aidstreamOrganizationSetting
     * @param $iatiOrganization
     *
     * @return array
     *
     * @throws \JsonException|GuzzleException
     */
    public function getNewSetting($aidstreamOrganizationSetting, $iatiOrganization): array
    {
        return [
            'organization_id'         => $iatiOrganization->id,
            'publishing_info'         => $this->getPublishingInfo(
                $aidstreamOrganizationSetting->registry_info,
                $iatiOrganization->publisher_id
            ),
            'default_values'          => $this->getDefaultValues($aidstreamOrganizationSetting->default_field_values),
            'activity_default_values' => $this->getActivityDefaultValues(
                $aidstreamOrganizationSetting->default_field_values
            ),
            'created_at'              => $aidstreamOrganizationSetting->created_at,
            'updated_at'              => $aidstreamOrganizationSetting->updated_at,
        ];
    }

    /**
     * Returns publishing info information for IATI organization setting.
     *
     * @param $registryInfo
     * @param $iatiPublisherId
     *
     * @return array|null
     *
     * @throws \JsonException|GuzzleException
     */
    public function getPublishingInfo($registryInfo, $iatiPublisherId): ?array
    {
        if (!$registryInfo) {
            return null;
        }

        $registryInfoArray = json_decode($registryInfo, true, 512, JSON_THROW_ON_ERROR);

        if (!$registryInfoArray) {
            return null;
        }

        $data = [
            'publisher_id'            => !empty(Arr::get($registryInfoArray, '0.publisher_id', null)) ? Arr::get(
                $registryInfoArray,
                '0.publisher_id',
                null
            ) : $iatiPublisherId,
            'api_token'               => Arr::get($registryInfoArray, '0.api_id', null),
            'publisher_verification'  => Arr::get($registryInfoArray, '0.publisher_id_status', null) === 'Correct',
            'token_verification'      => Arr::get($registryInfoArray, '0.api_id_status', null) === 'Correct',
            'isVerificationRequested' => true,
        ];

        $this->logInfo('Started verifying publisher and token on IATI registry.');
        $validateSettings = $this->verify($data);
        unset($data['isVerificationRequested']);
        $validatedData = $validateSettings->getData();

        if ($validatedData->success === true) {
            $data['publisher_verification'] = true;
            $data['token_verification'] = true;
            $this->logInfo('Finished verifying publisher and token on IATI registry.');

            return $data;
        }

        $data['publisher_verification'] = !($validatedData->message === 'Error occurred while verify publisher' || $validatedData->message === 'API token incorrect. Please make sure that your publisher is approved in IATI Registry.');
        $data['token_verification'] = false;
        $this->logInfo('Publisher and token invalid on IATI registry.');

        return $data;
    }

    /**
     * Returns default values for IATI Organization settings.
     *
     * @param $aidstreamDefaultValues
     *
     * @return array|null
     *
     * @throws \JsonException
     */
    public function getDefaultValues($aidstreamDefaultValues): ?array
    {
        if (!$aidstreamDefaultValues) {
            return null;
        }

        $aidstreamDefaultValuesArray = json_decode($aidstreamDefaultValues, true, 512, JSON_THROW_ON_ERROR);

        if (!$aidstreamDefaultValuesArray) {
            return null;
        }

        return [
            'default_currency' => Arr::get($aidstreamDefaultValuesArray, '0.default_currency', null),
            'default_language' => Arr::get($aidstreamDefaultValuesArray, '0.default_language', null),
        ];
    }

    /**
     * Returns activity default values for IATI Organization settings.
     *
     * @param $aidstreamDefaultValues
     *
     * @return array|null
     *
     * @throws \JsonException
     */
    public function getActivityDefaultValues($aidstreamDefaultValues): ?array
    {
        if (!$aidstreamDefaultValues) {
            return null;
        }

        $aidstreamDefaultValuesArray = json_decode($aidstreamDefaultValues, true, 512, JSON_THROW_ON_ERROR);

        if (!$aidstreamDefaultValuesArray) {
            return null;
        }

        return [
            'hierarchy'           => !is_null(
                Arr::get($aidstreamDefaultValuesArray, '0.default_hierarchy', null)
            ) ? Arr::get(
                $aidstreamDefaultValuesArray,
                '0.default_hierarchy',
                null
            ) : '1',
            'humanitarian'        => !is_null(
                Arr::get($aidstreamDefaultValuesArray, '0.humanitarian', null)
            ) ? Arr::get(
                $aidstreamDefaultValuesArray,
                '0.humanitarian',
                null
            ) : '1',
            'budget_not_provided' => Arr::get($aidstreamDefaultValuesArray, '0.budget_not_provided', null),
        ];
    }

    /**
     * Store publishing info a valid registration.
     *
     * @param $publisherData
     *
     * @return JsonResponse
     *
     * @throws GuzzleException
     */
    public function verify($publisherData): JsonResponse
    {
        try {
            $publisherData['publisher_verification'] = Arr::get(
                $this->verifyPublisher($publisherData),
                'validation',
                false
            );
            $publisherData['token_verification'] = Arr::get($this->verifyApi($publisherData), 'validation', false);
            $message = $publisherData['publisher_verification'] ?
                ($publisherData['token_verification'] ? 'API token verified successfully' : 'API token incorrect. Please enter valid API token.')
                : 'API token incorrect. Please make sure that your publisher is approved in IATI Registry.';

            $success = $publisherData['publisher_verification'] && $publisherData['token_verification'];

            return response()->json(['success' => $success, 'message' => $message, 'data' => $publisherData]);
        } catch (\Exception $e) {
            logger()->channel('migration')->error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'Error occurred while verify publisher']);
        }
    }

    /**
     * Verify publisher.
     *
     * @param  array  $data
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
            $this->apiLogService->store(
                generateApiInfo('GET', env('IATI_API_ENDPOINT') . '/action/organization_show', $requestOption, $res)
            );
            $response = json_decode($res->getBody()->getContents(), false, 512, JSON_THROW_ON_ERROR)->result;

            return ['success' => true, 'validation' => (bool) $response];
        } catch (\Exception $e) {
            logger()->channel('migration')->error($e->getMessage());

            return ['success' => 'error', 'message' => $e->getMessage()];
        }
    }

    /**
     * Verify publisher.
     *
     * @param  array  $data
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

                $res = $client->request(
                    'GET',
                    env('IATI_API_ENDPOINT') . '/action/organization_list_for_user',
                    $requestOptions
                );
                $this->apiLogService->store(
                    generateApiInfo(
                        'GET',
                        env('IATI_API_ENDPOINT') . '/action/organization_list_for_user',
                        $requestOptions,
                        $res
                    )
                );
                $response = json_decode($res->getBody()->getContents(), false, 512, JSON_THROW_ON_ERROR)->result;

                return [
                    'success'    => true,
                    'validation' => in_array($data['publisher_id'], array_column($response, 'name'), true),
                ];
            }

            return ['success' => true, 'validation' => false];
        } catch (\Exception $e) {
            logger()->channel('migration')->error($e->getMessage());

            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Returns publisher_id from settings table.
     *
     * @param $aidStreamOrganizationSetting
     * @param $userIdentifier
     *
     * @return string
     *
     * @throws \JsonException
     */
    public function getSettingsPublisherId($aidStreamOrganizationSetting, $userIdentifier): string
    {
        $registryInfo = $aidStreamOrganizationSetting->registry_info;

        if ($registryInfo) {
            $registryInfo = json_decode($registryInfo, true, 512, JSON_THROW_ON_ERROR);

            return Arr::get($registryInfo, '0.publisher_id', $userIdentifier);
        }

        return $userIdentifier;
    }

    /**
     * Updates settings if needed.
     *
     * @param $iatiOrganization
     * @param $aidstreamSettings
     *
     * @return object|null
     *
     * @throws GuzzleException
     *
     * @throws \JsonException
     */
    public function updateSettingsIfNeeded($iatiOrganization, $aidstreamSettings): ?object
    {
        $iatiSettings = $iatiOrganization->settings;

        if (!$iatiSettings && $aidstreamSettings) {
            $this->logInfo("Started creating settings for organization: {$iatiOrganization->id}.");
            $this->settingService->create(
                $this->getNewSetting($aidstreamSettings, $iatiOrganization)
            );
            $this->logInfo("Finished creating settings for organization: {$iatiOrganization->id}.");
        } elseif ($iatiSettings && $aidstreamSettings) {
            if (
                empty(Arr::get($iatiSettings->publishing_info, 'publisher_id', null)) ||
                empty(Arr::get($iatiSettings->publishing_info, 'api_token', null)) ||
                !Arr::get($iatiSettings->publishing_info, 'publisher_verification', false) ||
                !Arr::get($iatiSettings->publishing_info, 'token_verification', false)
            ) {
                $newPublishingInfo = $this->getPublishingInfo($aidstreamSettings->registry_info, $iatiOrganization->publisher_id);

                if (
                    $newPublishingInfo &&
                    !empty(Arr::get($newPublishingInfo, 'publisher_id', null)) &&
                    !empty(Arr::get($newPublishingInfo, 'api_token', null)) &&
                    Arr::get($newPublishingInfo, 'publisher_verification', false) &&
                    Arr::get($newPublishingInfo, 'token_verification', false)
                ) {
                    $this->logInfo("Started updating settings for organization: {$iatiOrganization->id}.");
                    $iatiSettings->timestamps = false;
                    $iatiSettings->updateQuietly([
                        'publishing_info' => $newPublishingInfo,
                    ]);
                    $this->logInfo("Finished updating settings for organization: {$iatiOrganization->id}.");
                }
            }
        }

        return $iatiOrganization->refresh()->settings;
    }
}
