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
    public const CSV_DATA_STORAGE_PATH = 'csvImporter/tmp';

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
    public const UPLOADED_CSV_STORAGE_PATH = 'csvImporter/tmp/file';

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
     * Current User's id.
     * @var
     */
    protected $userId;

    /**
     * @var Filesystem
     */
    protected Filesystem $filesystem;

    /**
     * ImportManager constructor.
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
        $this->userId = Auth::user()?->organization_id ?? 1;
        $this->filesystem = $filesystem;
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
            $file = new File($this->getStoredCsvPath($filename));

            $fileType = $this->getFileType($file);
            Session::put(['file_type' => $fileType]);

            $activityIdentifiers = $this->getIdentifiers();

            $this->processor->pushIntoQueue($file, $filename, $activityIdentifiers);
        } catch (Exception $exception) {
            $this->logger->error(
                $exception->getMessage(),
                [
                    'user'  => auth()->user(),
                    'trace' => $exception->getTraceAsString(),
                ]
            );
        }
    }

    /**
     * Create Valid activities.
     *
     * @param      $activities
     * @param bool $dontOverwrite
     *
     * @return void
     * @throws \JsonException
     */
    public function create($activities, bool $dontOverwrite = false): void
    {
        $contents = json_decode(file_get_contents($this->getFilePath(true)), true, 512, JSON_THROW_ON_ERROR);
        $organizationId = Auth::user()->organization_id;

        $organizationIdentifier = Arr::get(
            $this->organizationRepo->getOrganizationData($organizationId)->toArray(),
            'reporting_org.0.reporting_organization_identifier'
        );

        foreach ($activities as $value) {
            $activity = $contents[$value];
            $activity['data']['organization_id'] = $organizationId;
            $iati_identifier_text = $organizationIdentifier . '-' . Arr::get($activity, 'data.identifier.activity_identifier');
            $activity['data']['identifier']['iati_identifier_text'] = $iati_identifier_text;

            if ($this->isOldActivity($activity)) {
                $oldActivity = $this->activityRepo->getActivityWithIdentifier($organizationId, Arr::get($activity, 'data.identifier'));

                $this->activityRepo->updateActivity($oldActivity->id, Arr::get($activity, 'data'));
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
     * Merge existing transactions with imported transactions based on transaction reference.
     *
     * @param array    $activity
     * @param Activity $oldActivity
     *
     * @return void
     */
    public function mergeTransactions(array &$activity, Activity $oldActivity): void
    {
        foreach (Arr::get($activity, 'data.transaction', []) as $key => $transaction) {
            if (!empty(Arr::get($transaction, 'reference'))) {
                $reference = $transaction['reference'];

                foreach ($oldActivity->transactions as $oldTransaction) {
                    if ($reference === $oldTransaction->transaction['reference']) {
                        $newTransaction = $transaction + $oldTransaction->transaction;
                        $oldTransaction->transaction = $newTransaction;
                        unset($activity['data']['transaction'][$key]);
                        $oldTransaction->save();
                    }
                }
            }
        }
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
        return file_exists(storage_path(sprintf('%s/%s/%s', self::CSV_DATA_STORAGE_PATH, session('org_id'), 'status.json')));
    }

    /**
     * Remove the user folder containing valid, invalid and status json.
     *
     * @return void
     */
    public function removeImportDirectory(): void
    {
        $this->filesystem->deleteDirectory(storage_path(sprintf('%s/%s/%s', self::CSV_DATA_STORAGE_PATH, session('org_id'), $this->userId)));
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
     * @param $isValid
     *
     * @return string
     */
    public function getFilePath($isValid): string
    {
        if ($isValid) {
            return storage_path(sprintf('%s/%s/%s', self::CSV_DATA_STORAGE_PATH, Auth::user()->organization_id, self::VALID_CSV_FILE));
        }

        return storage_path(sprintf('%s/%s/%s', self::CSV_DATA_STORAGE_PATH, Auth::user()->organization_id, self::INVALID_CSV_FILE));
    }

    /**
     * Clear all invalid activities.
     *
     * @return bool|null
     */
    public function clearInvalidActivities(): ?bool
    {
        try {
            [$file, $temporaryFile] = [$this->getFilePath(false), $this->getTemporaryFilepath('invalid-temp.json')];

            if (file_exists($file)) {
                unlink($file);
            }

            if (file_exists($temporaryFile)) {
                unlink($temporaryFile);
            }

            return true;
        } catch (Exception $exception) {
            $this->logger->error(
                sprintf('Error clearing invalid Activities due to [%s]', $exception->getMessage()),
                [
                    'trace'           => $exception->getTraceAsString(),
                    'user_id'         => $this->userId,
                    'organization_id' => session('org_id'),
                ]
            );

            return null;
        }
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
            return storage_path(sprintf('%s/%s/%s/%s', self::CSV_DATA_STORAGE_PATH, session('org_id'), $this->userId, $filename));
        }

        return storage_path(sprintf('%s/%s/%s/', self::CSV_DATA_STORAGE_PATH, session('org_id'), $this->userId));
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
     * Get the Csv Import status from the current User's session.
     *
     * @return mixed|string|null
     * @throws \JsonException
     */
    public function getSessionStatus(): mixed
    {
        if ($this->checkStatusFile()) {
            $status = file_get_contents($this->getTemporaryFilepath('status.json'));

            if (json_decode($status, true, 512, JSON_THROW_ON_ERROR)['status'] === 'Complete') {
                return 'Complete';
            }
        }

        if (Session::has('import-status')) {
            return Session::get('import-status');
        }

        return null;
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

        // $this->fixStagingPermission($this->getTemporaryFilepath());

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
        } catch (Exception $exception) {
            $this->logger->error(
                sprintf('Error during reading data due to [%s]', $exception->getMessage()),
                [
                    'trace'           => $exception->getTraceAsString(),
                    'user_id'         => $this->userId,
                    'organization_id' => session('org_id'),
                ]
            );

            return null;
        }
    }

    /**
     * Store Csv file before import.
     *
     * @param UploadedFile $file
     *
     * @return bool|null
     */
    public function storeCsv(UploadedFile $file): ?bool
    {
        try {
            $file->move($this->getStoredCsvPath(), str_replace(' ', '', $file->getClientOriginalName()));

            return true;
        } catch (Exception $exception) {
            $this->logger->error(
                sprintf('Error uploading Activity CSV file due to [%s]', $exception->getMessage()),
                [
                    'trace'   => $exception->getTraceAsString(),
                    'user_id' => $this->userId,
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
            return sprintf('%s/%s', storage_path(sprintf('%s/%s/%s', self::UPLOADED_CSV_STORAGE_PATH, session('org_id'), $this->userId)), $filename);
        }

        return storage_path(sprintf('%s/%s/%s/', self::UPLOADED_CSV_STORAGE_PATH, session('org_id'), $this->userId));
    }

    /**
     * Reset session values if necessary.
     *
     * @return void
     */
    public function refreshSessionIfRequired(): void
    {
        if (Session::get('import-status') == 'Complete') {
            Session::forget('filename');
        }
    }

    /**
     * Check if any exceptions have been caught.
     *
     * @return bool
     * @throws \JsonException
     */
    public function caughtExceptions(): bool
    {
        $filepath = $this->getTemporaryFilepath('header_mismatch.json');

        if (file_exists($filepath)) {
            $contents = json_decode(file_get_contents($filepath), true, 512, JSON_THROW_ON_ERROR);
            if (array_key_exists('mismatch', $contents)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Record if the headers have been mismatched during processing.
     */
    public function reportHeaderMismatch(): void
    {
        Session::put(['header_mismatch' => true]);
    }

    /**
     * Clear keys from the current session.
     * @param array $keys
     */
    public function clearSession(array $keys): void
    {
        foreach ($keys as $key) {
            Session::forget($key);
        }
    }

    /**
     * Check if header mismatch has been recorded.
     *
     * @return bool
     */
    public function headersHadBeenMismatched(): bool
    {
        return Session::has('header_mismatch') && (Session::get('header_mismatch') === true);
    }

    /**
     * Fix file permission while on staging environment.
     * @param $path
     */
    protected function fixStagingPermission($path): void
    {
        // TODO: Remove this.
        shell_exec(sprintf('chmod 777 -R %s', $path));
    }

    /**
     * Delete a temporary file with the provided filename.
     * @param $filename
     * @return $this
     */
    public function deleteFile($filename): static
    {
        if (file_exists($this->getTemporaryFilepath($filename))) {
            unlink($this->getTemporaryFilepath($filename));
        }

        return $this;
    }

    /**
     * Fire Csv Upload event on Csv File upload.
     * @param $filename
     */
    public function fireCsvUploadEvent($filename): void
    {
        Event::dispatch(new ActivityCsvWasUploaded($filename));
    }

    /**
     * Check if the import process is complete.
     *
     * @return bool|string
     * @throws \JsonException
     */
    public function importIsComplete(): bool|string
    {
        $filePath = $this->getTemporaryFilepath('status.json');

        if (file_exists($filePath)) {
            $this->fixStagingPermission($filePath);

            $jsonContents = file_get_contents($filePath);
            $contents = json_decode($jsonContents, true, 512, JSON_THROW_ON_ERROR);

            if ($contents['status'] === 'Complete') {
                $this->completeImport();
            }

            return json_decode($jsonContents, false, 512, JSON_THROW_ON_ERROR)->status;
        }

        return false;
    }

    /**
     * Check if an old import is on going.
     *
     * @return bool
     */
    protected function hasOldData(): bool
    {
        if (Session::has('import-status') || Session::has('filename') || Session::has('activity_consortium_id')) {
            return true;
        }

        return false;
    }

    /**
     * Clear old import data before another.
     */
    public function clearOldImport(): void
    {
        $this->removeImportDirectory();

        if ($this->hasOldData()) {
            $this->clearSession(['import-status', 'filename', 'activity_consortium_id']);
        }
    }

    /**
     * Fetch the processed data.
     *
     * @param $filepath
     * @param $temporaryFilename
     *
     * @return array|mixed
     * @throws \JsonException
     */
    public function fetchData($filepath, $temporaryFilename): mixed
    {
        $activities = json_decode(file_get_contents($filepath), true, 512, JSON_THROW_ON_ERROR);
        $tempPath = $this->getTemporaryFilepath($temporaryFilename);

        if (file_exists($tempPath)) {
            $old = json_decode(file_get_contents($tempPath), true, 512, JSON_THROW_ON_ERROR);
            $diff = array_diff_key($activities, $old);
            $total = array_merge($diff, $old);

            FileFacade::put($tempPath, json_encode($total, JSON_THROW_ON_ERROR));

            $activities = $diff;
        } else {
            FileFacade::put($tempPath, json_encode($activities, JSON_THROW_ON_ERROR));
        }

        return $activities;
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
        return (($this->excel->toCollection(new CsvToArray, $file)->first()->count() > 1)) ? false : true;
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
     * Check if the uploaded Activity data is of an existing Activity.
     *
     * @param $activity
     * @return bool
     */
    protected function isOldActivity($activity): bool
    {
        return Arr::get($activity, 'existence') === true;
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
        $file = new File($this->getStoredCsvPath($filename));

        if (getEncodingType($file) === self::DEFAULT_ENCODING) {
            return true;
        }

        return false;
    }

    /**
     * Get type of file.
     *
     * @param File $file
     *
     * @return string|null
     */
    public function getFileType(File $file): ?string
    {
        $fileContent = array_map('str_getcsv', file($file->getPathName()));
        $headerCount = count($fileContent[0]);
        $headersArray = 69;

        return $headersArray[$headerCount] ?? $this->reportHeaderMismatch();
    }
}
