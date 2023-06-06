<?php

declare(strict_types=1);

namespace App\IATI\Services\Download;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;

/**
 * Class ArrayToXls.
 */
class ArrayToXls implements FromArray, WithTitle, ShouldAutoSize
{
    /**
     * @var string
     */
    private string $title;

    /**
     * @var array
     */
    private array $data;

    /**
     * @var array
     */
    private array $sheetFormatting;

    /**
     * Constructor.
     *
     * @param $title
     * @param $data
     * @param $sheetFormatting
     */
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
}
