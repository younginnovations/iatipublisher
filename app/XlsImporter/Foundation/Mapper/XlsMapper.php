<?php

declare(strict_types=1);

namespace App\XlsImporter\Foundation\Mapper;

use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * Class XlsMapper.
 */
class XlsMapper
{
    /**
     * @var
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
    public function process(array $xlsData, string $xlsType, $userId, $orgId, $orgRef, $dbIatiIdentifiers): static
    {
        $xlsMapperTypes = [
            'activity' => Activity::class,
            'result' => Result::class,
            'period' => Period::class,
            'indicator' => Indicator::class,
        ];
        $mapper = $xlsMapperTypes[$xlsType];
        logger()->error($xlsType);
        logger()->error($mapper);

        $xls_data_storage_path = 'XlsImporter/tmp';
        $validatedDataFilePath = sprintf('%s/%s/%s/%s', $xls_data_storage_path, $orgId, $userId, 'valid.json');
        $statusFilePath = sprintf('%s/%s/%s/%s', $xls_data_storage_path, $orgId, $userId, 'status.json');

        $xlsMapper = new $mapper();
        $xlsMapper->initMapper($validatedDataFilePath, $statusFilePath, $dbIatiIdentifiers);
        $xlsMapper->map($xlsData)->validateAndStoreData();

        return $this;
    }
}
