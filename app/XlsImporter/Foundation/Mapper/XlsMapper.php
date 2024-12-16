<?php

declare(strict_types=1);

namespace App\XlsImporter\Foundation\Mapper;

use function Aws\map;
use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * Class XlsMapper.
 */
class XlsMapper
{
    /**
     * @var array
     */
    protected $activity;

    /**
     * @var array
     */
    protected $iatiActivity;

    /**
     * @var array
     */
    protected array $xlsData = [];

    /**
     * Map raw xls Data into system compatible json data for import.
     *
     * @param array $xlsData
     * @param       $template
     * @param       $userId
     * @param       $orgId
     * @param       $dbIatiIdentifiers
     *
     * @return $this
     * @throws BindingResolutionException
     */
    public function process(array $xlsData, string $xlsType, $userId, $orgId, $reportingOrg, $dbIatiIdentifiers): static
    {
        $xlsMapperTypes = [
            'activity' => Activity::class,
            'result' => Result::class,
            'period' => Period::class,
            'indicator' => Indicator::class,
        ];
        $mapper = $xlsMapperTypes[$xlsType];

        $xls_data_storage_path = 'XlsImporter/tmp';
        $validatedDataFilePath = sprintf('%s/%s/%s/%s', $xls_data_storage_path, $orgId, $userId, 'valid.json');
        $statusFilePath = sprintf('%s/%s/%s/%s', $xls_data_storage_path, $orgId, $userId, 'status.json');
        $globalErrorFilePath = sprintf('%s/%s/%s/%s', $xls_data_storage_path, $orgId, $userId, 'globalError.json');

        /**
         * $mapper will be an instance of either one of these:
         *  \App\XlsImporter\Foundation\Mapper\Activity
         *  \App\XlsImporter\Foundation\Mapper\Result
         *  \App\XlsImporter\Foundation\Mapper\Period
         *  \App\XlsImporter\Foundation\Mapper\Indicator
         */
        $xlsMapper = new $mapper();
        $xlsMapper->initMapper($validatedDataFilePath, $statusFilePath, $globalErrorFilePath, $dbIatiIdentifiers);

        if ($xlsType === 'activity') {
            /* @var $xlsMapper \App\XlsImporter\Foundation\Mapper\Activity */
            $xlsMapper->fillOrganizationReportingOrg($reportingOrg)->setOrgId($orgId);
        }

        $tempFlattened = flattenArrayWithKeys($xlsData);
        $tempFlattened = changeEmptySpaceValueToNullValue($tempFlattened);
        $tempFlattened = trimStringValueInArray($tempFlattened);
        $xlsData = convertDotKeysToNestedArray($tempFlattened);

        $xlsMapper->map($xlsData)->validateAndStoreData();

        return $this;
    }
}
