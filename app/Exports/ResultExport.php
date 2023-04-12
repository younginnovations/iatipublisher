<?php

namespace App\Exports;

use App\IATI\Traits\XlsDownloadTrait;
use Illuminate\Support\Arr;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

/**
 * Class ResultExport.
 */
class ResultExport implements WithMultipleSheets
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
        'Result Mapper' => 'result_mapper',
        'Result' => 'result',
        'Result Document Link' => 'result document_link',
    ];

    /**
     * Column required for mapping identifiers.
     *
     * @var array|array[]
     */
    protected array $mappingSets = [
        'result_mapper' => [
           'result_identifier' => [
               'activity_identifier' => 'result_code',
           ],
        ],
    ];

    /**
     * stores Mapped main identifier with other identifier value.
     *
     * @var array
     */
    protected array $mappedIdentifiers;

    /**
     * This tracks number of occurrence of the element's header
     * eg: title narrative  => 1.
     *
     * @var array
     */
    protected array $arrayLevelCount = [];

    /**
     * @var array|string[]
     */
    protected array $headerWithSingleLevel = [
        'reference',
    ];

    /**
     * Array to replace different header to same.
     *
     * @var array|string[]
     */
    protected array $dynamicMultipleField = [];

    /**
     * Stores all the result identifiers for sheet.
     *
     * @var array
     */
    public array $resultIdentifiers = [];

    /**
     * @var array
     */
    protected array $mappedData;

    /**
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
        $this->mappedData = $this->mapIdentifier();
    }

    /**
     * Populate data in sheets one by one.
     *
     * @return array
     *
     * @throws \JsonException
     */
    public function sheets(): array
    {
        $xlsHeaders = readJsonFile('Exports/XlsExportTemplate/xlsHeaderTemplate.json');
        $data = array_merge($this->mappedData(), $this->mappedData);
        $sheets = [];
        $identifiers = [
            'Result Identifier' => $this->mappedIdentifiers,
            'Activity Identifier' => array_keys($data['Result Mapper']['Activity Identifier']),
        ];

        foreach ($data as $key => $datum) {
            $sheets[] = new XlsExport(Arr::collapse($datum), $key, $xlsHeaders[$this->sheets[$key]], 'result');
        }
        $sheets[] = new OptionExport('result_options');
        $sheets[] = new IdentifierExport($identifiers);

        return $sheets;
    }

    /**
     * Maps data into excel export compatible array.
     *
     * @return array
     *
     * @throws \JsonException
     */
    public function mappedData(): array
    {
        $flippedSheet = array_flip($this->sheets);
        $sheets = array_fill_keys($flippedSheet, []);

        $this->data->chunk(100, function ($chunkedData) use ($flippedSheet, &$sheets) {
            $chunkedData = $chunkedData->pluck('results', 'iati_identifier.activity_identifier')->toArray();
            $xlsHeaders = readJsonFile('XlsImporter/Templates/linearized-activity.json');

            foreach (array_column(Arr::collapse($chunkedData), 'result', 'result_code') as $identifier_number => $data) {
                if (array_key_exists('document_link', $data)) {
                    $headerTemplate = array_fill_keys(array_flip($xlsHeaders['result document_link']), '');
                    $document_link = $data['document_link'];
                    $detail = !empty($document_link) ? array_values($this->linearizeArray($document_link, $headerTemplate, 'result document_link')) : [$headerTemplate];
                    $sheets[$flippedSheet['result document_link']]['Result Identifier'][$this->mappedIdentifiers[$identifier_number]] = $detail;
                    $this->arrayLevelCount = [];
                }

                unset($data['document_link']);

                $resultHeaderTemplate = array_fill_keys(array_flip($xlsHeaders['result']), '');
                $detail = !empty($data) ? array_values($this->linearizeArray($data, $resultHeaderTemplate, 'result')) : [$resultHeaderTemplate];
                $sheets[$flippedSheet['result']]['Result Identifier'][$this->mappedIdentifiers[$identifier_number]] = $detail;
                $this->arrayLevelCount = [];
            }
        });

        return $sheets;
    }

    /**
     * Maps identifier in a sheets.
     *
     * @return array
     */
    public function mapIdentifier(): array
    {
        $mapped = [];

        foreach ($this->mappingSets as $sheetName => $mapSet) {
            $mappingSet = $this->mappingSets[$sheetName];
            $primaryIdentifier = ucwords(str_replace('_', ' ', array_keys(Arr::collapse($mappingSet))[0]));

            $this->data->chunk(100, function ($chunkedData) use (&$sheetName, &$mapped, $mapSet, $primaryIdentifier, $mappingSet) {
                $chunkedData = $chunkedData->pluck('results', 'iati_identifier.activity_identifier')->toArray();
                $appendIdentifier = array_values(Arr::collapse($mappingSet))[0];
                $finalIdentifierKey = array_keys($mapSet)[0];

                foreach ($chunkedData as $identifier => $datum) {
                    foreach ($datum as $row) {
                        $sheetName = ucwords(str_replace('_', ' ', $sheetName));
                        $mapped[$sheetName][$primaryIdentifier][$identifier][] = [
                            $appendIdentifier => $row[$appendIdentifier],
                            $finalIdentifierKey => $identifier . '_' . $row[$appendIdentifier],
                        ];
                    }
                }
            });

            $this->mappedIdentifiers = !empty($mapped) ? array_column(Arr::collapse($mapped[$sheetName][$primaryIdentifier]), 'result_identifier', 'result_code') : [];
        }

        $this->resultIdentifiers = $this->mappedIdentifiers; // for indicator xls export

        return $mapped;
    }
}
