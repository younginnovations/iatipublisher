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
     *
     * @var int|mixed
     */
    protected mixed $organizationId;

    /**
     * Current User's id.
     *
     * @var int|mixed
     */
    protected int $userId;

    /**
     * Directory where the uploaded Csv file is stored temporarily before import.
     */
    public string $csv_file_storage_path;

    /**
     * @var string
     */
    protected string $filename;

    /**
     * @var array
     */
    private array $activityIdentifiers;

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
        $this->csv_file_storage_path = env('CSV_FILE_STORAGE_PATH ', 'app/CsvImporter/file');
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \JsonException
     */
    public function handle(): void
    {
        $directoryPath = storage_path(sprintf('%s/%s', env('CSV_DATA_STORAGE_PATH ', 'app/CsvImporter/tmp/'), $this->organizationId));

        if (!file_exists($directoryPath) && !mkdir($directoryPath, 0777, true) && !is_dir($directoryPath)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $directoryPath));
        }

        $path = sprintf('%s/%s', $directoryPath, 'status.json');
        $data_path = sprintf('%s/%s', $directoryPath, 'valid.json');
        try {
            if (file_exists($data_path)) {
                unlink(sprintf('%s/%s', $directoryPath, 'valid.json'));
            }

            file_put_contents($path, json_encode(['status' => 'Processing'], JSON_THROW_ON_ERROR));
            $this->csvProcessor->handle($this->organizationId, $this->userId, $this->activityIdentifiers);
            file_put_contents($path, json_encode(['status' => 'Complete'], JSON_THROW_ON_ERROR));

            $uploadedFilepath = $this->getStoredCsvFilePath($this->filename);

            if (file_exists($uploadedFilepath)) {
                unlink($uploadedFilepath);
            }

            $this->delete();
        } catch (\Exception $exception) {
            Log::error($exception->getMessage() . ' in ' . $exception->getFile() . ':' . $exception->getLine());
            file_put_contents($path, json_encode(['status' => 'Complete'], JSON_THROW_ON_ERROR));

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
        return sprintf('%s/%s', storage_path(sprintf('%s/%s', $this->csv_file_storage_path, Session::get('org_id'))), $filename);
    }
}
