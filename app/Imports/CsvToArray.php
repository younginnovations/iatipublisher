<?php

declare(strict_types=1);

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToArray;

class CsvToArray implements ToArray
{
    /**
     * @param array $rows
     *
     * @return array
     */
    public function array(array $rows): array
    {
        return $rows;
    }
}
