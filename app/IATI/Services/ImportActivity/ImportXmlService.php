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
    const UPLOADED_XML_STORAGE_PATH = 'xmlImporter/tmp/file';

    /**
     * @var XmlServiceProvider
     */
    protected $xmlServiceProvider;

    /**
     * @var XmlProcessor
     */
    protected $xmlProcessor;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @var XmlService
     */
    protected $xmlService;

    protected $activityRepository;
    protected $transactionRepository;
    protected $resultRepository;
    protected $periodRepository;

    /**
     * XmlImportManager constructor.
     *
     * @param XmlServiceProvider $xmlServiceProvider
     * @param XmlProcessor       $xmlProcessor
     * @param LoggerInterface    $logger
     * @param Filesystem         $filesystem
     * @param XmlService         $xmlService
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
     * @return bool|null
     */
    public function store(UploadedFile $file)
    {
        try {
            $file->move($this->temporaryXmlStorage(), $file->getClientOriginalName());
            shell_exec(sprintf('chmod 777 -R %s', $this->temporaryXmlStorage()));

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
     * @param $activities
     */
    public function create($activities)
    {
        $contents = $this->loadJsonFile('valid.json');

        foreach ($activities as $value) {
            $activity = $contents[$value];
            $storeActivity = $this->activityRepository->importXmlActivities((array) $activity->data, Auth::user()->organization_id);
            $activityId = $storeActivity->id;
            $this->saveTransactions($activity->data->transactions, $activityId)
                ->saveResults($activity->data->result, $activityId);
        }

        return true;

        // $this->activityImportStatus($activities);
    }

    /**
     *  Save transaction of mapped activity in database.
     * @param $activity
     * @param $activityId
     * @return $this
     */
    protected function saveTransactions($transactions, $activityId)
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
     *  Save result of mapped activity in database.
     * @param $activity
     * @param $activityId
     * @return $this
     */
    protected function saveResults($results, $activityId)
    {
        foreach ($results as $result) {
            $result = (array) $result;
            $indicators = $result['indicator'];
            unset($result['indicator']);

            $savedResult = $this->resultRepository->store([
                'activity_id' => $activityId,
                'result' => $result,
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
                        'period' => $period,
                    ]);
                }
            }
        }

        return $this;
    }

    /**
     *  Save document link of mapped activity in database.
     * @param $activity
     * @param $activityId
     * @return $this
     */
    protected function saveDocumentLink($documentLinks, $activityId)
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
     * @param null $filename
     * @return string
     */
    protected function temporaryXmlStorage($filename = null)
    {
        if ($filename) {
            return sprintf('%s/%s', storage_path(sprintf('%s/%s', self::UPLOADED_XML_STORAGE_PATH, Auth::user()->organization_id)), $filename);
        }

        return storage_path(sprintf('%s/%s/', self::UPLOADED_XML_STORAGE_PATH, Auth::user()->organization_id));
    }

    public function checkStatus()
    {
        if (file_exists($this->temporaryXmlStorage('status.json'))) {
            $content = json_decode(file_get_contents($this->temporaryXmlStorage('status.json')), true);

            return $content['xml_import_status'];
        }

        return null;
    }

    public function deleteStatusFile()
    {
        $this->filesystem->delete($this->temporaryXmlStorage('status.json'));
    }

    /**
     * Get the id for the current user.
     *
     * @return mixed
     */
    protected function getUserId()
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
     */
    public function startImport($filename, $userId, $organizationId, $consortium_id = null)
    {
        if (file_exists($this->temporaryXmlStorage('valid.json'))) {
            unlink($this->temporaryXmlStorage('valid.json'));
        }

        $contents = json_encode(['xml_import_status' => 'started']);
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
     */
    protected function fireXmlUploadEvent($filename, $userId, $organizationId, $consortium_id = null)
    {
        Event::dispatch(new XmlWasUploaded($filename, $userId, $organizationId, $consortium_id));
    }

    /**
     * Load a json file with a specific filename.
     *
     * @param $filename
     * @return mixed|null
     */
    public function loadJsonFile($filename)
    {
        try {
            $filePath = $this->temporaryXmlStorage($filename);

            if (file_exists($filePath)) {
                return json_decode(file_get_contents($filePath));
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
    public function removeTemporaryXmlFolder()
    {
        $filePath = $this->temporaryXmlStorage();
        $this->filesystem->deleteDirectory($filePath);
    }

    /**
     * Returns errors from the xml.
     * @param $filename
     * @param $version
     */
    public function parseXmlErrors($filename, $version)
    {
        $filePath = $this->temporaryXmlStorage($filename);
        $xml = $this->loadXml($filePath);
        $xmlLines = $this->xmlService->formatUploadedXml($xml);
        $messages = $this->xmlService->getSchemaErrors($xml, $version);
        Session::put('xmlLines', $xmlLines);
        Session::put('messages', $messages);
    }

    /**
     * Load the xml from the given filePath.
     * @param $filePath
     * @return string
     */
    protected function loadXml($filePath)
    {
        libxml_use_internal_errors(true);

        $document = new DOMDocument();
        $document->load($filePath);

        return $document->saveXML();
    }
}
