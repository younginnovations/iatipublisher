<?php

declare(strict_types=1);

namespace App\XmlImporter\Foundation;

use App\IATI\Repositories\Activity\ActivityRepository;
use App\XmlImporter\Foundation\Support\Providers\XmlServiceProvider;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\DatabaseManager;
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
     * XmlQueueProcessor constructor.
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
            $file = $this->temporaryXmlStorage($filename);
            $dbIatiIdentifiers = $this->dbIatiIdentifiers($orgId);
            $contents = file_get_contents($file);

            if ($this->xmlServiceProvider->isValidAgainstSchema($contents)) {
                $xmlData = $this->xmlServiceProvider->load($contents);

                $this->logger->info('Xml Import process started for Organization: ' . $orgId . ', User: ' . $userId);

                $this->xmlProcessor->process($xmlData, $userId, $orgId, $dbIatiIdentifiers);

                return true;
            } else {
                // shell_exec(sprintf('chmod 777 -R %s', $this->temporaryXmlStorage()));
                $this->databaseManager->rollback();

                $this->storeInJsonFile('schema_error.json', ['filename' => $filename, 'version' => $this->xmlServiceProvider->version($contents)]);
            }

            return false;
        } catch (\Exception $exception) {
            $this->logger->error('Xml Import process failed for Organization: ' . $orgId . ', User:' . $userId, ['error' => $exception->getTraceAsString()]);
            $this->storeInJsonFile('error.json', ['code' => 'processing_error', 'message' => 'error']);
            throw  $exception;
        }
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
            return sprintf('%s/%s', storage_path(sprintf('%s/%s', self::UPLOADED_XML_STORAGE_PATH, $this->orgId)), $filename);
        }

        return storage_path(sprintf('%s/%s/', self::UPLOADED_XML_STORAGE_PATH, $this->orgId));
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

    /**
     * Returns activities of the organisation.
     *
     * @return mixed
     */
    protected function dbActivities(): mixed
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
