<?php

declare(strict_types=1);

namespace App\IATI\Services\Download;

use Maatwebsite\Excel\Excel as Generator;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Exception as ExceptionAlias;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * Class CsvGenerator.
 */
class CsvGenerator
{
    /**
     * @var Generator
     */
    protected Generator $generator;

    /**
     * Constant for default output format extension.
     */
    public const CSV = 'csv';

    /**
     * @var string.
     */
    protected string $defaultOutputFormat;

    /**
     * CsvGenerator constructor.
     *
     * @param Generator $generator
     */
    public function __construct(Generator $generator)
    {
        $this->generator = $generator;
        $this->defaultOutputFormat = self::CSV;
    }

    /**
     * Generate CSV with headers from an array.
     *
     * @param       $filename
     * @param array $data
     * @param array $headers
     *
     * @return BinaryFileResponse
     *
     * @throws Exception
     * @throws ExceptionAlias
     */
    public function generateWithHeaders($filename, array $data, array $headers): BinaryFileResponse
    {
        return $this->generator->download(new ArrayToCsv($data, $headers), $filename . '.csv');
    }
}
