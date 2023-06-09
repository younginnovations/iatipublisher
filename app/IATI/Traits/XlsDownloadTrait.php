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
     * @param $columnKey
     *
     * @throws \JsonException
     *
     * @return array
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
     * @param $columnKey
     *
     * @throws \JsonException
     *
     * @return void
     */
    public function convertToOneDimension($datum, $headers, &$collectData, $defaultHeaders, $mainKey, $columnKey): void
    {
        $dropdownList = readJsonFile('XlsImporter/Templates/dropdown-fields.json');

        if ($headers === 'aid_type') {
            $datum = $this->populateDynamicFieldAndResetOtherKeys($datum);
        }

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
     * Reset other unnecessary keys.
     *
     * @param $datum
     *
     * @return array
     */
    public function populateDynamicFieldAndResetOtherKeys($datum): array
    {
        $arr = [];

        foreach ($datum as $data) {
            $arr[] = array_filter($data, static function ($q) {
                return $q;
            });
        }

        return $arr;
    }

    /**
     * Populates dropdown value to full form
     * eg: en to en - english in every dropdown cell.
     *
     * @param $value
     * @param $dropdownFilePath
     *
     * @throws \JsonException
     *
     * @return mixed|string
     */
    public function populateValueFromDropdown($value, $dropdownFilePath): mixed
    {
        if (is_bool($dropdownFilePath)) {
            return true; // for identifier dropdown
        }

        if (is_array($dropdownFilePath)) {
            return $dropdownFilePath[$value] ?? '';
        }

        if ($dropdownFilePath === 'Activity/FileFormat.json') {
            return $value;
        }

        $explodedDropdownFilePath = explode('/', $dropdownFilePath);
        $listType = $explodedDropdownFilePath[0];
        $listName = explode('.', $explodedDropdownFilePath[1])[0];
        $codeList = getCodeList($listName, $listType);

        return $codeList[$value] ?? $value ?? '';
    }

    /**
     * Manipulate, maps data and makes it ready for xlsExport class.
     *
     * @param $headerKey
     * @param $columnName
     * @param $sheetName
     * @param $primaryIdentifier
     * @param $identifierNumber
     * @param $data
     * @param $sheets
     * @param null $getIdentifierByOrderKey
     *
     * @throws \JsonException
     *
     * @return void
     */
    public function map($headerKey, $columnName, $sheetName, $primaryIdentifier, $identifierNumber, $data, &$sheets, $getIdentifierByOrderKey = null): void
    {
        $xlsHeaders = readJsonFile('XlsImporter/Templates/linearized-activity.json');
        $flippedSheet = array_flip($this->sheets);
        $headerTemplate = array_fill_keys(array_flip($xlsHeaders[$headerKey]), '');
        $columnData = $data[$columnName];
        $detail = !empty($columnData) ? array_values($this->linearizeArray($columnData, $headerTemplate, $headerKey)) : [$headerTemplate];
        $getIdentifierKey = is_null($getIdentifierByOrderKey) ? $this->mappedIdentifier[$primaryIdentifier][$identifierNumber]
                                                              : $this->mappedIdentifier[$primaryIdentifier][$identifierNumber][$getIdentifierByOrderKey];

        $identifierKey = $sheets[$flippedSheet[$sheetName]][$primaryIdentifier][$getIdentifierKey] ?? '';

        if (!empty($identifierKey)) {
            $sheets[$flippedSheet[$sheetName]][$primaryIdentifier][$getIdentifierKey] = array_merge($identifierKey, $detail);
        } else {
            $sheets[$flippedSheet[$sheetName]][$primaryIdentifier][$getIdentifierKey] = $detail;
        }

        $this->arrayLevelCount = [];
    }

    /**
     * Removed document link of baseline, target, actual after mapping
     * so that document link doesn't get included when baseline, target and actual are mapped.
     *
     * @param $data
     * @param $key
     *
     * @return array
     */
    public function removeDocumentLink($data, $key): array
    {
        $keyData[$key] = $data;

        foreach ($keyData as $datum) {
            $keyToRemove = 'document_link';

            foreach ($datum as &$array) {
                if (array_key_exists($keyToRemove, $array)) {
                    unset($array[$keyToRemove]);
                }
            }

            $keyData = $datum;
        }

        return $keyData;
    }
}
