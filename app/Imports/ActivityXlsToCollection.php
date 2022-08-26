<?php

namespace App\Imports;

use Illuminate\Support\Arr;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ActivityXlsToCollection implements WithHeadingRow, WithMapping
{
    public function map($row): array
    {
        $row = $this->formatDates($row);

        return $row;
    }

    public function formatDates($row)
    {
        $dateElements = ['actual_start_date', 'actual_end_date', 'planned_start_date', 'planned_end_date', 'budget_period_start', 'budget_period_end', 'budget_value_date', 'transaction_date', 'transaction_value_date'];

        foreach ($dateElements as $element) {
            if (is_string($row[$element]) && !str_contains($row[$element], "'")) {
                $array = explode(' ', $row[$element]);

                if ((date('m/d/Y', strtotime($array[0])) === $array[0]) || (date('Y-m-d', strtotime($array[0])) === $array[0])) {
                    $row[$element] = 25569 + (strtotime($row[$element]) / 86400);
                }
            }

            $row[$element] = Arr::get($row, [$element], null) ? Date::excelToDateTimeObject(Arr::get($row, [$element]))->format('Y-m-d') : null;
        }

        return $row;
    }
}
