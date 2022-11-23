<?php

declare(strict_types=1);

namespace App\IATI\Services\ImportActivity;

use App\CsvImporter\Events\ActivityCsvWasUploaded;
use App\CsvImporter\Queue\Processor;
use App\IATI\Repositories\Activity\ActivityRepository;
use App\IATI\Repositories\Activity\TransactionRepository;
use App\IATI\Repositories\Organization\OrganizationRepository;
use App\Imports\CsvToArray;
use Exception;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Session\SessionManager;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\File as FileFacade;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Excel;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class ImportManager.
 */
class ImportCsvService
{
    /**
     * Directory where the validated Csv data is written before import.
     */
    public string $csv_data_storage_path;

    /**
     * File in which the valida Csv data is written before import.
     */
    public const VALID_CSV_FILE = 'valid.json';

    /**
     * File in which the invalid Csv data is written before import.
     */
    public const INVALID_CSV_FILE = 'invalid.json';

    /**
     * Directory where the uploaded Csv file is stored temporarily before import.
     */
    public string $csv_file_storage_path;

    /**
     * Default encoding for csv file.
     */
    public const DEFAULT_ENCODING = 'UTF-8';

    /**
     * @var Excel
     */
    protected Excel $excel;

    /**
     * @var Processor
     */
    protected Processor $processor;

    /**
     * @var LoggerInterface
     */
    protected LoggerInterface $logger;

    /**
     * @var SessionManager
     */
    protected SessionManager $sessionManager;

    /**
     * @var ActivityRepository
     */
    protected ActivityRepository $activityRepo;

    /**
     * @var OrganizationRepository
     */
    protected OrganizationRepository $organizationRepo;

    /**
     * @var TransactionRepository
     */
    protected TransactionRepository $transactionRepo;

    /**
     * @var Filesystem
     */
    protected Filesystem $filesystem;

    /**
     * ImportManager constructor.
     *
     * @param Excel                  $excel
     * @param Processor              $processor
     * @param LoggerInterface        $logger
     * @param SessionManager         $sessionManager
     * @param ActivityRepository     $activityRepo
     * @param OrganizationRepository $organizationRepo
     * @param TransactionRepository  $transactionRepo
     * @param Filesystem             $filesystem
     */
    public function __construct(
        Excel $excel,
        Processor $processor,
        LoggerInterface $logger,
        SessionManager $sessionManager,
        ActivityRepository $activityRepo,
        OrganizationRepository $organizationRepo,
        TransactionRepository $transactionRepo,
        Filesystem $filesystem
    ) {
        $this->excel = $excel;
        $this->processor = $processor;
        $this->logger = $logger;
        $this->sessionManager = $sessionManager;
        $this->activityRepo = $activityRepo;
        $this->organizationRepo = $organizationRepo;
        $this->transactionRepo = $transactionRepo;
        $this->filesystem = $filesystem;
        $this->csv_data_storage_path = env('CSV_DATA_STORAGE_PATH', 'CsvImporter/tmp');
        $this->csv_file_storage_path = env('CSV_FILE_STORAGE_PATH', 'CsvImporter/file');
    }

    /**
     * Process the uploaded CSV file.
     *
     * @param $filename
     *
     * @return void
     */
    public function process($filename): void
    {
        try {
            $uploadedFile = awsGetFile(sprintf('%s/%s/%s', $this->csv_file_storage_path, Auth::user()->organization->id, $filename));
            $localStorageFile = $this->localStorageFile($uploadedFile, $filename);
            Session::put('user_id', Auth::user()->id);
            Session::put('org_id', Auth::user()->organization->id);

            $this->processor->pushIntoQueue($localStorageFile, $filename, $this->getIdentifiers());
        } catch (Exception $e) {
            $this->logger->error(
                $e->getMessage(),
                [
                    'user'  => auth()->user(),
                    'trace' => $e->getTraceAsString(),
                ]
            );
        }
    }

    /**
     * Returns local storage file.
     *
     * @param $file
     * @param $filename
     *
     * @return File
     */
    public function localStorageFile($file, $filename): File
    {
        $localStorage = Storage::disk('local');
        $localStoragePath = sprintf('%s/%s/%s', env('CSV_FILE_LOCAL_STORAGE_PATH'), Auth::user()->organization->id, $filename);
        $localStorage->put($localStoragePath, $file);

        return new File(storage_path(sprintf('%s/%s', 'app', $localStoragePath)));
    }

    /**
     * Create Valid activities.
     *
     * @param      $activities
     *
     * @return void
     * @throws \JsonException
     */
    public function create($activities): void
    {
        $organizationId = Auth::user()->organization_id;
        $file = awsGetFile(sprintf('%s/%s/%s', $this->csv_data_storage_path, $organizationId, self::VALID_CSV_FILE));
        $contents = json_decode($file, true, 512, JSON_THROW_ON_ERROR);

        $organizationIdentifier = Arr::get(
            $this->organizationRepo->getOrganizationData($organizationId)->toArray(),
            'reporting_org.0.reporting_organization_identifier'
        );

        foreach ($activities as $value) {
            $activity = $contents[$value];
            $activity['data']['organization_id'] = $organizationId;
            $iati_identifier_text = $organizationIdentifier . '-' . Arr::get($activity, 'data.identifier.activity_identifier');
            $activity['data']['identifier']['iati_identifier_text'] = $iati_identifier_text;

            if (Arr::get($activity, 'existence') === true) {
                $oldActivity = $this->activityRepo->getActivityWithIdentifier($organizationId, Arr::get($activity, 'data.identifier'));
                $this->activityRepo->updateActivity($oldActivity->id, Arr::get($activity, 'data'));

                $this->transactionRepo->deleteTransaction($oldActivity->id);

                if (array_key_exists('transaction', $activity['data'])) {
                    $this->createTransaction(Arr::get($activity['data'], 'transaction', []), $oldActivity->id);
                }
            } else {
                $createdActivity = $this->activityRepo->createActivity(Arr::get($activity, 'data'));

                if (array_key_exists('transaction', $activity['data'])) {
                    $this->createTransaction(Arr::get($activity['data'], 'transaction', []), $createdActivity->id);
                }
            }
        }

        $this->activityImportStatus($activities);
    }

    /**
     * Create Transaction of Valid Activities.
     *
     * @param $transactions
     * @param $activityId
     *
     * @return void
     */
    public function createTransaction($transactions, $activityId): void
    {
        foreach ($transactions as $transaction) {
            $this->transactionRepo->store(['transaction' => $transaction, 'activity_id' => $activityId]);
        }
    }

    /**
     * Check the status of the csv activities being imported.
     *
     * @param $activities
     *
     * @return void
     * @throws \JsonException
     */
    protected function activityImportStatus($activities): void
    {
        if (session('importing') && $this->checkStatusFile()) {
            $this->removeImportedActivity($activities);
        }

        if ($this->checkStatusFile() && is_null(session('importing'))) {
            $this->removeImportDirectory();
        }
    }

    /**
     * Remove the imported activity if the csv is still being processed.
     *
     * @param $checkedActivities
     *
     * @return void
     * @throws \JsonException
     */
    protected function removeImportedActivity($checkedActivities): void
    {
        $validActivities = json_decode(file_get_contents($this->getFilePath(true)), true, 512, JSON_THROW_ON_ERROR);

        foreach ($checkedActivities as $key => $activity) {
            unset($validActivities[$key]);
        }

        FileFacade::put($this->getFilePath(true), $validActivities);
    }

    /**
     * Check if the status.json file is present.
     *
     * @return bool
     */
    protected function checkStatusFile(): bool
    {
        return file_exists(sprintf('%s/%s/%s', $this->csv_data_storage_path, Session::get('org_id'), 'status.json'));
    }

    /**
     * Remove the user folder containing valid, invalid and status json.
     *
     * @return void
     */
    public function removeImportDirectory(): void
    {
        $directoryPath = storage_path(sprintf('%s/%s', $this->csv_data_storage_path, Session::get('org_id')));
        $this->filesystem->deleteDirectory($directoryPath);
    }

    /**
     * Set the key to specify that import process has started for the current User.
     *
     * @param $filename
     *
     * @return $this
     */
    public function startImport($filename): static
    {
        Session::put('import-status', 'Processing');
        Session::put('filename', $filename);

        return $this;
    }

    /**
     * Remove the import-status key from the User's current session.
     *
     * @return void
     */
    public function endImport(): void
    {
        Session::forget('import-status');
        Session::forget('filename');
    }

    /**
     * Get the filepath to the file in which the Csv data is written after processing for import.
     *
     * @param $filename
     *
     * @return string
     */
    public function getFilePath($filename = null): string
    {
        if ($filename) {
            return storage_path(sprintf('%s/%s/%s', $this->csv_data_storage_path, Auth::user()->organization_id, $filename));
        }

        return storage_path(sprintf('%s/%s/%s', $this->csv_data_storage_path, Auth::user()->organization_id, self::VALID_CSV_FILE));
    }

    /**
     * Get the filepath for the temporary files used by the import process.
     *
     * @param $filename
     *
     * @return string
     */
    public function getTemporaryFilepath($filename = null): string
    {
        if ($filename) {
            return storage_path(sprintf('%s/%s/%s', $this->csv_data_storage_path, Session::get('org_id'), $filename));
        }

        return storage_path(sprintf('%s/%s/', $this->csv_data_storage_path, Session::get('org_id')));
    }

    /**
     * Set import-status key when the processing is complete.
     *
     * @return void
     */
    protected function completeImport(): void
    {
        Session::put('import-status', 'Complete');
    }

    /**
     * Get the processed data from the server.
     *
     * @param $filePath
     * @param $temporaryFileName
     * @param $view
     *
     * @return mixed
     * @throws \JsonException
     */
    protected function getDataFrom($filePath, $temporaryFileName, $view): mixed
    {
        $activities = json_decode(file_get_contents($filePath), true, 512, JSON_THROW_ON_ERROR);
        $path = $this->getTemporaryFilepath($temporaryFileName);

        FileFacade::put($path, json_encode($activities, JSON_THROW_ON_ERROR));

        return $activities;
    }

    /**
     * Get processed data from the server.
     *
     * @return array|null
     */
    public function getData(): ?array
    {
        try {
            [$validFilepath, $invalidFilepath, $response] = [$this->getFilePath(true), $this->getFilePath(false), []];

            if (file_exists($validFilepath)) {
                $validResponse = $this->getDataFrom($validFilepath, 'valid-temp.json', 'valid');
                $response['validData'] = ['render' => $validResponse];
            }

            if (file_exists($invalidFilepath)) {
                $invalidResponse = $this->getDataFrom($invalidFilepath, 'invalid-temp.json', 'invalid');
                $response['invalidData'] = ['render' => $invalidResponse];
            }

            return $response;
        } catch (Exception $e) {
            $this->logger->error(
                sprintf('Error during reading data due to [%s]', $e->getMessage()),
                [
                    'trace'           => $e->getTraceAsString(),
                    'user_id'         => Auth::user()->organization_id,
                    'organization_id' => Session::get('org_id'),
                ]
            );

            return null;
        }
    }

    /**
     * Uploads Csv file to bucket before import.
     *
     * @param UploadedFile $file
     *
     * @return bool|null
     */
    public function storeCsv(UploadedFile $file): ?bool
    {
        try {
            return awsUploadFile(sprintf('%s/%s/%s', $this->csv_file_storage_path, Auth::user()->organization_id, str_replace(' ', '', $file->getClientOriginalName())), $file->getContent());
        } catch (Exception $e) {
            $this->logger->error(
                sprintf('Error uploading Activity CSV file due to [%s]', $e->getMessage()),
                [
                    'trace'   => $e->getTraceAsString(),
                    'user_id' => Auth::user()->organization_id,
                ]
            );

            return null;
        }
    }

    /**
     * Get the temporary Csv filepath for the uploaded Csv file.
     *
     * @param $filename
     *
     * @return string
     */
    public function getStoredCsvPath($filename = null): string
    {
        if ($filename) {
            return sprintf('%s/%s', storage_path(sprintf('%s/%s', 'CsvImporter/file', Session::get('org_id'))), $filename);
        }

        return storage_path(sprintf('%s/%s/', 'CsvImporter/file', Session::get('org_id')));
    }

    /**
     * Clear keys from the current session.
     *
     * @param array $keys
     */
    public function clearSession(array $keys): void
    {
        foreach ($keys as $key) {
            Session::forget($key);
        }
    }

    /**
     * Fire Csv Upload event on Csv File upload.
     *
     * @param $filename
     */
    public function fireCsvUploadEvent($filename): void
    {
        Event::dispatch(new ActivityCsvWasUploaded($filename));
    }

    /**
     * Check if an old import is on going.
     *
     * @return bool
     */
    protected function hasOldData(): bool
    {
        return Session::has('import-status') || Session::has('filename');
    }

    /**
     * Clear old import data before another.
     */
    public function clearOldImport(): void
    {
        awsDeleteFile(sprintf('%s/%s', $this->csv_data_storage_path, Session::get('org_id')));

        if ($this->hasOldData()) {
            $this->clearSession(['import-status', 'filename']);
        }
    }

    /**
     * Checks if the file is empty or not.
     *
     * @param $file
     *
     * @return bool
     */
    public function isCsvFileEmpty($file): bool
    {
        return !((($this->excel->toCollection(new CsvToArray, $file)->first()->count() > 1)));
    }

    /**
     * Provides all the activity identifiers.
     *
     * @return array
     */
    protected function getIdentifiers(): array
    {
        $org_id = Auth::user()->organization_id;

        return Arr::flatten($this->activityRepo->getActivityIdentifiers($org_id)->toArray());
    }

    /**
     * Checks if the file is in UTF8Encoding.
     *
     * @param $filename
     *
     * @return bool
     */
    public function isInUTF8Encoding($filename): bool
    {
        $uploadedFile = awsGetFile(sprintf('%s/%s/%s', $this->csv_file_storage_path, Auth::user()->organization->id, $filename));
        $s3 = Storage::disk('local');
        $localPath = sprintf('%s/%s/%s', 'CsvImporter/file', Auth::user()->organization->id, $filename);
        $s3->put($localPath, $uploadedFile);

        $file = new File(storage_path(sprintf('%s/%s', 'app', $localPath)));

        return getEncodingType($file) === self::DEFAULT_ENCODING;
    }

    public function getAwsCsvData($filename)
    {
        try {
            $contents = awsGetFile(sprintf('%s/%s/%s', $this->csv_data_storage_path, Auth::user()->organization_id, $filename));

            if ($contents) {
                return json_decode($contents, false, 512, JSON_THROW_ON_ERROR);
            }

            return false;
        } catch (Exception $exception) {
            $this->logger->error(
                sprintf('Error due to %s', $exception->getMessage()),
                [
                    'trace'    => $exception->getTraceAsString(),
                    'user_id'  => auth()->user()->id,
                    'filename' => $filename,
                ]
            );

            return null;
        }
    }
}
