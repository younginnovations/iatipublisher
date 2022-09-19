<?php

declare(strict_types=1);

namespace App\CsvImporter\Traits;

use App\CsvImporter\CsvReader\CsvReader;
use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * Class ChecksCsvHeaders.
 */
trait ChecksCsvHeaders
{
    /**
     * Load Csv template.
     * @param $filename
     *
     * @return mixed
     * @throws BindingResolutionException
     */
    protected function loadTemplate($filename): mixed
    {
        $excel = app()->make(CsvReader::class);
        $file = $excel->load(app_path(sprintf('Services/CsvImporter/Templates/Activity/%s.csv', $filename)));

        return $file->toArray();
    }

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
     * Check if the headers are correct for the uploaded Csv File.
     *
     * @param        $csvHeaders
     * @param        $templateFileName
     *
     * @return bool
     * @throws BindingResolutionException
     */
    protected function checkHeadersFor($csvHeaders, $templateFileName): bool
    {
        $templateHeaders = $this->loadTemplate($templateFileName);
        $templateHeaders = array_keys($templateHeaders[0]);
        $diffHeaders = array_diff($csvHeaders, $templateHeaders);

        return $this->isSameCsvHeader($diffHeaders);
    }

    /**
     * Check if the headers for the uploaded Csv file matches with the provided header count.
     *
     * @param array $actualHeaders
     * @param       $providedHeaderCount
     *
     * @return bool
     */
    protected function headerCountMatches(array $actualHeaders, $providedHeaderCount): bool
    {
        return count($actualHeaders) === $providedHeaderCount;
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
            return str_replace(' ', '_', str_replace(['(', ')'], '', $data));
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

        return $this->isSameCsvHeader(array_diff($headers, $fileHeaders));
    }
}
