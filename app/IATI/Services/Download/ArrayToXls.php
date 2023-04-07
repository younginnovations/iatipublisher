<?php

declare(strict_types=1);

namespace App\IATI\Services\Download;

use Arr;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithTitle;

/**
 * Class ArrayToXls.
 */
class ArrayToXls implements FromArray, WithTitle, WithColumnFormatting, ShouldAutoSize
{
    private string $title;
    private array $data;
    private array $sheetFormatting;

    public function __construct(string $title, array $data, array $sheetFormatting)
    {
        $this->title = $title;
        $this->data = $data;
        $this->sheetFormatting = $sheetFormatting;
    }

    /**
     * @return array
     */
    public function array(): array
    {
        return $this->data;
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->title;
    }

    public function columnWidth(): array
    {
        return Arr::get($this->sheetFormatting, 'columnWidth', []);
    }

    public function columnFormats(): array
    {
        return Arr::get($this->sheetFormatting, 'columnFormats', []);
    }
}
