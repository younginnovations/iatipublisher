<?php

declare(strict_types=1);

namespace App\XlsImporter\Foundation\XlsProcessor;

use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\BeforeSheet;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class XlsToArray implements ToArray, WithHeadingRow, WithEvents, WithCalculatedFormulas, WithMapping
{
    public $sheetNames;
    public $sheetData;

    public function __construct()
    {
        $this->sheetNames = [];
        $this->sheetData = [];
    }

    public function array(array $array)
    {
        $this->sheetData[$this->sheetNames[count($this->sheetNames) - 1]] = $array;
    }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function (BeforeSheet $event) {
                $this->sheetNames[] = $event->getSheet()->getTitle();
            },
        ];
    }

    public function chunkSize(): int
    {
        return 100;
    }

    public function getSheetNames()
    {
        return $this->sheetNames;
    }

    public function map($row): array
    {
        $row = $this->formatDates($row);

        return $row;
    }

    protected function formatDates($row)
    {
        $dateElements = ['iso_date', 'document_date_date', 'period_start_iso_date', 'period_end_iso_date', 'value_date', 'value_value_date', 'date', 'transaction_date_date'];

        foreach ($row as $key => $value) {
            if (in_array($key, $dateElements)) {
                if (is_string($value) && !str_contains($value, "'")) {
                    $array = explode(' ', $value);
                    $timestamp = dateStrToTime($array[0]);

                    if ($timestamp) {
                        if ((date('m/d/Y', dateStrToTime($array[0])) === $array[0]) || (date('Y-m-d', dateStrToTime($array[0])) === $array[0])) {
                            $value = 25569 + (strtotime($value) / 86400);
                        }
                    } else {
                        continue;
                    }
                }

                $row[$key] = $value && !is_string($value) ? Date::excelToDateTimeObject($value)->format('Y-m-d') : null;
            }
        }

        return $row;
    }
}
