<?php

declare(strict_types=1);

namespace App\XlsImporter\Foundation\XlsProcessor;

use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Events\BeforeSheet;

class XlsToArray implements ToArray, WithHeadingRow, WithEvents
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
}
