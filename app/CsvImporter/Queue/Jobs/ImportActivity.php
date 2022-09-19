<?php

declare(strict_types=1);

namespace App\CsvImporter\Queue\Jobs;

use App\CsvImporter\Queue\CsvProcessor;
use App\Jobs\Job;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

/**
 * Class ImportActivity.
 */
class ImportActivity extends Job implements ShouldQueue
{
    /**
     * @var CsvProcessor
     */
    protected CsvProcessor $csvProcessor;

    /**
     * Current Organization's Id.
     * @var
     */
    protected mixed $organizationId;

    /**
     * Current User's id.
     * @var
     */
    protected $userId;

    /**
     * Directory where the uploaded Csv file is stored temporarily before import.
     */
    public const UPLOADED_CSV_STORAGE_PATH = 'csvImporter/tmp/file';

    /**
     * @var
     */
    protected $filename;

    /**
     * @var
     */
    private $activityIdentifiers;

    /**
     * Create a new job instance.
     *
     * @param CsvProcessor $csvProcessor
     * @param              $filename
     * @param              $activityIdentifiers
     */
    public function __construct(CsvProcessor $csvProcessor, $filename, $activityIdentifiers)
    {
        $this->csvProcessor = $csvProcessor;
        $this->organizationId = Session::get('org_id');
        $this->userId = Session::get('user_id');
        $this->filename = $filename;
        $this->activityIdentifiers = $activityIdentifiers;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $directoryPath = storage_path(sprintf('%s/%s', 'csvImporter/tmp', $this->organizationId));
        if (!is_dir($directoryPath)) {
            mkdir($directoryPath, 0777, true);
        }
        $path = sprintf('%s/%s', $directoryPath, 'status.json');
        try {
            file_put_contents($path, json_encode(['status' => 'Processing'], JSON_THROW_ON_ERROR));

            $this->csvProcessor->handle($this->organizationId, $this->userId, $this->activityIdentifiers);
            file_put_contents($path, json_encode(['status' => 'Complete'], JSON_THROW_ON_ERROR));

            $uploadedFilepath = $this->getStoredCsvFilePath($this->filename);

            if (file_exists($uploadedFilepath)) {
                unlink($uploadedFilepath);
            }

            $this->delete();
        } catch (\Exception $exception) {
            file_put_contents($path, json_encode(['status' => 'Complete'], JSON_THROW_ON_ERROR));

            Log::error($exception->getMessage() . ' in ' . $exception->getFile() . ':' . $exception->getLine());
            $this->delete();
        }
    }

    /**
     * Get the temporary Csv filepath for the uploaded Csv file.
     *
     * @param $filename
     *
     * @return string
     */
    protected function getStoredCsvFilePath($filename): string
    {
        return sprintf('%s/%s', storage_path(sprintf('%s/%s', self::UPLOADED_CSV_STORAGE_PATH, Session::get('org_id'))), $filename);
    }
}
