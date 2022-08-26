<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithMapping;

class CsvToCollection implements ToCollection, WithMapping
{
    public function collection(Collection $rows)
    {
        return $rows;
    }

    public function map($rows): array
    {
        $mappedRows = [];
        foreach ($rows as $item) {
            $key = strtolower(str_replace('-', '_', $item));
            $mappedRows[$key] = $item;
        }

        return $mappedRows;
    }
}
