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
        $this->xml_data_storage_path = env('XML_DATA_STORAGE_PATH ', 'app/XmlImporter/tmp');
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
        $activity_identifier = Arr::get($mappedActivity, 'identifier.activity_identifier');
        $xmlValidator = app(XmlValidator::class);
        $existing = $this->activityAlreadyExists($activity_identifier);

        $errors = $xmlValidator
            ->init($mappedActivity)
            ->validateActivity(true);

        $mappedActivity['org_id'] = $this->orgId;
        $this->success++;

        $this->appendDataIntoFile($mappedActivity, Arr::flatten($errors), $existing, storage_path(sprintf('%s/%s/%s', $this->xml_data_storage_path, $this->orgId, 'valid.json')));

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
}
