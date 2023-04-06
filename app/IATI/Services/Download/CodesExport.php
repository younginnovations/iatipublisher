<?php

declare(strict_types=1);

namespace App\IATI\Services\Download;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

// use Maatwebsite\Excel\Excel as Generator;
// use PhpOffice\PhpSpreadsheet\Exception;
// use PhpOffice\PhpSpreadsheet\Writer\Exception as ExceptionAlias;
// use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * Class CodesExport.
 */
class CodesExport implements FromCollection
{
    public function collection()
    {
        // return new Collection
        return new Collection([
            [1, 2, 3],
            [4, 5, 6],
        ]);
    }
}
