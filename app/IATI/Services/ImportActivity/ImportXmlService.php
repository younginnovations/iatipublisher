<?php

declare(strict_types=1);

namespace App\IATI\Services\ImportActivity;

use App\IATI\Repositories\Activity\ActivityRepository;
use App\IATI\Repositories\Activity\IndicatorRepository;
use App\IATI\Repositories\Activity\PeriodRepository;
use App\IATI\Repositories\Activity\ResultRepository;
use App\IATI\Repositories\Activity\TransactionRepository;
use App\XmlImporter\Events\XmlWasUploaded;
use App\XmlImporter\Foundation\Support\Providers\XmlServiceProvider;
use App\XmlImporter\Foundation\XmlProcessor;
use DOMDocument;
use Exception;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class XmlImportManager.
 */
class ImportXmlService
{
    /**
     * Temporary Xml file storage location.
     */
    public string $xml_file_storage_path;

    /**
     * Temporary Xml data storage location.
     */
    public string $xml_data_storage_path;

    /**
     * Temporary Csv data storage location.
     */
    public string $csv_data_storage_path;

    /**
     * @var XmlServiceProvider
     */
    protected XmlServiceProvider $xmlServiceProvider;

    /**
     * @var XmlProcessor
     */
    protected XmlProcessor $xmlProcessor;

    /**
     * @var LoggerInterface
     */
    protected LoggerInterface $logger;

    /**
     * @var Filesystem
     */
    protected Filesystem $filesystem;

    /**
     * @var XmlService
     */
    protected XmlService $xmlService;

    /**
     * @var ActivityRepository
     */
    protected ActivityRepository $activityRepository;

    /**
     * @var TransactionRepository
     */
    protected TransactionRepository $transactionRepository;

    /**
     * @var ResultRepository
     */
    protected ResultRepository $resultRepository;

    /**
     * @var PeriodRepository
     */
    protected PeriodRepository $periodRepository;

    /**
     * @var IndicatorRepository
     */
    private IndicatorRepository $indicatorRepository;

    /**
     * XmlImportManager constructor.
     *
     * @param XmlServiceProvider    $xmlServiceProvider
     * @param ActivityRepository    $activityRepository
     * @param TransactionRepository $transactionRepository
     * @param ResultRepository      $resultRepository
     * @param PeriodRepository      $periodRepository
     * @param IndicatorRepository   $indicatorRepository
     * @param XmlProcessor          $xmlProcessor
     * @param LoggerInterface       $logger
     * @param Filesystem            $filesystem
     * @param XmlService            $xmlService
     */
    public function __construct(
        XmlServiceProvider $xmlServiceProvider,
        ActivityRepository $activityRepository,
        TransactionRepository $transactionRepository,
        ResultRepository $resultRepository,
        PeriodRepository $periodRepository,
        IndicatorRepository $indicatorRepository,
        XmlProcessor $xmlProcessor,
        LoggerInterface $logger,
        Filesystem $filesystem,
        XmlService $xmlService
    ) {
        $this->xmlServiceProvider = $xmlServiceProvider;
        $this->xmlProcessor = $xmlProcessor;
        $this->logger = $logger;
        $this->filesystem = $filesystem;
        $this->xmlService = $xmlService;
        $this->transactionRepository = $transactionRepository;
        $this->activityRepository = $activityRepository;
        $this->resultRepository = $resultRepository;
        $this->indicatorRepository = $indicatorRepository;
        $this->periodRepository = $periodRepository;
        $this->xml_file_storage_path = env('XML_FILE_STORAGE_PATH', 'XmlImporter/file');
        $this->xml_data_storage_path = env('XML_DATA_STORAGE_PATH', 'XmlImporter/tmp');
        $this->csv_data_storage_path = env('CSV_DATA_STORAGE_PATH', 'CsvImporter/tmp');
    }

    /**
     * @param $path
     * @param $content
     *
     * @return void
     */
    public function uploadFile($path, $content): void
    {
        Storage::disk('s3')->put($path, $content);
    }

    /**
     * Temporarily store the uploaded Xml file.
     *
     * @param UploadedFile $file
     *
     * @return bool
     */
    public function store(UploadedFile $file): bool
    {
        try {
            return awsUploadFile(sprintf('%s/%s/%s', $this->xml_file_storage_path, Auth::user()->organization_id, $file->getClientOriginalName()), $file->getContent());
        } catch (Exception $exception) {
            $this->logger->error(
                sprintf('Error uploading Xml file due to %s', $exception->getMessage()),
                [
                    'trace' => $exception->getTraceAsString(),
                    'user'  => auth()->user()->id,
                ]
            );

            return false;
        }
    }

    /**
     * Create Valid activities.
     *
     * @param $activities
     *
     * @return bool
     * @throws \JsonException
     */
    public function create($activities): bool
    {
        $contents = $this->loadJsonFile('valid.json');

        foreach ($activities as $value) {
            $activity = $contents[$value];

            if ($activity->existence === true) {
                $oldActivity = $this->activityRepository->getActivityWithIdentifier(Auth::user()->organization->id, (array) $activity->data->iati_identifier);

                $this->activityRepository->importXmlActivities($oldActivity->id, (array) $activity->data);
                $this->transactionRepository->deleteTransaction($oldActivity->id);
                $this->resultRepository->deleteResult($oldActivity->id);
                $this->saveTransactions($activity->data->transactions, $oldActivity->id)
                    ->saveResults($activity->data->result, $oldActivity->id);
            } else {
                $storeActivity = $this->activityRepository->importXmlActivities(null, (array) $activity->data);

                $this->saveTransactions($activity->data->transactions, $storeActivity->id)
                    ->saveResults($activity->data->result, $storeActivity->id);
            }
        }

        return true;
    }

    /**
     * Save transaction of mapped activity in database.
     *
     * @param $transactions
     * @param $activityId
     *
     * @return $this
     */
    protected function saveTransactions($transactions, $activityId): static
    {
        if ($transactions) {
            foreach ($transactions as $transaction) {
                $this->transactionRepository->store([
                    'activity_id' => $activityId,
                    'transaction' => $transaction,
                ]);
            }
        }

        return $this;
    }

    /**
     * Save result of mapped activity in database.
     *
     * @param $results
     * @param $activityId
     *
     * @return $this
     */
    protected function saveResults($results, $activityId): static
    {
        if ($results) {
            foreach ($results as $result) {
                $result = (array) $result;
                $indicators = Arr::get($result, 'indicator', []);
                unset($result['indicator']);

                $savedResult = $this->resultRepository->store([
                    'activity_id' => $activityId,
                    'result'      => $result,
                ]);

                foreach ($indicators as $indicator) {
                    $indicator = (array) $indicator;
                    $periods = Arr::get($indicator, 'period', []);
                    unset($indicator['period']);
                    logger()->error($indicator);

                    $savedIndicator = $this->indicatorRepository->store([
                        'result_id' => $savedResult['id'],
                        'indicator' => $indicator,
                    ]);

                    foreach ($periods as $period) {
                        $this->periodRepository->store([
                            'indicator_id' => $savedIndicator['id'],
                            'period'       => $period,
                        ]);
                    }
                }
            }
        }

        return $this;
    }

    /**
     * Get the temporary storage path for the uploaded Xml file.
     *
     * @param $filename
     *
     * @return string
     */
    protected function getXmlDataStoragePath($filename): string
    {
        return sprintf('%s/%s', storage_path(sprintf('%s/%s', $this->xml_data_storage_path, Auth::user()->organization_id)), $filename);
    }

    /**
     * @param $filename
     * @param $userId
     * @param $orgId
     *
     * @return void
     * @throws \JsonException
     */
    public function startImport($filename, $userId, $orgId): void
    {
        awsDeleteFile(sprintf('%s/%s/%s', $this->xml_data_storage_path, $orgId, 'valid.json'));
        awsUploadFile(sprintf('%s/%s/%s', $this->xml_data_storage_path, $orgId, 'status.json'), json_encode(['success' => true, 'message' => 'Started'], JSON_THROW_ON_ERROR));

        $this->fireXmlUploadEvent($filename, $userId, $orgId);
    }

    /**
     * Fire the XmlWasUploaded event.
     *
     * @param $filename
     * @param $userId
     * @param $organizationId
     *
     * @return void
     */
    protected function fireXmlUploadEvent($filename, $userId, $organizationId): void
    {
        $iatiIdentifiers = $this->dbIatiIdentifiers($organizationId);
        $orgRef = Auth::user()->organization->identifier;

        Event::dispatch(new XmlWasUploaded($filename, $userId, $organizationId, $orgRef, $iatiIdentifiers));
    }

    /**
     * Load a json file with a specific filename.
     *
     * @param $filename
     *
     * @return mixed|null
     */
    public function loadJsonFile($filename): mixed
    {
        try {
            $contents = awsGetFile(sprintf('%s/%s/%s', $this->xml_data_storage_path, Auth::user()->organization_id, $filename));

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

    /**
     * Load the xml from the given filePath.
     *
     * @param $filePath
     *
     * @return string
     */
    protected function loadXml($filePath): string
    {
        libxml_use_internal_errors(false);

        $document = new DOMDocument();
        $document->load($filePath);

        return $document->saveXML();
    }

    /**
     * Returns array of iati identifiers present in the activities of the organisation.
     *
     * @param $org_id
     *
     * @return array
     */
    protected function dbIatiIdentifiers($org_id): array
    {
        return Arr::flatten($this->activityRepository->getActivityIdentifiers($org_id)->toArray());
    }
}
