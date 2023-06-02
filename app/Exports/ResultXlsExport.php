<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

/**
 * Class ResultXlsExport.
 */
class ResultXlsExport implements FromView, WithTitle
{
    /**
     * Holds data from database.
     *
     * @var array
     */
    protected array $data;

    /**
     * Holds Current Sheet name.
     *
     * @var string
     */
    protected string $sheetName;

    /**
     * Headers present in xls file.
     *
     * @var array
     */
    protected array $xlsHeaders;

    /**
     * stores Mapped main identifier with other identifier value.
     *
     * @var array
     */
    protected array $mappedIdentifiers;

    protected string $appendIdentifier;

    /**
     * @param $data
     * @param $sheetName
     * @param $xlsHeaders
     * @param $mappedIdentifiers
     * @param $appendIdentifier
     */
    public function __construct($data, $sheetName, $xlsHeaders, $mappedIdentifiers, $appendIdentifier)
    {
        $this->data = $data;
        $this->sheetName = $sheetName;
        $this->xlsHeaders = $xlsHeaders;
        $this->mappedIdentifiers = $mappedIdentifiers;
        $this->appendIdentifier = $appendIdentifier;
    }

    /**
     * Converts data to xls suitable array.
     *
     * @return View
     */
    public function view(): View
    {
        $headers = array_fill_keys(array_keys(Arr::collapse($this->xlsHeaders)), '');
        $column = array_keys($this->xlsHeaders)[0];
        $totalData = $this->data;

        if (last(explode('_', $column)) !== 'mapper') {
            $totalData = [];

            foreach ($this->data as $data) {
                foreach ($data as $row) {
                    $totalData[$row[$this->appendIdentifier]] = $this->linearizeArray($row[$column], $headers);
                }
            }
        }

        return view('Export.xlsExport', ['activities' => $totalData, 'column' => $column, 'headers' => $headers]);
    }

    /**
     * Sets Sheet name.
     *
     * @return string
     */
    public function title(): string
    {
        return $this->sheetName;
    }

    /**
     * Linearize multiple dimension array to one dimension.
     *
     * @param $data
     * @param $defaultHeaders
     *
     * @return array
     */
    public function linearizeArray($data, $defaultHeaders): array
    {
        $collectData = [];
        $data = isset($data[0]) ? $data : [$data];

        foreach ($data as $key => $datum) {
            foreach ($datum as $headerKey => $detail) {
                if (!is_array($detail)) {
                    $collectData[$key][$headerKey] = $detail;
                } else {
                    $this->convertToOneDimension($detail, $headerKey, $collectData, $key, $defaultHeaders);
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
     * @param $parentKey
     * @param $defaultHeaders
     *
     * @return void
     */
    public function convertToOneDimension($datum, $headers, &$collectData, $parentKey, $defaultHeaders): void
    {
        foreach ($datum as $key => $singleArray) {
            $singleArray = is_array($singleArray) ? $singleArray : [$key => $singleArray];

            foreach ($singleArray as $keyPart => $value) {
                if (is_array($value)) {
                    $this->convertToOneDimension($value, $headers . ' ' . $keyPart, $collectData, $parentKey, $defaultHeaders);
                } elseif ($key === 0) {
                    $collectData[$parentKey][$headers . ' ' . $keyPart] = $value;
                } else {
                    $defaultHeaders[$headers . ' ' . $keyPart] = $value;
                    $collectData[$parentKey . '' . $key] = $defaultHeaders;
                }
            }
        }
    }
}
