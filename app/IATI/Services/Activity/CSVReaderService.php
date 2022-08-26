<?php

namespace App\IATI\Services\Activity;

use Excel;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\IOFactory;

/**
 * Class CSVReaderService.
 */
class CSVReaderService
{
    /**
     * @var Excel
     */
    protected $reader;

    /**
     * CSVReaderService constructor.
     * @param Excel $reader
     */
    public function __construct(Excel $reader)
    {
        $this->reader = $reader;
    }

    /**
     * @param        $file
     * @return \Maatwebsite\Excel\Readers\LaravelExcelReader
     */
    // public function load($file)
    // {
    //     $encoding = getEncodingType($file);

    //     if (!in_array($encoding, mb_list_encodings())) {
    //         $encoding = null;
    //     }

    //     return $this->reader->load($file, null, $encoding);
    // }

    public function load(string $file): Collection
    {
        $array = $this->parseExcelFile($file);

        return $this->mapHeaders($array[0]);
    }

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

    public function mapHeaders(array $content): Collection
    {
        $headers = $content[0];
        $data = array_splice($content, 1);
        $finalArray = [];
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
