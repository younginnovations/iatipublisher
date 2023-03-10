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
    public string $xml_data_storage_path;

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
    protected $orgRef;

    /**
     * @var
     */
    protected $xmlActivityIdentifiers;

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
     * @param                        $orgRef
     * @param                        $dbIatiIdentifiers
     * @param                        $xmlActivityIdentifiers
     * @param ActivityRepository     $activityRepo
     * @param TransactionRepository  $transactionRepo
     * @param ResultRepository       $resultRepo
     * @param DocumentLinkRepository $documentLinkRepo
     */
    public function __construct(
        $userId,
        $orgId,
        $orgRef,
        $dbIatiIdentifiers,
        $xmlActivityIdentifiers,
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
        $this->orgRef = $orgRef;
        $this->dbIatiIdentifiers = $dbIatiIdentifiers;
        $this->xmlActivityIdentifiers = $xmlActivityIdentifiers;
        $this->xml_data_storage_path = env('XML_DATA_STORAGE_PATH ', 'XmlImporter/tmp');
    }

    /**
     * Store mapped activity in database.
     *
     * @param $mappedActivity
     *
     * @return bool
     * @throws \JsonException
     */
    public function save($mappedActivity): bool
    {
        $activity_identifier = Arr::get($mappedActivity, 'iati_identifier.activity_identifier');
        $xmlValidator = app(XmlValidator::class);
        $existing = $this->activityAlreadyExists($activity_identifier);
        $duplicate = $this->activityIsDuplicate(Arr::get($mappedActivity, 'iati_identifier.iati_identifier_text'));
        $isIdentifierValid = $this->isIdentifierValid(Arr::get($mappedActivity, 'iati_identifier.iati_identifier_text'));

        $errors = $xmlValidator
            ->init($mappedActivity)
            ->validateActivity($duplicate, $isIdentifierValid);

        $mappedActivity['org_id'] = $this->orgId;
        $this->success++;

        $this->appendDataIntoFile($mappedActivity, $errors, $existing);

        return true;
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
     * Checks if xml contains duplicate activity.
     *
     * @param $identifier
     *
     * @return bool
     */
    public function activityIsDuplicate($identifier): bool
    {
        return Arr::get($this->xmlActivityIdentifiers, $identifier, 0) > 1 ? true : false;
    }

    /**
     * Checks if activity identifier is valid for the organization.
     *
     * @param $identifier
     *
     * @return bool
     */
    public function isIdentifierValid($identifier): bool
    {
        return str_starts_with($identifier, $this->orgRef . '-');
    }

    /**iI
     * Append data into the file containing previous data.
     *
     * @param $data
     * @param $errors
     * @param $existence
     *
     * @return void
     * @throws \JsonException
     */
    protected function appendDataIntoFile($data, $errors, $existence): void
    {
        array_walk_recursive($errors, static function ($a) use (&$return) {
            $return[] = $a;
        });

        $validJsonFile = awsGetFile(sprintf('%s/%s/%s/%s', $this->xml_data_storage_path, $this->orgId, $this->userId, 'valid.json'));

        if ($validJsonFile) {
            $currentContents = json_decode($validJsonFile, true, 512, JSON_THROW_ON_ERROR);
            $currentContents[] = ['data' => $data, 'errors' => $errors, 'status' => 'processed', 'existence' => $existence];
            $content = json_encode($currentContents, JSON_THROW_ON_ERROR);
        } else {
            $content = json_encode([['data' => $data, 'errors' => $errors, 'status' => 'processed', 'existence' => $existence]], JSON_THROW_ON_ERROR);
        }

        try {
            $path = sprintf('%s/%s/%s/%s', $this->xml_data_storage_path, $this->orgId, $this->userId, 'valid.json');
            awsUploadFile($path, $content);
        } catch (\Exception $e) {
            awsUploadFile('error-appendDataIntoFile.log', $e->getMessage());
        }
    }
}
