<?php

declare(strict_types=1);

namespace App\XlsImporter\Foundation\Mapper;

use App;
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
     * @var array
     */
    public array $mappedXlsxlsData;

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
            'basic' => Activity::class,
            'result' => Result::class,
            'period' => Period::class,
            'indicator' => Indicator::class,
        ];
        $mapper = $xlsMapperTypes[$xlsType];
        logger()->error("$mapper decided");
        $xls_data_storage_path = 'XlsImporter/tmp';
        $destinationFilePath = sprintf('%s/%s/%s/%s', $xls_data_storage_path, $orgId, $userId, 'valid.json');
        logger()->error("path: $destinationFilePath");

        App::make($mapper)->map($xlsData, $destinationFilePath);

        return $this;
    }
}
