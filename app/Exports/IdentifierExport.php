<?php

declare(strict_types=1);

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

/**
 * Class Identifier Export.
 */
class IdentifierExport implements FromView, WithTitle
{
    protected array $identifiers;

    public function __construct($identifiers)
    {
        $this->identifiers = $identifiers;
    }

    public function title(): string
    {
        return 'Identifiers';
    }

    public function view(): View
    {
        $headers = array_keys($this->identifiers);
        $data = $this->manipulateArray();

        return view('Export.identifierExport', ['identifiers' => $data, 'headers' => $headers]);
    }

    public function manipulateArray()
    {
        $identifierArray = [];

        foreach ($this->identifiers as $identifierName => $identifier) {
            $i = 0;
            foreach ($identifier as $data) {
                $identifierArray[$i][$identifierName] = $data;
                $i++;
            }
        }

        return $identifierArray;
    }
}
