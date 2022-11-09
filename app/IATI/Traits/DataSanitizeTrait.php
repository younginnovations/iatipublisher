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
        foreach ($data as $key => $dataDatum) {
            if (is_array($dataDatum)) {
                $data[$key] = array_values($dataDatum);
                $this->sanitizeData($dataDatum);
            }
        }

        return $data;
    }
}
