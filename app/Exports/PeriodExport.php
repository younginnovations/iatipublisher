<?php

declare(strict_types=1);

namespace App\Exports;

use App\IATI\Services\Download\DownloadXlsService;
use App\IATI\Traits\XlsDownloadTrait;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Arr;
use JsonException;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

/**
 * Class Period Export.
 */
class PeriodExport implements WithMultipleSheets
{
    use XlsDownloadTrait;

    /**
     * Holds activities data from database.
     *
     * @var object
     */
    protected object $data;

    /**
     * Sheets to be present in xls file.
     *
     * @var array|string[]
     */
    protected array $sheets = [
        'Period_Mapper' => 'period_mapper',
        'Target_Mapper' => 'target_mapper',
        'Actual_Mapper' => 'actual_mapper',
        'Period' => 'period',
        'Target' => 'target',
        'Target Document Link' => 'target document_link',
        'Actual' => 'actual',
        'Actual Document Link' => 'actual document_link',
    ];

    /**
     * Column required for mapping identifiers.
     *
     * @var array|array[]
     */
    protected array $mappingSets = [
        'period_mapper' => [
            'period_identifier' => [
                'indicator_identifier' => 'period_code',
            ],
        ],
        'target_mapper' => [
            'target_identifier' => [
                'period_identifier' => 'target_number',
            ],
        ],
        'actual_mapper' => [
            'actual_identifier' => [
                'period_identifier' => 'actual_number',
            ],
        ],
    ];

    /**
     * stores Mapped main identifier with other identifier value.
     *
     * @var array
     */
    protected array $mappedPeriodIdentifiers;

    /**
     * Stores mapped target identifiers.
     *
     * @var array
     */
    protected array $mappedTargetIdentifiers;

    /**
     * Stores mapped actual identifier.
     *
     * @var array
     */
    protected array $mappedActualIdentifier;

    /**
     * Combines identifiers.
     *
     * @var array
     */
    protected array $mappedIdentifier;

    /**
     * This tracks number of occurrence of the element's header
     * eg: title narrative  => 1.
     *
     * @var array
     */
    protected array $arrayLevelCount = [];

    /**
     * Array to replace different header to same.
     *
     * @var array|string[]
     */
    protected array $dynamicMultipleField = [
        'language language' => 'language code',
    ];

    /**
     * @var array|string[]
     */
    protected array $headerWithSingleLevel = [
        'dimension', 'location',
    ];

    /**
     * Stores all the indicator identifier for mapping.
     *
     * @var array
     */
    protected array $indicatorIdentifier = [];

    /**
     * @param $data
     * @param $indicatorIdentifier
     */
    public function __construct($data, $indicatorIdentifier)
    {
        $this->data = $data;
        $this->indicatorIdentifier = $indicatorIdentifier;
    }

    /**
     * Populate data in sheets one by one.
     *
     * @return array
     *
     * @throws JsonException
     * @throws BindingResolutionException
     */
    public function sheets(): array
    {
        $xlsHeaders = readJsonFile('Exports/XlsExportTemplate/xlsHeaderTemplate.json');
        $mappedIdentifier = $this->mapIdentifier();
        $data = array_merge($this->mappedData(), $mappedIdentifier);
        $sheets = [];
        $sheets[] = new OptionExport('period_instructions', 'Instructions');

        foreach ($data as $key => $datum) {
            $sheets[] = new XlsExport(Arr::collapse($datum), $key, $xlsHeaders[$this->sheets[$key]], 'period');
        }
        $sheets[] = new OptionExport('period_options', 'Options');

        return $sheets;
    }

    /**
     * Maps identifier in a sheets.
     *
     * @return array
     *
     * @throws BindingResolutionException
     */
    public function mapIdentifier(): array
    {
        $mappedPeriodIdentifier = $this->mapPeriodIdentifier();
        $mappedTargetIdentifier = $this->mapTargetIdentifier();
        $mappedActualIdentifier = $this->mapActualIdentifier();
        $this->mappedIdentifier = array_merge($this->mappedPeriodIdentifiers, $this->mappedTargetIdentifiers, $this->mappedActualIdentifier);

        return array_merge($mappedPeriodIdentifier, $mappedTargetIdentifier, $mappedActualIdentifier);
    }

    /**
     * Maps Period Identifier to excel suitable array.
     *
     * @return array
     * @throws BindingResolutionException
     */
    public function mapPeriodIdentifier(): array
    {
        $mapped = [];
        $indicatorMapper = $this->indicatorIdentifier;
        $periodSet = $this->mappingSets['period_mapper'];
        $appendIdentifier = array_values(Arr::collapse($periodSet))[0];
        $finalIdentifierKey = array_keys($periodSet)[0];
        $sheetName = 'Period_Mapper';

        $this->data->chunk(100, function ($chunkedActivities) use ($indicatorMapper, $appendIdentifier, $finalIdentifierKey, &$mapped, $sheetName) {
            $resultIds = array_column(Arr::collapse($chunkedActivities->pluck('results')->toArray()), 'id');
            $mapped = $this->getMappedIndicatorData($resultIds, $indicatorMapper, $appendIdentifier, $finalIdentifierKey, $mapped, $sheetName);
        });

        $this->mappedPeriodIdentifiers['Period Identifier'] = !empty($mapped) ? array_column(Arr::collapse($mapped[$sheetName]['Indicator Identifier']), 'period_identifier', 'period_code') : [];

        return $mapped;
    }

    /**
     * @param $resultIds
     * @param $indicatorMapper
     * @param $appendIdentifier
     * @param $finalIdentifierKey
     * @param $mapped
     * @param $sheetName
     *
     * @return array|mixed
     *
     * @throws BindingResolutionException
     */
    protected function getMappedIndicatorData($resultIds, $indicatorMapper, $appendIdentifier, $finalIdentifierKey, $mapped, $sheetName): mixed
    {
        $downloadXlsService = app()->make(DownloadXlsService::class);
        $downloadXlsService->getResultsWithIndicatorQueryToDownload($resultIds)->chunk(100, function ($chunkedResults) use ($indicatorMapper, $appendIdentifier, $finalIdentifierKey, &$mapped, $sheetName, $downloadXlsService) {
            $indicatorIds = array_column(Arr::collapse($chunkedResults->pluck('indicators')->toArray()), 'id');
            $mapped = $this->getMappedPeriodData($indicatorIds, $indicatorMapper, $appendIdentifier, $finalIdentifierKey, $mapped, $sheetName, $downloadXlsService);
        });

        return $mapped;
    }

    /**
     * @param $indicatorIds
     * @param $indicatorMapper
     * @param $appendIdentifier
     * @param $finalIdentifierKey
     * @param $mapped
     * @param $sheetName
     * @param $downloadXlsService
     *
     * @return array|mixed
     */
    protected function getMappedPeriodData($indicatorIds, $indicatorMapper, $appendIdentifier, $finalIdentifierKey, $mapped, $sheetName, $downloadXlsService): mixed
    {
        $downloadXlsService->getIndicatorWithPeriodsQueryToDownload($indicatorIds)->chunk(100, function ($chunkedIndicator) use ($indicatorMapper, $appendIdentifier, $finalIdentifierKey, &$mapped, $sheetName) {
            $indicatorData = $chunkedIndicator->pluck('periods', 'indicator_code')->toArray();

            foreach ($indicatorData as $identifier => $datum) {
                $indicatorIdentifier = $indicatorMapper[$identifier];

                foreach ($datum as $row) {
                    $appendIdentifierValue = $row[$appendIdentifier] ?? generateRandomCharacters(9);
                    $mapped = $this->mapPeriodData($mapped, $sheetName, $indicatorIdentifier, $appendIdentifier, $finalIdentifierKey, $appendIdentifierValue);
                }
            }
        });

        return $mapped;
    }

    /**
     * @param $mapped
     * @param $sheetName
     * @param $indicatorIdentifier
     * @param $appendIdentifier
     * @param $finalIdentifierKey
     * @param $appendIdentifierValue
     *
     * @return array
     */
    protected function mapPeriodData($mapped, $sheetName, $indicatorIdentifier, $appendIdentifier, $finalIdentifierKey, $appendIdentifierValue): array
    {
        $mapped[$sheetName]['Indicator Identifier'][$indicatorIdentifier][] = [
            $appendIdentifier => $appendIdentifierValue,
            $finalIdentifierKey => $indicatorIdentifier . '_' . $appendIdentifierValue,
        ];

        return $mapped;
    }

    /**
     * Maps Target Identifier to excel suitable array.
     *
     * @return array
     *
     * @throws BindingResolutionException
     */
    public function mapTargetIdentifier(): array
    {
        $mapped = [];
        $targetSet = $this->mappingSets['target_mapper'];
        $appendIdentifier = array_values(Arr::collapse($targetSet))[0];
        $finalIdentifierKey = array_keys($targetSet)[0];
        $sheetName = 'Target_Mapper';

        $this->data->chunk(100, function ($chunkedActivities) use ($appendIdentifier, $finalIdentifierKey, $sheetName, &$mapped) {
            $resultIds = array_column(Arr::collapse($chunkedActivities->pluck('results')->toArray()), 'id');
            $downloadXlsService = app()->make(DownloadXlsService::class);
            $downloadXlsService->getResultsWithIndicatorQueryToDownload($resultIds)->chunk(100, function ($chunkedResults) use ($appendIdentifier, $finalIdentifierKey, $sheetName, &$mapped, $downloadXlsService) {
                $indicatorIds = array_column(Arr::collapse($chunkedResults->pluck('indicators')->toArray()), 'id');
                $downloadXlsService->getIndicatorWithPeriodsQueryToDownload($indicatorIds)->chunk(100, function ($chunkedIndicator) use ($appendIdentifier, $finalIdentifierKey, $sheetName, &$mapped) {
                    $targetData = $this->getTargetData($chunkedIndicator);
                    $this->processTargetData($targetData, $appendIdentifier, $finalIdentifierKey, $sheetName, $mapped);
                });
            });
        });

        if (!empty($mapped)) {
            $targetIdentifier = [];
            foreach (Arr::collapse($mapped[$sheetName]['Period Identifier']) as $value) {
                $targetIdentifier[$value['period_code']][] = $value['target_identifier'];
            }
            $this->mappedTargetIdentifiers['Target Identifier'] = $targetIdentifier;
        } else {
            $this->mappedTargetIdentifiers['Target Identifier'] = [];
        }

        return $mapped;
    }

    /**
     * @param $chunkedIndicator
     *
     * @return array
     */
    private function getTargetData($chunkedIndicator): array
    {
        $indicatorData = $chunkedIndicator->pluck('periods', 'indicator_code')->toArray();

        return array_column(Arr::collapse($indicatorData), 'period', 'period_code');
    }

    /**
     * @param $targetData
     * @param $appendIdentifier
     * @param $finalIdentifierKey
     * @param $sheetName
     * @param $mapped
     *
     * @return void
     */
    private function processTargetData($targetData, $appendIdentifier, $finalIdentifierKey, $sheetName, &$mapped): void
    {
        foreach ($targetData as $identifier => $data) {
            $datum = $data['target'];
            $periodIdentifier = $this->mappedPeriodIdentifiers['Period Identifier'][$identifier];

            foreach ($datum as $ignored) {
                $appendIdentifierValue = generateRandomCharacters(9);
                $mapped[$sheetName]['Period Identifier'][$periodIdentifier][] = [
                    $appendIdentifier => $appendIdentifierValue,
                    $finalIdentifierKey => $periodIdentifier . '_t-' . $appendIdentifierValue,
                    'period_code' => $identifier,
                ];
            }
        }
    }

    /**
     * Maps Actual Identifier to excel suitable array.
     *
     * @return array
     *
     * @throws BindingResolutionException
     */
    public function mapActualIdentifier(): array
    {
        $mapped = [];
        $actualSet = $this->mappingSets['actual_mapper'];
        $appendIdentifier = array_values(Arr::collapse($actualSet))[0];
        $finalIdentifierKey = array_keys($actualSet)[0];
        $sheetName = 'Actual_Mapper';

        $this->data->chunk(100, function ($chunkedActivities) use ($appendIdentifier, $finalIdentifierKey, $sheetName, &$mapped) {
            $resultIds = array_column(Arr::collapse($chunkedActivities->pluck('results')->toArray()), 'id');
            $downloadXlsService = app()->make(DownloadXlsService::class);
            $downloadXlsService->getResultsWithIndicatorQueryToDownload($resultIds)->chunk(100, function ($chunkedResults) use ($appendIdentifier, $finalIdentifierKey, $sheetName, &$mapped, $downloadXlsService) {
                $indicatorIds = array_column(Arr::collapse($chunkedResults->pluck('indicators')->toArray()), 'id');
                $downloadXlsService->getIndicatorWithPeriodsQueryToDownload($indicatorIds)->chunk(100, function ($chunkedIndicator) use ($appendIdentifier, $finalIdentifierKey, $sheetName, &$mapped) {
                    $indicatorData = $chunkedIndicator->pluck('periods', 'indicator_code')->toArray();
                    $actualData = array_column(Arr::collapse($indicatorData), 'period', 'period_code');

                    foreach ($actualData as $identifier => $data) {
                        $datum = $data['actual'];
                        $periodIdentifier = $this->mappedPeriodIdentifiers['Period Identifier'][$identifier];

                        foreach ($datum as $ignored) {
                            $appendIdentifierValue = generateRandomCharacters(9);
                            $mapped[$sheetName]['Period Identifier'][$periodIdentifier][] = [
                                $appendIdentifier => $appendIdentifierValue,
                                $finalIdentifierKey => $periodIdentifier . '_a-' . $appendIdentifierValue,
                                'period_code' => $identifier,
                            ];
                        }
                    }
                });
            });
        });

        if (!empty($mapped)) {
            $actualIdentifier = [];
            foreach (Arr::collapse($mapped[$sheetName]['Period Identifier']) as $value) {
                $actualIdentifier[$value['period_code']][] = $value['actual_identifier'];
            }
            $this->mappedActualIdentifier['Actual Identifier'] = $actualIdentifier;
        } else {
            $this->mappedActualIdentifier['Actual Identifier'] = [];
        }

        return $mapped;
    }

    /**
     * Maps data into excel export compatible array.
     *
     * @return array
     *
     * @throws JsonException|BindingResolutionException
     */
    public function mappedData(): array
    {
        $flippedSheet = array_flip($this->sheets);
        $sheets = array_fill_keys($flippedSheet, []);

        $this->data->chunk(100, function ($chunkedActivities) use (&$sheets) {
            $resultIds = array_column(Arr::collapse($chunkedActivities->pluck('results')->toArray()), 'id');
            $downloadXlsService = app()->make(DownloadXlsService::class);
            $downloadXlsService->getResultsWithIndicatorQueryToDownload($resultIds)->chunk(100, function ($chunkedResults) use (&$sheets, $downloadXlsService) {
                $indicatorIds = array_column(Arr::collapse($chunkedResults->pluck('indicators')->toArray()), 'id');
                $downloadXlsService->getIndicatorWithPeriodsQueryToDownload($indicatorIds)->chunk(100, function ($chunkedIndicator) use (&$sheets) {
                    $indicatorData = $chunkedIndicator->pluck('periods', 'indicator_code')->toArray();

                    foreach (array_column(Arr::collapse($indicatorData), 'period', 'period_code') as $identifier_number => $data) {
                        if (array_key_exists('target', $data)) {
                            $this->mapTarget($identifier_number, $data, $sheets);
                        }

                        if (array_key_exists('actual', $data)) {
                            $this->mapActual($identifier_number, $data, $sheets);
                        }

                        $this->mapPeriod($identifier_number, $data, $sheets);
                    }
                });
            });
        });

        return $sheets;
    }

    /**
     * @throws JsonException
     */
    private function mapTarget($identifier_number, &$data, &$sheets): void
    {
        $targetData['target'] = $this->removeDocumentLink($data['target'], 'target');

        foreach ($targetData['target'] as $targetKey => $targetData) {
            $targetSingleData['target'] = $targetData;
            $this->map('target', 'target', 'target', 'Target Identifier', $identifier_number, $targetSingleData, $sheets, $targetKey);
        }

        foreach ($data['target'] as $targetDocumentLinkKey => $target) {
            $this->map('target document_link', 'document_link', 'target document_link', 'Target Identifier', $identifier_number, $target, $sheets, $targetDocumentLinkKey);
        }

        unset($data['target']);
    }

    /**
     * @throws JsonException
     */
    private function mapActual($identifier_number, &$data, &$sheets): void
    {
        $actualData['actual'] = $this->removeDocumentLink($data['actual'], 'actual');

        foreach ($actualData['actual'] as $actualKey => $actualData) {
            $actualSingleData['actual'] = $actualData;
            $this->map('actual', 'actual', 'actual', 'Actual Identifier', $identifier_number, $actualSingleData, $sheets, $actualKey);
        }

        foreach ($data['actual'] as $actualDocumentLink => $actual) {
            $this->map('actual document_link', 'document_link', 'actual document_link', 'Actual Identifier', $identifier_number, $actual, $sheets, $actualDocumentLink);
        }

        unset($data['actual']);
    }

    /**
     * @throws JsonException
     */
    private function mapPeriod($identifier_number, $data, &$sheets): void
    {
        $this->map('period', 'period', 'period', 'Period Identifier', $identifier_number, ['period' => $data], $sheets);
    }
}
