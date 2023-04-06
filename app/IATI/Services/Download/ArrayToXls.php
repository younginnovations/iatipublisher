<?php

declare(strict_types=1);

namespace App\IATI\Services\Download;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;

/**
 * Class ArrayToXls.
 */
class ArrayToXls implements FromArray, WithTitle
{
    private $title;
    private $data;

    public function __construct(string $title, array $data)
    {
        $this->data = $data;
        $this->title = $title;
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
