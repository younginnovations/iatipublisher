<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use Excel;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Exception;

/**
 * Class CSVReaderService.
 */
class CSVReaderService
{
    /**
     * @var Excel
     */
    protected Excel $reader;

    /**
     * CSVReaderService constructor.
     * @param Excel $reader
     */
    public function __construct(Excel $reader)
    {
        $this->reader = $reader;
    }

    // public function load($file)
    // {
    //     $encoding = getEncodingType($file);

    //     if (!in_array($encoding, mb_list_encodings())) {
    //         $encoding = null;
    //     }

    //     return $this->reader->load($file, null, $encoding);
    // }

    /**
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
