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
 * Class IndicatorExport.
 */
class IndicatorExport implements WithMultipleSheets
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
        'Indicator_Mapper' => 'indicator_mapper',
        'Indicator_Baseline_Mapper' => 'indicator_baseline_mapper',
        'Indicator' => 'indicator',
        'Indicator Document Link' => 'indicator document_link',
        'Indicator Baseline' => 'indicator_baseline',
        'Baseline Document Link' => 'baseline document_link',
    ];

    /**
     * Column required for mapping identifiers.
     *
     * @var array|array[]
     */
    protected array $mappingSets = [
        'indicator_mapper' => [
            'indicator_identifier' => [
                'result_identifier' => 'indicator_code',
            ],
        ],
        'indicator_baseline_mapper' => [
            'indicator_baseline_identifier' => [
                'indicator_identifier' => 'baseline_number',
            ],
        ],
    ];

    /**
     * stores Mapped main identifier with other identifier value.
     *
     * @var array
     */
    protected array $mappedIndicatorIdentifiers;

    /**
     * Stores mapped indicator baseline identifiers.
     *
     * @var array
     */
    protected array $mappedIndicatorBaselineIdentifiers;

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
     * list of keys from activity data whose nested array is only one level.
     *
     * @var array
     */
    protected array $headerWithSingleLevel = [
        'language', 'category', 'dimension', 'location',
    ];

    /**
     * Stores all the mapped result identifier.
     *
     * @var array
     */
    protected array $resultIdentifier = [];

    /**
     * Stores all the mapped indicator identifier.
     *
     * @var array
     */
    public array $indicatorIdentifier = [];

    /**
     * mapped all the indicator data in a desired array.
     *
     * @var array
     */
    protected array $mappedData;

    /**
     * @param $data
     * @param $resultIdentifier
     *
     * @throws BindingResolutionException
     */
    public function __construct($data, $resultIdentifier)
    {
        $this->data = $data;
        $this->resultIdentifier = $resultIdentifier;
        $this->mappedData = $this->mapIdentifier();
    }

    /**
     * Populate data in sheets one by one.
     *
     * @throws JsonException|BindingResolutionException
     *
     * @return array
     */
    public function sheets(): array
    {
        $xlsHeaders = readJsonFile('Exports/XlsExportTemplate/xlsHeaderTemplate.json');
        $data = array_merge($this->mappedData(), $this->mappedData);
        $sheets = [];
        $sheets[] = new OptionExport('indicator_instructions', 'Instructions');

        foreach ($data as $key => $datum) {
            $sheets[] = new XlsExport(Arr::collapse($datum), $key, $xlsHeaders[$this->sheets[$key]], 'indicator');
        }
        $sheets[] = new OptionExport('indicator_options', 'Options');

        return $sheets;
    }

    /**
     * Maps data into excel export compatible array.
     *
     * @throws JsonException|BindingResolutionException
     *
     * @return array
     */
    public function mappedData(): array
    {
        $flippedSheet = array_flip($this->sheets);
        $sheets = array_fill_keys($flippedSheet, []);

        $this->data->chunk(100, function ($chunkedData) use (&$sheets) {
            $resultIds = array_column(Arr::collapse($chunkedData->pluck('results')->toArray()), 'id');
            $downloadXlsService = app()->make(DownloadXlsService::class);
            $downloadXlsService->getResultsWithIndicatorQueryToDownload($resultIds)->chunk(100, function ($chunkedResults) use (&$sheets) {
                $chunkedResultData = $chunkedResults->pluck('indicators', 'result_code')->toArray();

                foreach (array_column(Arr::collapse($chunkedResultData), 'indicator', 'indicator_code') as $identifier_number => $data) {
                    $data = $this->processDocumentLink($data, $identifier_number, $sheets);
                    $data = $this->processBaseline($data, $identifier_number, $sheets);

                    $this->map('indicator', 'indicator', 'indicator', 'Indicator Identifier', $identifier_number, ['indicator' => $data], $sheets);
                }
            });
        });

        return $sheets;
    }

    /**
     * Maps document link seperately.
     *
     * @param array $data
     * @param $identifier_number
     * @param array $sheets
     *
     * @throws JsonException
     *
     * @return array
     */
    private function processDocumentLink(array $data, $identifier_number, array &$sheets): array
    {
        if (array_key_exists('document_link', $data)) {
            $this->map('indicator document_link', 'document_link', 'indicator document_link', 'Indicator Identifier', $identifier_number, $data, $sheets);
            unset($data['document_link']);
        }

        return $data;
    }

    /**
     * Maps baseline and its document link seperately.
     *
     * @param array $data
     * @param $identifier_number
     * @param array $sheets
     *
     * @throws JsonException
     *
     * @return array
     */
    private function processBaseline(array $data, $identifier_number, array &$sheets): array
    {
        if (array_key_exists('baseline', $data)) {
            $baselineData['baseline'] = $this->removeDocumentLink($data['baseline'], 'baseline');

            foreach ($baselineData['baseline'] as $baselineKey => $baselineData) {
                $baselineSingleData['baseline'] = $baselineData;
                $this->map('indicator_baseline', 'baseline', 'indicator_baseline', 'Indicator Baseline Identifier', $identifier_number, $baselineSingleData, $sheets, $baselineKey);
            }

            foreach ($data['baseline'] as $baselineDocumentLinkKey => $baseline) {
                $this->map('baseline document_link', 'document_link', 'baseline document_link', 'Indicator Baseline Identifier', $identifier_number, $baseline, $sheets, $baselineDocumentLinkKey);
            }

            unset($data['baseline']);
        }

        return $data;
    }

    /**
     * Maps identifier in a sheets.
     *
     * @throws BindingResolutionException
     *
     * @return array
     */
    public function mapIdentifier(): array
    {
        $mappedIndicator = $this->mapIndicator();
        $mappedIndicatorBaseline = $this->mapIndicatorBaseline();
        $this->mappedIdentifier = array_merge($this->mappedIndicatorIdentifiers, $this->mappedIndicatorBaselineIdentifiers);

        return array_merge($mappedIndicator, $mappedIndicatorBaseline);
    }

    /**
     * Maps Indicator Identifier to excel suitable array.
     *
     * @throws BindingResolutionException
     *
     * @return array
     */
    public function mapIndicator(): array
    {
        $mapped = [];
        $resultMapper = $this->resultIdentifier;
        $indicatorSet = $this->mappingSets['indicator_mapper'];
        $appendIdentifier = array_values(Arr::collapse($indicatorSet))[0];
        $finalIdentifierKey = array_keys($indicatorSet)[0];
        $sheetName = 'Indicator_Mapper';

        $this->data->chunk(100, function ($chunkedActivities) use ($resultMapper, $appendIdentifier, $sheetName, $finalIdentifierKey, &$mapped) {
            $resultIds = array_column(Arr::collapse($chunkedActivities->pluck('results')->toArray()), 'id');
            $downloadXlsService = app()->make(DownloadXlsService::class);

            $downloadXlsService->getResultsWithIndicatorQueryToDownload($resultIds)->chunk(100, function ($chunkedResults) use ($resultMapper, $appendIdentifier, $sheetName, $finalIdentifierKey, &$mapped) {
                $data = $chunkedResults->pluck('indicators', 'result_code')->toArray();

                foreach ($data as $identifier => $datum) {
                    $resultIdentifier = $resultMapper[$identifier];

                    foreach ($datum as $row) {
                        $appendIdentifierValue = $row[$appendIdentifier] ?? generateRandomCharacters(9);
                        $mapped[$sheetName]['Result Identifier'][$resultIdentifier][] = [
                            $appendIdentifier => $appendIdentifierValue,
                            $finalIdentifierKey => $resultIdentifier . '_' . $appendIdentifierValue,
                        ];
                    }
                }
            });
        });

        $this->mappedIndicatorIdentifiers['Indicator Identifier'] = !empty($mapped) ? array_column(Arr::collapse($mapped[$sheetName]['Result Identifier']), 'indicator_identifier', 'indicator_code') : [];
        $this->indicatorIdentifier = $this->mappedIndicatorIdentifiers['Indicator Identifier']; // for period xls export

        return $mapped;
    }

    /**
     * Maps indicator baseline identifier.
     *
     * @throws BindingResolutionException
     *
     * @return array
     */
    public function mapIndicatorBaseline(): array
    {
        $mapped = [];
        $indicatorBaselineSet = $this->mappingSets['indicator_baseline_mapper'];
        $appendIdentifier = array_values(Arr::collapse($indicatorBaselineSet))[0];
        $finalIdentifierKey = array_keys($indicatorBaselineSet)[0];
        $sheetName = 'Indicator_Baseline_Mapper';

        $this->data->chunk(100, function ($chunkedActivities) use ($sheetName, $appendIdentifier, $finalIdentifierKey, &$mapped) {
            $resultIds = array_column(Arr::collapse($chunkedActivities->pluck('results')->toArray()), 'id');
            $downloadXlsService = app()->make(DownloadXlsService::class);
            $downloadXlsService->getResultsWithIndicatorQueryToDownload($resultIds)->chunk(100, function ($chunkedResults) use ($sheetName, $appendIdentifier, $finalIdentifierKey, &$mapped) {
                $data = $chunkedResults->pluck('indicators', 'result_code')->toArray();
                $baseLineData = array_column(Arr::collapse($data), 'indicator', 'indicator_code');

                foreach ($baseLineData as $identifier => $data) {
                    $datum = $data['baseline'];
                    $indicatorIdentifier = $this->mappedIndicatorIdentifiers['Indicator Identifier'][$identifier];

                    foreach ($datum as $ignored) {
                        $appendIdentifierValue = generateRandomCharacters(9);
                        $mapped[$sheetName]['Indicator Identifier'][$indicatorIdentifier][] = [
                            $appendIdentifier => $appendIdentifierValue,
                            $finalIdentifierKey => $indicatorIdentifier . '_b-' . $appendIdentifierValue,
                            'identifier' => $identifier,
                        ];
                    }
                }
            });
        });

        if (!empty($mapped)) {
            $finalMapper = [];

            foreach (Arr::collapse($mapped[$sheetName]['Indicator Identifier']) as $value) {
                $finalMapper[$value['identifier']][] = $value['indicator_baseline_identifier'];
            }
            $this->mappedIndicatorBaselineIdentifiers['Indicator Baseline Identifier'] = $finalMapper;
        } else {
            $this->mappedIndicatorBaselineIdentifiers['Indicator Baseline Identifier'] = [];
        }

        return $mapped;
    }
}
