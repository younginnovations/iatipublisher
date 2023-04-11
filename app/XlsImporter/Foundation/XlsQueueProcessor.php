<?php

declare(strict_types=1);

namespace App\XlsImporter\Foundation;

use App\Exceptions\InvalidTag;
use App\IATI\Repositories\Activity\ActivityRepository;
use App\XlsImporter\Foundation\Mapper\XlsMapper;
use App\XlsImporter\Foundation\XlsProcessor\XlsToArray;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\DatabaseManager;
use Maatwebsite\Excel\Facades\Excel;
use Psr\Log\LoggerInterface;
use Sabre\Xml\ParseException;

/**
 * Class XlsQueueProcessor.
 */
class XlsQueueProcessor
{
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
     * @var XlsMapper
     */
    protected XlsMapper $xlsMapper;

    /**
     * @var string
     */
    private string $xls_file_storage_path;

    /**
     * @var string
     */
    private string $xls_data_storage_path;

    /**
     * XlsQueueProcessor constructor.
     *
     * @param XlsMapper          $xlsMapper
     * @param ActivityRepository $activityRepo
     * @param DatabaseManager    $databaseManager
     */
    public function __construct(XlsMapper $xlsMapper, ActivityRepository $activityRepo, DatabaseManager $databaseManager)
    {
        $this->xlsMapper = $xlsMapper;
        $this->activityRepo = $activityRepo;
        $this->databaseManager = $databaseManager;
        $this->xls_file_storage_path = env('XLS_FILE_STORAGE_PATH ', 'XlsImporter/file');
        $this->xls_data_storage_path = env('XLS_DATA_STORAGE_PATH ', 'XlsImporter/tmp');
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
    public function import($filename, $orgId, $orgRef, $userId, $dbIatiIdentifiers): bool
    {
        try {
            logger()->error('here in import');
            $this->orgId = $orgId;
            $this->orgRef = $orgRef;
            $this->userId = $userId;
            $this->filename = $filename;
            $filePath = sprintf('%s/%s/%s/%s', $this->xls_file_storage_path, $this->orgId, $this->userId, $filename);
            $contents = awsGetFile(sprintf('%s/%s/%s/%s', $this->xls_file_storage_path, $this->orgId, $this->userId, $filename));
            awsUploadFile(sprintf('%s/%s/%s/%s', $this->xls_data_storage_path, $this->orgId, $this->userId, 'status.json'), json_encode(['success' => true, 'message' => 'Processing'], JSON_THROW_ON_ERROR));

            $xlsToArray = new XlsToArray();
            Excel::import($xlsToArray, $filePath, 's3');
            $contents = $xlsToArray->sheetData;

            $xlsType = 'basic';

            $this->xlsMapper->process($contents, $xlsType, $userId, $orgId, $orgRef, $dbIatiIdentifiers);

            // awsUploadFile(
            //     sprintf('%s/%s/%s/%s', $this->xls_data_storage_path, $this->orgId, $this->userId, 'status.json'),
            //     json_encode(
            //         ['success' => true, 'message' => 'Complete'],
            //         JSON_THROW_ON_ERROR
            //     )
            // );

            // awsUploadFile(
            //     sprintf('%s/%s/%s/%s', $this->xls_data_storage_path, $this->orgId, $this->userId, 'schema_error.log'),
            //     json_encode(
            //         libxml_get_errors(),
            //         JSON_THROW_ON_ERROR
            //     )
            // );

            // awsUploadFile(
            //     sprintf('%s/%s/%s/%s', $this->xls_data_storage_path, $orgId, $userId, 'status.json'),
            //     json_encode(
            //         ['success' => false, 'message' => 'Invalid Xls or Header mismatched'],
            //         JSON_THROW_ON_ERROR
            //     )
            // );

            $this->databaseManager->rollback();

            return false;
        } catch (InvalidTag $e) {
            awsUploadFile(sprintf('%s/%s/%s/%s', $this->xls_data_storage_path, $orgId, $userId, 'status.json'), json_encode(['success' => false, 'message' => $e->getMessage()], JSON_THROW_ON_ERROR));

            throw $e;
        } catch (\Exception $e) {
            awsUploadFile(sprintf('%s/%s/%s/%s', $this->xls_data_storage_path, $orgId, $userId, 'status.json'), json_encode(['success' => false, 'message' => 'Error has occurred while importing the file.'], JSON_THROW_ON_ERROR));

            throw $e;
        }
    }
}
