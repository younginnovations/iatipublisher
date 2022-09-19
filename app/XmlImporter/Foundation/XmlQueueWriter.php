<?php

declare(strict_types=1);

namespace App\XmlImporter\Foundation;

use App\IATI\Repositories\Activity\ActivityRepository;
use App\IATI\Repositories\Activity\DocumentLinkRepository;
use App\IATI\Repositories\Activity\ResultRepository;
use App\IATI\Repositories\Activity\TransactionRepository;
use App\XmlImporter\Foundation\Support\Factory\XmlValidator;
use Illuminate\Support\Arr;

/**
 * Class XmlQueueWriter.
 */
class XmlQueueWriter
{
    /**
     * @var ActivityRepository
     */
    protected ActivityRepository $activityRepo;

    /**
     * @var TransactionRepository
     */
    protected TransactionRepository $transactionRepo;

    /**
     * @var ResultRepository
     */
    protected ResultRepository $resultRepo;

    /**
     * @var DocumentLinkRepository
     */
    protected DocumentLinkRepository $documentLinkRepo;

    /**
     *  Path to xml importer.
     */
    public const UPLOADED_XML_STORAGE_PATH = 'xmlImporter/tmp/file';

    /**
     * @var
     */
    protected $userId;

    /**
     * @var
     */
    protected $orgId;

    /**
     * @var
     */
    protected $jsonData;

    /**
     * @var int
     */
    protected int $success = 0;
    /**
     * @var int
     */
    protected int $failed = 0;

    /**
     * @var array
     */
    protected array $existing = [];

    /**
     * @var
     */
    protected $dbIatiIdentifiers;

    /**
     * XmlQueueWriter constructor.
     * @param                    $userId
     * @param                    $orgId
     * @param                    $dbIatiIdentifiers
     * @param ActivityRepository $activityRepo
     * @param TransactionRepository        $transactionRepo
     * @param ResultRepository           $resultRepo
     * @param DocumentLinkRepository       $documentLinkRepo
     */
    public function __construct($userId, $orgId, $dbIatiIdentifiers, ActivityRepository $activityRepo, TransactionRepository $transactionRepo, ResultRepository $resultRepo, DocumentLinkRepository $documentLinkRepo)
    {
        $this->activityRepo = $activityRepo;
        $this->transactionRepo = $transactionRepo;
        $this->resultRepo = $resultRepo;
        $this->documentLinkRepo = $documentLinkRepo;
        $this->userId = $userId;
        $this->orgId = $orgId;
        $this->dbIatiIdentifiers = $dbIatiIdentifiers;
    }

    /**
     * Store mapped activity in database.
     *
     * @param $mappedActivity
     * @param $totalActivities
     * @param $index
     *
     * @return bool
     */
    public function save($mappedActivity, $totalActivities, $index): bool
    {
        $iatiIdentifierText = Arr::get($mappedActivity, 'identifier.iati_identifier_text');
        $xmlValidator = app(XmlValidator::class);

        if ($this->activityAlreadyExists($iatiIdentifierText)) {
            $this->existing[] = $iatiIdentifierText;
        }

        $errors = $xmlValidator
            ->init($mappedActivity)
            ->validateActivity(true);

        if ($this->isIatiIdentifierDifferent($iatiIdentifierText)) {
            $mappedActivity['org_id'] = $this->orgId;
            // $storeActivity = $this->activityRepo->importXmlActivities($mappedActivity, $this->orgId);
            // $activityId = $storeActivity->id;
            $this->success++;

            $this->appendDataIntoFile($mappedActivity, Arr::flatten($errors), $this->existing, storage_path(sprintf('%s/%s/%s', self::UPLOADED_XML_STORAGE_PATH, $this->orgId, 'valid.json')));
        // $this->saveTransactions($mappedActivity, $activityId)
            //     ->saveResults($mappedActivity, $activityId)
            //     ->saveDocumentLink($mappedActivity, $activityId);
        } else {
            $this->failed++;
            $this->storeInvalidActivity($mappedActivity, $index);
        }
        $this->storeXmlImportStatus($totalActivities, $index + 1, $this->success, $this->failed, $this->existing);

        return true;
    }

/**
 * Save transaction of mapped activity in database.
 *
 * @param $activity
 * @param $activityId
 *
 * @return $this
 */
protected function saveTransactions($activity, $activityId): static
{
    $transactionRepo = $this->transactionRepo;

    foreach (Arr::get($activity, 'transactions', []) as $transaction) {
        $transactionRepo->createTransaction($transaction, $activityId);
    }

    return $this;
}

/**
 * Save result of mapped activity in database.
 *
 * @param $activity
 * @param $activityId
 *
 * @return $this
 */
protected function saveResults($activity, $activityId): static
{
    $resultRepo = $this->resultRepo;
    foreach (Arr::get($activity, 'result', []) as $result) {
        $resultData['result'] = $result;
        $resultRepo->xmlResult($resultData, $activityId);
    }

    return $this;
}

/**
 * Save document link of mapped activity in database.
 *
 * @param $activity
 * @param $activityId
 *
 * @return $this
 */
protected function saveDocumentLink($activity, $activityId): static
{
    $documentLinkRepo = $this->documentLinkRepo;
    foreach (Arr::get($activity, 'document_link', []) as $documentLink) {
        $documentLinkData['document_link'] = $documentLink;
        $documentLinkRepo->xmlDocumentLink($documentLinkData, $activityId);
    }

    return $this;
}

    /**
     * Get the temporary storage path for the uploaded Xml file.
     *
     * @param null $filename
     *
     * @return string
     */
    protected function temporaryXmlStorage($filename = null): string
    {
        if ($filename) {
            return sprintf('%s/%s', storage_path(sprintf('%s/%s', self::UPLOADED_XML_STORAGE_PATH, $this->orgId)), $filename);
        }

        return storage_path(sprintf('%s/%s/', self::UPLOADED_XML_STORAGE_PATH, $this->orgId));
    }

    /**
     * @param $identifier
     *
     * @return bool
     */
    public function activityAlreadyExists($identifier): bool
    {
        return in_array($identifier, $this->dbIatiIdentifiers, true);
    }

    /**
     * Check if the iati identifier text is similar to the identifier of imported xml file.
     *
     * @param $xmlIdentifier
     *
     * @return bool
     */
    protected function isIatiIdentifierDifferent($xmlIdentifier): bool
    {
        if ($xmlIdentifier === '' || in_array($xmlIdentifier, $this->dbIatiIdentifiers, true)) {
            return false;
        }

        return true;
    }

    /**
     * @param $totalActivities
     * @param $currentActivity
     * @param $success
     * @param $failed
     * @param $existing
     *
     * @return void
     */
    protected function storeXmlImportStatus($totalActivities, $currentActivity, $success, $failed, $existing): void
    {
        shell_exec(sprintf('chmod 777 -R %s', $this->temporaryXmlStorage()));
        $data = ['total_activities' => $totalActivities, 'current_activity_count' => $currentActivity, 'success' => $success, 'failed' => $failed, 'existing' => $existing];
        $this->storeInJsonFile('xml_completed_status.json', $data);
    }

    /**
     * Append data into the file containing previous data.
     *
     * @param $data
     * @param $errors
     * @param $existence
     * @param $destinationFilePath
     *
     * @return void
     * @throws \JsonException
     */
    protected function appendDataIntoFile($data, $errors, $existence, $destinationFilePath): void
    {
        array_walk_recursive($errors, static function ($a) use (&$return) {
            $return[] = $a;
        });

        if (file_exists($destinationFilePath)) {
            $currentContents = json_decode(file_get_contents($destinationFilePath), true, 512, JSON_THROW_ON_ERROR);
            $currentContents[] = ['data' => $data, 'errors' => $errors, 'status' => 'processed', 'existence' => $existence];

            file_put_contents($destinationFilePath, json_encode($currentContents, JSON_THROW_ON_ERROR));
        } else {
            file_put_contents($destinationFilePath, json_encode([['data' => $data, 'errors' => $errors, 'status' => 'processed', 'existence' => $existence]], JSON_THROW_ON_ERROR));
        }
    }

    /**
     * Store Activities having same identifier in a json file.
     *
     * @param $activity
     * @param $index
     *
     * @return void
     */
    protected function storeInvalidActivity($activity, $index): void
    {
        $this->jsonData[$index] = $activity;
        $this->storeInJsonFile('xml_invalid.json', $this->jsonData);
    }

    /**
     * Store Activities having same identifier in a json file.
     *
     * @param $activity
     * @param $index
     *
     * @return void
     */
    protected function storeValidActivity($activity, $index): void
    {
        $data = ['data' => $activity, 'existence' => false, 'existing' => 'hey'];

        $this->storeInJsonFile('xml_valid.json', $this->jsonData);
    }

    /**
     * Store data in given json filename.
     *
     * @param $filename
     * @param $data
     *
     * @return void
     * @throws \JsonException
     */
    protected function storeInJsonFile($filename, $data): void
    {
        $filePath = $this->temporaryXmlStorage($filename);
        file_put_contents($filePath, json_encode($data, JSON_THROW_ON_ERROR));
    }
}
