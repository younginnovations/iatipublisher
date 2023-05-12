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

    protected array $instruction_properties = [
      'period_instructions' => [
          'color_code' =>[
              'C6' => 'd5a6bd',
              'C7' => '93c47d',
              'C8' => 'f6b26b',
              'C9' => '6fa8dc',
          ],
          'merge_cells' => [
              'B1:C1',
              'B2:C2',
              'B3:C3',
              'B4:C4',
              'B5:C5',
              'B10:C10',
              'B11:C11',
              'B12:C12',
              'B13:C13',
              'B14:C14',
          ],
      ],
      'activity_instructions' => [
          'color_code' => [
              'C4' => 'd5a6bd',
              'C5' => '93c47d',
              'C6' => 'f6b26b',
              'C7' => '6fa8dc',
          ],
          'merge_cells' => [
              'B1:C1',
              'B2:C2',
              'B3:C3',
              'B8:C8',
              'B9:C9',
              'B10:C10',
              'B11:C11',
              'B12:C12',
              'B13:C13',
          ],
      ],
      'result_instructions' => [
          'color_code' =>[
              'C5' => 'd5a6bd',
              'C6' => '93c47d',
              'C7' => 'f6b26b',
              'C8' => '6fa8dc',
          ],
          'merge_cells' => [
              'B1:C1',
              'B2:C2',
              'B3:C3',
              'B4:C4',
              'B9:B9',
              'B10:C10',
              'B11:C11',
              'B12:C12',
              'B13:C13',
          ],
      ],
      'indicator_instructions' => [
          'color_code' =>[
              'C6' => 'd5a6bd',
              'C7' => '93c47d',
              'C8' => 'f6b26b',
              'C9' => '6fa8dc',
          ],
          'merge_cells' => [
              'B1:C1',
              'B2:C2',
              'B3:C3',
              'B4:C4',
              'B5:C5',
              'B10:C10',
              'B11:C11',
              'B12:C12',
              'B13:C13',
          ],
      ],
    ];

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
        $colorCode = $this->instruction_properties[$this->fileName]['color_code'] ?? '';
        $mergeCells = $this->instruction_properties[$this->fileName]['merge_cells'] ?? '';

        return [
            AfterSheet::class => function (AfterSheet $event) use ($mergeCells, $colorCode) {
                if ($this->sheetName === 'Instructions') {
                    $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(100);
                    $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(100);

                    foreach ($mergeCells as $merge_cell) {
                        $event->sheet->mergeCells($merge_cell);
                    }

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
