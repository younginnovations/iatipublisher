<?php

declare(strict_types=1);

namespace App\XlsImporter\Foundation;

use App\Exceptions\InvalidTag;
use App\IATI\Repositories\Activity\ActivityRepository;
use App\XlsImporter\Foundation\Mapper\Activity;
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
     * @param ActivityRepository $activityRepo
     * @param DatabaseManager    $databaseManager
     */
    public function __construct(ActivityRepository $activityRepo, DatabaseManager $databaseManager)
    {
        // $this->xmlProcessor = $xmlProcessor;
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
            // dd('here');
            $this->orgId = $orgId;
            $this->orgRef = $orgRef;
            $this->userId = $userId;
            $this->filename = $filename;
            $filePath = sprintf('%s/%s/%s/%s', $this->xls_file_storage_path, $this->orgId, $this->userId, $filename);
            // $contents = awsGetFile(sprintf('%s/%s/%s/%s', $this->xls_file_storage_path, $this->orgId, $this->userId, $filename));
            awsUploadFile(sprintf('%s/%s/%s/%s', $this->xls_data_storage_path, $this->orgId, $this->userId, 'status.json'), json_encode(['success' => true, 'message' => 'Processing'], JSON_THROW_ON_ERROR));

            // dd($contents);
            $xlsToArray = new XlsToArray();
            Excel::import($xlsToArray, $filePath, 's3');
            $data = $xlsToArray->sheetData;

            // foreach ($xlsToArray->getSheetNames() as $index => $sheetName) {
            //     $data[$index] = new ExcelSheetImport();
            // }
            // dd($xlsToArray->sheetData);
            // if ($this->xlsServiceProvider->isValidAgainstSchema($contents)) {
            // $xlsData =;
            // dd($xlsData)
            $activity = new Activity();
            $activity->map($data);
            // $this->->process($xmlData, $userId, $orgId, $orgRef, $dbIatiIdentifiers);

            awsUploadFile(
                sprintf('%s/%s/%s/%s', $this->xls_data_storage_path, $this->orgId, $this->userId, 'status.json'),
                json_encode(
                    ['success' => true, 'message' => 'Complete'],
                    JSON_THROW_ON_ERROR
                )
            );

            awsUploadFile(
                sprintf('%s/%s/%s/%s', $this->xls_data_storage_path, $this->orgId, $this->userId, 'schema_error.log'),
                json_encode(
                    libxml_get_errors(),
                    JSON_THROW_ON_ERROR
                )
            );

            awsUploadFile(
                sprintf('%s/%s/%s/%s', $this->xls_data_storage_path, $orgId, $userId, 'status.json'),
                json_encode(
                    ['success' => false, 'message' => 'Invalid Xls or Header mismatched'],
                    JSON_THROW_ON_ERROR
                )
            );

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
