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

    /**
     * @var array
     */
    protected array $data;

    /**
     * @var array
     */
    protected array $sheetFormats;

    /**
     * Constructor.
     *
     * @param $data
     * @param $sheetFormats
     */
    public function __construct($data, $sheetFormats)
    {
        $this->data = $data;
        $this->sheetFormats = $sheetFormats;
    }

    /**
     * Adds data to individual sheets.
     *
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
