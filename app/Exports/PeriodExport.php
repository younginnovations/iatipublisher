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
        'Period Mapper' => 'period_mapper',
        'Target Mapper' => 'target_mapper',
        'Actual Mapper' => 'actual_mapper',
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
        'dimension',
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
        $indicatorIdentifier = [
            'Indicator Identifier' => $this->indicatorIdentifier,
        ];
        $identifier = array_merge($indicatorIdentifier, $this->mappedIdentifier);

        foreach ($data as $key => $datum) {
            $sheets[] = new XlsExport(Arr::collapse($datum), $key, $xlsHeaders[$this->sheets[$key]], 'period');
        }
        $sheets[] = new OptionExport('period_options');
        $sheets[] = new IdentifierExport($identifier);

        return $sheets;
    }

    /**
     * Maps identifier in a sheets.
     *
     * @return array
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
     */
    public function mapPeriodIdentifier(): array
    {
        $mapped = [];
        $indicatorMapper = $this->indicatorIdentifier;
        $periodSet = $this->mappingSets['period_mapper'];
        $appendIdentifier = array_values(Arr::collapse($periodSet))[0];
        $finalIdentifierKey = array_keys($periodSet)[0];
        $sheetName = 'Period Mapper';

        $this->data->chunk(100, function ($chunkedActivities) use ($indicatorMapper, $appendIdentifier, $finalIdentifierKey, &$mapped, $sheetName) {
            $resultIds = array_column(Arr::collapse($chunkedActivities->pluck('results')->toArray()), 'id');
            $mapped = $this->getMappedIndicatorData($resultIds, $indicatorMapper, $appendIdentifier, $finalIdentifierKey, $mapped, $sheetName);
        });

        $this->mappedPeriodIdentifiers['Period Identifier'] = !empty($mapped) ? array_column(Arr::collapse($mapped[$sheetName]['Indicator Identifier']), 'period_identifier', 'period_code') : [];

        return $mapped;
    }

    protected function getMappedIndicatorData($resultIds, $indicatorMapper, $appendIdentifier, $finalIdentifierKey, $mapped, $sheetName)
    {
        $downloadXlsService = app()->make(DownloadXlsService::class);
        $downloadXlsService->getResultsWithIndicatorQueryToDownload($resultIds)->chunk(100, function ($chunkedResults) use ($indicatorMapper, $appendIdentifier, $finalIdentifierKey, &$mapped, $sheetName, $downloadXlsService) {
            $indicatorIds = array_column(Arr::collapse($chunkedResults->pluck('indicators')->toArray()), 'id');
            $mapped = $this->getMappedPeriodData($indicatorIds, $indicatorMapper, $appendIdentifier, $finalIdentifierKey, $mapped, $sheetName, $downloadXlsService);
        });

        return $mapped;
    }

    protected function getMappedPeriodData($indicatorIds, $indicatorMapper, $appendIdentifier, $finalIdentifierKey, $mapped, $sheetName, $downloadXlsService)
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
     */
    public function mapTargetIdentifier(): array
    {
        $mapped = [];
        $targetSet = $this->mappingSets['target_mapper'];
        $appendIdentifier = array_values(Arr::collapse($targetSet))[0];
        $finalIdentifierKey = array_keys($targetSet)[0];
        $sheetName = 'Target Mapper';

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

        $this->mappedTargetIdentifiers['Target Identifier'] = !empty($mapped) ? array_column(Arr::collapse($mapped[$sheetName]['Period Identifier']), 'target_identifier', 'period_code') : [];

        return $mapped;
    }

    private function getTargetData($chunkedIndicator): array
    {
        $indicatorData = $chunkedIndicator->pluck('periods', 'indicator_code')->toArray();

        return array_column(Arr::collapse($indicatorData), 'period', 'period_code');
    }

    private function processTargetData($targetData, $appendIdentifier, $finalIdentifierKey, $sheetName, &$mapped): void
    {
        foreach ($targetData as $identifier => $data) {
            $datum = $data['target'];
            $periodIdentifier = $this->mappedPeriodIdentifiers['Period Identifier'][$identifier];

            foreach ($datum as $ignored) {
                $appendIdentifierValue = generateRandomCharacters(9);
                $mapped[$sheetName]['Period Identifier'][$periodIdentifier][] = [
                    $appendIdentifier => $appendIdentifierValue,
                    $finalIdentifierKey => $periodIdentifier . '_' . $appendIdentifierValue,
                    'period_code' => $identifier,
                ];
            }
        }
    }

    /**
     * Maps Actual Identifier to excel suitable array.
     *
     * @return array
     */
    public function mapActualIdentifier(): array
    {
        $mapped = [];
        $actualSet = $this->mappingSets['actual_mapper'];
        $appendIdentifier = array_values(Arr::collapse($actualSet))[0];
        $finalIdentifierKey = array_keys($actualSet)[0];
        $sheetName = 'Actual Mapper';

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
                                $finalIdentifierKey => $periodIdentifier . '_' . $appendIdentifierValue,
                                'period_code' => $identifier,
                            ];
                        }
                    }
                });
            });
        });
        $this->mappedActualIdentifier['Actual Identifier'] = !empty($mapped) ? array_column(Arr::collapse($mapped[$sheetName]['Period Identifier']), 'actual_identifier', 'period_code') : [];

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
        $this->map('target', 'target', 'target', 'Target Identifier', $identifier_number, $data, $sheets);

        foreach ($data['target'] as $target) {
            $this->map('target document_link', 'document_link', 'target document_link', 'Target Identifier', $identifier_number, $target, $sheets);
        }

        unset($data['target']);
    }

    /**
     * @throws JsonException
     */
    private function mapActual($identifier_number, &$data, &$sheets): void
    {
        $this->map('actual', 'actual', 'actual', 'Actual Identifier', $identifier_number, $data, $sheets);

        foreach ($data['actual'] as $actual) {
            $this->map('actual document_link', 'document_link', 'actual document_link', 'Actual Identifier', $identifier_number, $actual, $sheets);
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
