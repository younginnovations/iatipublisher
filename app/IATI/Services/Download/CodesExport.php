<?php

declare(strict_types=1);

namespace App\IATI\Services\Download;

// use Illuminate\Support\Collection;
// use Maatwebsite\Excel\Concerns\FromCollection;

// use Maatwebsite\Excel\Concerns\ToArray;
// use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
// use Maatwebsite\Excel\Concerns\WithEvents;
// use Maatwebsite\Excel\Concerns\WithHeadingRow;
// use Maatwebsite\Excel\Events\BeforeSheet;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

// use Maatwebsite\Excel\Excel as Generator;
// use PhpOffice\PhpSpreadsheet\Exception;
// use PhpOffice\PhpSpreadsheet\Writer\Exception as ExceptionAlias;
// use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * Class CodesExport.
 */
class CodesExport implements WithMultipleSheets
{
    use Exportable;

    protected array $data;

    protected array $sheetFormats;

    public function __construct($data, $sheetFormats)
    {
        $this->data = $data;
        $this->sheetFormats = $sheetFormats;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];

        foreach ($this->data as $key=>$value) {
            $sheets[] = new ArrayToXls($key, $value, []);
        }

        return $sheets;
    }
}
