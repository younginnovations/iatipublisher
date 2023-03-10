<?php

declare(strict_types=1);

namespace App\IATI\Traits;

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
     * @throws \JsonException
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
     * @throws \JsonException
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

        return [
            'publisher_id'           => !empty(Arr::get($registryInfoArray, '0.publisher_id', null)) ? Arr::get(
                $registryInfoArray,
                '0.publisher_id',
                null
            ) : $iatiPublisherId,
            'api_token'              => Arr::get($registryInfoArray, '0.api_id', null),
            'publisher_verification' => Arr::get($registryInfoArray, '0.publisher_id_status', null) === 'Correct',
            'token_verification'     => Arr::get($registryInfoArray, '0.api_id_status', null) === 'Correct',
        ];
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
}
