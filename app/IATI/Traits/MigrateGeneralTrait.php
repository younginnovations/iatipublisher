<?php

declare(strict_types=1);

namespace App\IATI\Traits;

use Illuminate\Support\Arr;

/**
 * Class MigrateGeneralTrait.
 */
trait MigrateGeneralTrait
{
    /**
     * Returns column value in array format.
     *
     * @param $object
     * @param $column
     *
     * @return array|null
     *
     * @throws \JsonException
     */
    public function getColumnValueArray($object, $column): ?array
    {
        if (!$object || !$object->{$column}) {
            return null;
        }

        return json_decode($object->{$column}, true, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * Checks if select value is valid and returns after typecasting into integer.
     *
     * @param $value
     * @param $listName
     * @param $listType
     *
     * @return int|null
     *
     * @throws \JsonException
     */
    public function getIntSelectValue($value, $listName, $listType): ?int
    {
        if (is_null($value)) {
            return null;
        }

        if (is_string($value) && $value !== '') {
            $value = json_decode($value, true, 512, JSON_THROW_ON_ERROR);
        }

        if (is_null($value)) {
            return null;
        }

        $validKeys = array_keys(getCodeList($listName, $listType, false));
        $value = (int) $value;

        if (in_array($value, $validKeys, true)) {
            return $value;
        }

        return null;
    }

    /**
     * Logs required messages.
     *
     * @param $message
     *
     * @return void
     */
    public function logInfo($message, $log = false): void
    {
        $this->info($message);

        if ($log) {
            logger()->channel('migration')->info($message);
        }
    }

    /**
     * Returns array of [organizationId => organizationIdentifier].
     *
     * @param $aidstreamOrganizationIds
     *
     * @return array
     */
    private function getAidstreamOrganizationIdentifier($aidstreamOrganizationIds): array
    {
        $aidstreamOrganizationsArray = [];
        $aidStreamSettings = $this->db::connection('aidstream')->table('settings')
            ->whereIn('organization_id', $aidstreamOrganizationIds)
            ->get();

        $userIdentifierArray = $this->db::connection('aidstream')->table('organizations')
            ->whereIn('id', $aidstreamOrganizationIds)
            ->get()->pluck('user_identifier', 'id');

        if ($aidStreamSettings) {
            foreach ($aidStreamSettings as $aidStreamSetting) {
                $registryInfo = $aidStreamSetting->registry_info ? json_decode($aidStreamSetting->registry_info) : false;

                if ($registryInfo) {
                    $organizationIdentifier = $registryInfo[0]?->publisher_id;
                    $aidstreamOrganizationsArray[$aidStreamSetting->organization_id] = $organizationIdentifier;
                } else {
                    $aidstreamOrganizationsArray[$aidStreamSetting->organization_id] = strtolower($userIdentifierArray[$aidStreamSetting->organization_id]);
                }
            }
        }

        return $aidstreamOrganizationsArray;
    }

    /**
     * Returns mapped array of ids
     * [aidstreamOrgId => iatiOrgId].
     *
     * @param array $aidstreamOrganizationIdentifierArray
     * @param $iatiOrganizationIdArray
     *
     * @return array
     */
    public function mapOrganizationIds(array $aidstreamOrganizationIdentifierArray, $iatiOrganizationIdArray): array
    {
        $returnArr = [];

        foreach ($aidstreamOrganizationIdentifierArray as $aidstreamId=>$identifier) {
            $returnArr[$aidstreamId] = Arr::get($iatiOrganizationIdArray, $identifier, '');
        }

        return $returnArr;
    }
}
