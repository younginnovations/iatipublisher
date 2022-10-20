<?php

declare(strict_types=1);

namespace App\XmlImporter\Foundation;

use App\IATI\Repositories\Activity\ActivityRepository;
use App\XmlImporter\Foundation\Support\Providers\XmlServiceProvider;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Psr\Log\LoggerInterface;
use Sabre\Xml\ParseException;

/**
 * Class XmlQueueProcessor.
 */
class XmlQueueProcessor
{
    /**
     * @var XmlServiceProvider
     */
    protected XmlServiceProvider $xmlServiceProvider;
    /**
     * @var XmlProcessor
     */
    protected XmlProcessor $xmlProcessor;

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
    protected $filename;

    /**
     * @var ActivityRepository
     */
    protected ActivityRepository $activityRepo;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @var DatabaseManager
     */
    private DatabaseManager $databaseManager;

    /**
     * @var string
     */
    private string $xml_file_storage_path;

    /**
     * @var string
     */
    private string $xml_data_storage_path;

    /**
     * XmlQueueProcessor constructor.
     *
     * @param XmlServiceProvider $xmlServiceProvider
     * @param XmlProcessor       $xmlProcessor
     * @param ActivityRepository $activityRepo
     * @param DatabaseManager    $databaseManager
     * @param LoggerInterface    $logger
     */
    public function __construct(XmlServiceProvider $xmlServiceProvider, XmlProcessor $xmlProcessor, ActivityRepository $activityRepo, DatabaseManager $databaseManager, LoggerInterface $logger)
    {
        $this->xmlServiceProvider = $xmlServiceProvider;
        $this->xmlProcessor = $xmlProcessor;
        $this->activityRepo = $activityRepo;
        $this->logger = $logger;
        $this->databaseManager = $databaseManager;
        $this->xml_file_storage_path = env('XML_FILE_STORAGE_PATH ', 'XmlImporter/file');
        $this->xml_data_storage_path = env('XML_DATA_STORAGE_PATH ', 'XmlImporter/tmp');
    }

    /**
     * Import the Xml data.
     *
     * @param $filename
     * @param $orgId
     * @param $userId
     *
     * @return bool
     * @throws BindingResolutionException
     * @throws \JsonException
     * @throws ParseException
     * @throws \Throwable
     */
    public function import($filename, $orgId, $userId): bool
    {
        try {
            $this->orgId = $orgId;
            $this->userId = $userId;
            $this->filename = $filename;
            $dbIatiIdentifiers = $this->dbIatiIdentifiers($orgId);
            //$contents          = file_get_contents($this->getXmlFile($filename));
            $contents = awsGetFile(sprintf('%s/%s/%s', $this->xml_file_storage_path, $this->orgId, $filename));
            $mismatchFilePath = storage_path(sprintf('%s/%s/%s', $this->xml_data_storage_path, $orgId, 'header_mismatch.json'));
            awsDeleteFile($mismatchFilePath);

            if ($this->xmlServiceProvider->isValidAgainstSchema($contents)) {
                $xmlData = $this->xmlServiceProvider->load($contents);

                $this->logger->info('Xml Import process started for Organization: ' . $orgId . ', User: ' . $userId);

                $this->xmlProcessor->process($xmlData, $userId, $orgId, $dbIatiIdentifiers);

                return true;
            }

            $this->databaseManager->rollback();
            awsUploadFile($mismatchFilePath, json_encode(['header_mismatch' => true], JSON_THROW_ON_ERROR));

            return false;
        } catch (\Exception $exception) {
            $this->logger->error('Xml Import process failed for Organization: ' . $orgId . ', User:' . $userId, ['error' => $exception]);

            throw  $exception;
        }
    }

    /**
     * Returns activities of the organisation.
     *
     * @return Collection|array
     */
    protected function dbActivities(): Collection|array
    {
        return $this->activityRepo->getActivities($this->orgId);
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
        return Arr::flatten($this->activityRepo->getActivityIdentifiers($org_id)->toArray());
    }
}
