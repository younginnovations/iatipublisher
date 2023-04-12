<?php

declare(strict_types=1);

namespace App\IATI\Traits;

/**
 * Class XlsDownloadTrait.
 */
trait XlsDownloadTrait
{
    /**
     * Linearize multiple dimension array to one dimension.
     *
     * @param $data
     * @param $defaultHeaders
     *
     * @return array
     *
     * @throws \JsonException
     */
    public function linearizeArray($data, $defaultHeaders, $columnKey): array
    {
        $collectData = [];
        $data = isset($data[0]) ? $data : [$data];
        $dropdownList = readJsonFile('XlsImporter/Templates/dropdown-fields.json');

        foreach ($data as $key => $datum) {
            foreach ($datum as $headerKey => $detail) {
                if (!is_array($detail)) {
                    $originalHeader = $headerKey;
                    $headerKey = isset($this->dynamicMultipleField[$columnKey][$headerKey]) && !empty($detail) ? $this->dynamicMultipleField[$columnKey][$headerKey] : $headerKey;
                    $collectData[$key . '0'][$headerKey] = isset($dropdownList[$columnKey][$originalHeader]) ? $this->populateValueFromDropdown($detail, $dropdownList[$columnKey][$originalHeader]) : $detail;
                } else {
                    $this->convertToOneDimension($detail, $headerKey, $collectData, $defaultHeaders, $key, $columnKey);
                }
            }
        }

        return $collectData;
    }

    /**
     * Converts multiple array to one dimension.
     *
     * @param $datum
     * @param $headers
     * @param $collectData
     * @param $defaultHeaders
     * @param $mainKey
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function convertToOneDimension($datum, $headers, &$collectData, $defaultHeaders, $mainKey, $columnKey): void
    {
        $dropdownList = readJsonFile('XlsImporter/Templates/dropdown-fields.json');

        foreach ($datum as $key => $singleArray) {
            $singleArray = is_array($singleArray) ? $singleArray : [$key => $singleArray];

            foreach ($singleArray as $keyPart => $value) {
                if (isset($this->dynamicMultipleField[$headers . ' ' . $keyPart]) && empty($value)) {
                    continue;
                }
                $combinedHeader = $this->dynamicMultipleField[$headers . ' ' . $keyPart] ?? $headers . ' ' . $keyPart;

                $this->arrayLevelCount[$mainKey][$combinedHeader] = isset($this->arrayLevelCount[$mainKey][$combinedHeader])
                                                                    ? $this->arrayLevelCount[$mainKey][$combinedHeader] + 1
                                                                    : 0;

                $latestKey = $this->arrayLevelCount[$mainKey][$combinedHeader];
//                if($headers === 'language')
//                {
//                    dd($dropdownList[$columnKey], $headers, $keyPart);
//                }
                if (isset($dropdownList[$columnKey][$headers . ' ' . $keyPart])) {
                    $value = $this->populateValueFromDropdown($value, $dropdownList[$columnKey][$headers . ' ' . $keyPart]);
                }

                if (is_array($value)) {
                    $this->convertToOneDimension($value, $headers . ' ' . $keyPart, $collectData, $defaultHeaders, $mainKey, $columnKey);
                } elseif ($key === 0) {
                    $collectData[$mainKey . $latestKey][$combinedHeader] = $value;
                } else {
                    if (!in_array($headers, $this->headerWithSingleLevel, true) && count(explode(' ', $combinedHeader)) === 2) {
                        $latestKey++;
                    }

                    if (isset($collectData[$mainKey . $latestKey])) {
                        $collectData[$mainKey . $latestKey][$combinedHeader] = $value;
                    } else {
                        $defaultHeadersClone = $defaultHeaders;
                        $defaultHeadersClone[$combinedHeader] = $value;
                        $collectData[$mainKey . $latestKey] = $defaultHeadersClone;
                    }
                }
            }
        }
    }

    /**
     * Populates dropdown value to full form
     * eg: en to en - english in every dropdown cell.
     *
     * @param $value
     * @param $dropdownFilePath
     *
     * @return mixed|string
     *
     * @throws \JsonException
     */
    public function populateValueFromDropdown($value, $dropdownFilePath): mixed
    {
        if (is_bool($dropdownFilePath)) {
            return true;
        }

        if (is_array($dropdownFilePath)) {
            if (isset($dropdownFilePath[$value])) {
                $dropValue = $dropdownFilePath[$value] ? 'TRUE' : 'FALSE';
            } else {
                $dropValue = '';
            }

            return $dropValue;
        }

        $explodedDropdownFilePath = explode('/', $dropdownFilePath);
        $listType = $explodedDropdownFilePath[0];
        $listName = explode('.', $explodedDropdownFilePath[1])[0];
        $codeList = getCodeList($listName, $listType);

        return $codeList[$value] ?? $value ?? '';
    }

    /**
     * @param $headerKey
     * @param $columnName
     * @param $sheetName
     * @param $primaryIdentifier
     * @param $identifierNumber
     * @param $data
     * @param $sheets
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function map($headerKey, $columnName, $sheetName, $primaryIdentifier, $identifierNumber, $data, &$sheets): void
    {
        $xlsHeaders = readJsonFile('XlsImporter/Templates/linearized-activity.json');
        $flippedSheet = array_flip($this->sheets);
        $headerTemplate = array_fill_keys(array_flip($xlsHeaders[$headerKey]), '');
        $columnData = $data[$columnName];
        $detail = !empty($columnData) ? array_values($this->linearizeArray($columnData, $headerTemplate, $headerKey)) : [$headerTemplate];
        $sheets[$flippedSheet[$sheetName]][$primaryIdentifier][$this->mappedIdentifier[$primaryIdentifier][$identifierNumber]] = $detail;
        $this->arrayLevelCount = [];
    }
}
