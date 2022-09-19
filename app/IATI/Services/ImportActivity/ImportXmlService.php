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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Session;
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
    public const UPLOADED_XML_STORAGE_PATH = 'xmlImporter/tmp/file';

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
    }

    /**
     * Temporarily store the uploaded Xml file.
     *
     * @param UploadedFile $file
     *
     * @return bool|null
     */
    public function store(UploadedFile $file): ?bool
    {
        try {
            $file->move($this->temporaryXmlStorage(), $file->getClientOriginalName());

            // shell_exec(sprintf('chmod 777 -R %s', $this->temporaryXmlStorage()));

            return true;
        } catch (Exception $exception) {
            $this->logger->error(
                sprintf('Error uploading Xml file due to %s', $exception->getMessage()),
                [
                    'trace' => $exception->getTraceAsString(),
                    'user'  => auth()->user()->id,
                ]
            );

            return null;
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
                $oldActivity = $this->activityRepository->getActivityWithIdentifier(Auth::user()->organization->id, (array) $activity->data->identifier);
                // dd($oldActivity->id);
                $storeActivity = $this->activityRepository->importXmlActivities($oldActivity->id, (array) $activity->data);
                $this->transactionRepository->deleteTransaction($oldActivity->id);
                $this->resultRepository->deleteResult($oldActivity->id);

                $this->saveTransactions($activity->data->transactions, $oldActivity->id)
                     ->saveResults($activity->data->result, $oldActivity->id);
            } else {
                $storeActivity = $this->activityRepository->importXmlActivities(null, (array) $activity->data);
                $activityId = $storeActivity->id;
                $this->saveTransactions($activity->data->transactions, $activityId)
                     ->saveResults($activity->data->result, $activityId);
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
        foreach ($transactions as $transaction) {
            $this->transactionRepository->store([
                'activity_id' => $activityId,
                'transaction' => $transaction,
            ]);
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
        foreach ($results as $result) {
            $result = (array) $result;
            $indicators = $result['indicator'];
            unset($result['indicator']);

            $savedResult = $this->resultRepository->store([
                'activity_id' => $activityId,
                'result'      => $result,
            ]);

            foreach ($indicators as $indicator) {
                $indicator = (array) $indicator;
                $periods = $indicator['period'];
                $savedIndicatory = $this->indicatorRepository->store([
                    'result_id' => $savedResult['id'],
                    'indicator' => $indicator,
                ]);

                foreach ($periods as $period) {
                    $this->periodRepository->store([
                        'indicator_id' => $savedIndicatory['id'],
                        'period'       => $period,
                    ]);
                }
            }
        }

        return $this;
    }

    /**
     * Save document link of mapped activity in database.
     *
     * @param $documentLinks
     * @param $activityId
     *
     * @return $this
     */
    protected function saveDocumentLink($documentLinks, $activityId): static
    {
        foreach ($documentLinks as $documentLink) {
            $documentLinkData['document_link'] = $documentLink;
            $this->documentLinkRepo->xmlDocumentLink($documentLinkData, $activityId);
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
    protected function temporaryXmlStorage($filename = null): string
    {
        if ($filename) {
            return sprintf('%s/%s', storage_path(sprintf('%s/%s', self::UPLOADED_XML_STORAGE_PATH, Auth::user()->organization_id)), $filename);
        }

        return storage_path(sprintf('%s/%s/', self::UPLOADED_XML_STORAGE_PATH, Auth::user()->organization_id));
    }

    /**
     * @return mixed|null
     * @throws \JsonException
     */
    public function checkStatus(): mixed
    {
        if (file_exists($this->temporaryXmlStorage('status.json'))) {
            $content = json_decode(file_get_contents($this->temporaryXmlStorage('status.json')), true, 512, JSON_THROW_ON_ERROR);

            return $content['xml_import_status'];
        }

        return null;
    }

    /**
     * @return void
     */
    public function deleteStatusFile(): void
    {
        $this->filesystem->delete($this->temporaryXmlStorage('status.json'));
    }

    /**
     * Get the id for the current user.
     *
     * @return mixed
     */
    protected function getUserId(): mixed
    {
        if (auth()->check()) {
            return auth()->user()->id;
        }
    }

    /**
     * @param $filename
     * @param $userId
     * @param $organizationId
     * @param $consortium_id
     *
     * @return void
     * @throws \JsonException
     */
    public function startImport($filename, $userId, $organizationId, $consortium_id = null): void
    {
        if (file_exists($this->temporaryXmlStorage('valid.json'))) {
            unlink($this->temporaryXmlStorage('valid.json'));
        }

        $contents = json_encode(['xml_import_status' => 'started'], JSON_THROW_ON_ERROR);
        $this->filesystem->put($this->temporaryXmlStorage('status.json'), $contents);
        $this->fireXmlUploadEvent($filename, $userId, $organizationId, $consortium_id);
    }

    /**
     * Fire the XmlWasUploaded event.
     *
     * @param $filename
     * @param $userId
     * @param $organizationId
     * @param $consortium_id
     *
     * @return void
     */
    protected function fireXmlUploadEvent($filename, $userId, $organizationId, $consortium_id = null): void
    {
        Event::dispatch(new XmlWasUploaded($filename, $userId, $organizationId, $consortium_id));
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
            $filePath = $this->temporaryXmlStorage($filename);

            if (file_exists($filePath)) {
                return json_decode(file_get_contents($filePath), false, 512, JSON_THROW_ON_ERROR);
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
     * Remove Temporarily Stored Xml file.
     */
    public function removeTemporaryXmlFolder(): void
    {
        $filePath = $this->temporaryXmlStorage();
        $this->filesystem->deleteDirectory($filePath);
    }

    /**
     * Returns errors from the xml.
     *
     * @param $filename
     *
     * @return void
     */
    public function parseXmlErrors($filename): void
    {
        $filePath = $this->temporaryXmlStorage($filename);
        $xml = $this->loadXml($filePath);
        $xmlLines = $this->xmlService->formatUploadedXml($xml);
        $messages = $this->xmlService->getSchemaErrors($xml);
        Session::put('xmlLines', $xmlLines);
        Session::put('messages', $messages);
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
        libxml_use_internal_errors(true);

        $document = new DOMDocument();
        $document->load($filePath);

        return $document->saveXML();
    }
}
