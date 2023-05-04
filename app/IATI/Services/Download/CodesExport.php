<?php

declare(strict_types=1);

namespace App\IATI\Services\Download;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

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

        foreach ($this->data as $key => $value) {
            $sheets[] = new ArrayToXls($key, $value, []);
        }

        return $sheets;
    }
}
