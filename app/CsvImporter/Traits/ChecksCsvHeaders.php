<?php

declare(strict_types=1);

namespace App\CsvImporter\Traits;

/**
 * Class ChecksCsvHeaders.
 */
trait ChecksCsvHeaders
{
    /**
     * Check if the difference of the csv headers is empty.
     *
     * @param array $diffHeaders
     *
     * @return bool
     */
    protected function isSameCsvHeader(array $diffHeaders): bool
    {
        if (empty($diffHeaders)) {
            return true;
        }

        return false;
    }

    /**
     * Check if the uploaded Csv file has correct headers.
     *
     * @return bool
     */
    protected function hasCorrectHeaders(): bool
    {
        $csvHeaders = array_keys($this->csv[0]);

        return $this->checkSameHeaders($csvHeaders, 'Activity', 'other_fields_transaction');
    }

    /**
     * Convert array of uppercase string to camelcase string.
     *
     * @param $arr
     *
     * @return array
     */
    public function replaceString($arr): array
    {
        return array_map(static function ($data) {
            return str_replace(['(', ')', ' '], ['', '', '_'], $data);
        }, array_map(
            'strtolower',
            array_map('trim', $arr)
        ));
    }

    /**
     * Get csv headers array from file.
     *
     * @param $type
     * @param $filename
     *
     * @return array
     */
    public function getCsvHeaderArray($type, $filename): array
    {
        $path = app_path(sprintf('CsvImporter/Templates/%s/%s.csv', $type, $filename));
        $data = array_map('str_getcsv', file($path));

        return array_values($data[0]);
    }

    /**
     * Compare file headers.
     *
     * @param $headers
     * @param $type
     * @param $filename
     *
     * @return bool
     */
    public function checkSameHeaders($headers, $type, $filename): bool
    {
        $csvHeaders = $this->getCsvHeaderArray($type, $filename);
        $fileHeaders = $this->replaceString($csvHeaders);
        $headers = $this->replaceString($headers);

        return $this->isSameCsvHeader(array_diff($headers, $fileHeaders)) && $this->isSameCsvHeader(array_diff($fileHeaders, $headers));
    }
}
