<?php

declare(strict_types=1);

namespace App\CsvImporter\CsvReader;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Exception;

/**
 * Class CsvReader.
 */
class CsvReader
{
    /**
     * @var Excel
     */
    protected Excel $reader;

    /**
     * CsvReader constructor.
     * @param Excel $reader
     */
    public function __construct(Excel $reader)
    {
        $this->reader = $reader;
    }

    /**
     * Loads xml file.
     *
     * @param string $file
     *
     * @return Collection
     */
    public function load(string $file): Collection
    {
        $array = $this->parseExcelFile($file);

        return $this->mapHeaders($array[0]);
    }

    /**
     * Parses xml file to array.
     *
     * @param string $file
     *
     * @return array
     * @throws Exception
     */
    public function parseExcelFile(string $file): array
    {
        $fileType = IOFactory::identify($file);
        $reader = IOFactory::createReader($fileType);
        $spreadsheet = $reader->load($file);
        $sheetNames = $spreadsheet->getSheetNames();
        $arr = [];

        foreach ($sheetNames as $sheetName) {
            $arr[] = $spreadsheet->getSheetByName($sheetName)->toArray();
        }

        return $arr;
    }

    /**
     * Maps content to header.
     *
     * @param array $content
     *
     * @return Collection
     */
    public function mapHeaders(array $content): Collection
    {
        $headers = $content[0];
        $data = array_splice($content, 1);
        $finalArray = [];
        $arr = [];

        foreach ($data as $value) {
            foreach ($value as $k => $v) {
                $key = str_replace(' ', '_', strtolower(trim($headers[$k])));
                $arr[$key] = $v;
            }
            $finalArray[] = $arr;
        }

        return collect($finalArray);
    }
}
