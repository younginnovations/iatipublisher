<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithFormatData;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CsvToArrayWithHeaders implements ToArray, WithHeadingRow, WithFormatData
{
    public function array(array $rows)
    {
        return $rows;
    }
}
