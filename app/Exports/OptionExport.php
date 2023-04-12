<?php

declare(strict_types=1);

namespace App\Exports;

use Illuminate\Contracts\View\View;
use JsonException;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

/**
 * Class OptionExport.
 */
class OptionExport implements FromView, WithTitle
{
    protected string $fileName;

    public function __construct($fileName)
    {
        $this->fileName = $fileName;
    }

    public function title(): string
    {
        return 'Options';
    }

    /**
     * @throws JsonException
     */
    public function view(): View
    {
        $data = readJsonFile('Exports/XlsExportTemplate/' . $this->fileName . '.json');

        return view('Export.optionExport', ['data' => $data]);
    }
}
