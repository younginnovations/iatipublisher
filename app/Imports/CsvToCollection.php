<?php

declare(strict_types=1);

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithMapping;

class CsvToCollection implements ToCollection, WithMapping
{
    /**
     * @param Collection $rows
     *
     * @return Collection
     */
    public function collection(Collection $rows): Collection
    {
        return $rows;
    }

    /**
     * @param $rows
     *
     * @return array
     */
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
