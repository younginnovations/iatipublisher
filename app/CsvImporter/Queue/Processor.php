<?php

declare(strict_types=1);

namespace App\CsvImporter\Queue;

use App\CsvImporter\CsvReader\CsvReader;
use App\CsvImporter\Queue\Jobs\ImportActivity;
use App\Imports\CsvToArrayWithHeaders;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Class Processor.
 */
class Processor
{
    use DispatchesJobs;

    /**
     * @var CsvReader
     */
    protected CsvReader $csvReader;

    /**
     * Processor constructor.
     * @param CsvReader $csvReader
     */
    public function __construct(CsvReader $csvReader)
    {
        $this->csvReader = $csvReader;
    }

    /**
     * Push a CSV file's data for processing into Queue.
     *
     * @param $file
     * @param $filename
     * @param $activityIdentifiers
     * @param $organizationReportingOrg
     *
     * @return void
     */
    public function pushIntoQueue($file, $filename, $activityIdentifiers, $organizationReportingOrg): void
    {
        $str = mb_convert_encoding(file_get_contents($file->getPathName()), 'UTF-8');
        file_put_contents($file->getPathName(), $str);
        $csv = Excel::toCollection(new CsvToArrayWithHeaders, $file)->first()->toArray();

        $this->dispatch(
            new ImportActivity(new CsvProcessor($csv, app()->getLocale()), $filename, $activityIdentifiers, $organizationReportingOrg)
        );
    }
}
