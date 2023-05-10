<?php

declare(strict_types=1);

namespace App\Exports;

use Illuminate\Contracts\View\View;
use JsonException;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;

/**
 * Class OptionExport.
 */
class OptionExport implements FromView, WithTitle, WithEvents, ShouldAutoSize
{
    protected string $fileName;

    protected string $sheetName;

    public function __construct($fileName, $sheetName)
    {
        $this->fileName = $fileName;
        $this->sheetName = $sheetName;
    }

    public function title(): string
    {
        return $this->sheetName;
    }

    /**
     * @throws JsonException
     */
    public function view(): View
    {
        $data = readJsonFile('Exports/XlsExportTemplate/' . $this->fileName . '.json');

        return view('Export.optionExport', ['data' => $data]);
    }

    public function registerEvents(): array
    {
        return [
            $colorCode = [
                'B5' => 'd9d9d9', // grey
                'B6' => 'f6b26b', // orange,
                'B7' => '6fa8dc', // blue
            ],

            AfterSheet::class => function (AfterSheet $event) use ($colorCode) {
                if ($this->sheetName === 'Instructions') {
                    foreach ($colorCode as $index => $code) {
                        $styleArray = [
                            'fill' => [
                                'fillType' => Fill::FILL_SOLID,
                                'startColor' => [
                                    'argb' => $code,
                                ],
                            ],
                        ];
                        $event->sheet->getDelegate()->getStyle($index)->applyFromArray($styleArray);
                    }
                }
            },
        ];
    }
}
