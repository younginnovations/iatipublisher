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
    protected $existing;

    /**
     * @var
     */
    protected $dbIatiIdentifiers;

    /**
     * XmlQueueWriter constructor.
     *
     * @param                        $userId
     * @param                        $orgId
     * @param                        $dbIatiIdentifiers
     * @param ActivityRepository     $activityRepo
     * @param TransactionRepository  $transactionRepo
     * @param ResultRepository       $resultRepo
     * @param DocumentLinkRepository $documentLinkRepo
     */
    public function __construct(
        $userId,
        $orgId,
        $dbIatiIdentifiers,
        ActivityRepository $activityRepo,
        TransactionRepository $transactionRepo,
        ResultRepository $resultRepo,
        DocumentLinkRepository $documentLinkRepo
    ) {
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
        $activity_identifier = Arr::get($mappedActivity, 'identifier.activity_identifier');
        $xmlValidator = app(XmlValidator::class);
        $existing = $this->activityAlreadyExists($activity_identifier);

        $errors = $xmlValidator
            ->init($mappedActivity)
            ->validateActivity(true);

        $mappedActivity['org_id'] = $this->orgId;
        $this->success++;

        $this->appendDataIntoFile($mappedActivity, Arr::flatten($errors), $existing, storage_path(sprintf('%s/%s/%s', self::UPLOADED_XML_STORAGE_PATH, $this->orgId, 'valid.json')));

        return true;
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
        // shell_exec(sprintf('chmod 777 -R %s', $this->temporaryXmlStorage()));
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
