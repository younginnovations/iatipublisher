<?php

declare(strict_types=1);

namespace App\IATI\Traits;

/**
 * Class DataSanitizeTrait.
 */
trait DataSanitizeTrait
{
    /**
     * Function to sanitize data.
     *
     * @param array $data
     *
     * @return array
     */
    public function sanitizeData(array &$data): array
    {
        $keys = array_keys($data);
        $isNumeric = true;

        foreach ($keys as $key) {
            if (!is_int($key)) {
                $isNumeric = false;
                break;
            }
        }

        $data = $isNumeric ? array_values($data) : $data;

        foreach ($data as $key => $dataDatum) {
            if (is_array($dataDatum)) {
                if (is_string($key)) {
                    $data[$key] = array_values($this->sanitizeData($dataDatum));
                } else {
                    $data[$key] = $this->sanitizeData($dataDatum);
                }
            }
        }

        return $data;
    }
}
