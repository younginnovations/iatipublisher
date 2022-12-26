<?php

declare(strict_types=1);

namespace App\IATI\Services\Download;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

/**
 * Class ArrayToCsv.
 */
class ArrayToCsv implements FromArray, WithHeadings
{
    /**
     * @var array
     */
    protected array $data;

    /**
     * @var array
     */
    protected array $headers;

    /**
     * ArrayToCsv Constructor.
     * @param array $data
     * @param array $headers
     */
    public function __construct(array $data, array $headers)
    {
        $this->data = $data;
        $this->headers = $headers;
    }

    /**
     * Returns array of data.
     *
     * @return array
     */
    public function array(): array
    {
        return $this->data;
    }

    /**
     * Returns csv headers array.
     *
     * @return array
     */
    public function headings(): array
    {
        return $this->headers;
    }
}
