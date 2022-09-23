<?php

declare(strict_types=1);

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithFormatData;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CsvToArrayWithHeaders implements ToArray, WithHeadingRow, WithFormatData
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
