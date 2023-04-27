<?php

declare(strict_types=1);

namespace App\XlsImporter\Foundation;

use App\IATI\Repositories\Activity\ActivityRepository;
use App\XlsImporter\Foundation\Mapper\XlsMapper;
use App\XlsImporter\Foundation\XlsProcessor\XlsToArray;
use Arr;
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
    protected $reportingOrg;

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
    public function import($filename, $orgId, $reportingOrg, $userId, $dbIatiIdentifiers, $xlsType): bool
    {
        try {
            $this->orgId = $orgId;
            $this->reportingOrg = $reportingOrg;
            $this->userId = $userId;
            $this->filename = $filename;
            $filePath = sprintf('%s/%s/%s/%s', $this->xls_file_storage_path, $this->orgId, $this->userId, $filename);
            $contents = awsGetFile(sprintf('%s/%s/%s/%s', $this->xls_file_storage_path, $this->orgId, $this->userId, $filename));

            $xlsToArray = new XlsToArray();
            Excel::import($xlsToArray, $filePath, 's3');
            $contents = $xlsToArray->sheetData;

            if (!$this->checkXlsFile($contents, $xlsType)) {
                return false;
            }

            file_put_contents(app_path() . '/XlsImporter/Templates/test.json', json_encode($contents));

            $this->xlsMapper->process($contents, $xlsType, $userId, $orgId, $reportingOrg, $dbIatiIdentifiers);

            $this->databaseManager->rollback();

            return false;
        } catch (\Exception $e) {
            logger()->error($e);
            awsUploadFile(sprintf('%s/%s/%s/%s', $this->xls_data_storage_path, $orgId, $userId, 'status.json'), json_encode(['success' => false, 'message' => 'Error has occurred while importing the file.'], JSON_THROW_ON_ERROR));

            throw $e;
        }
    }

    public function checkXlsFile($content, $xlsType)
    {
        $sheets = Arr::get($this->getXlsSheets(), $xlsType, []);
        $excelColumns = Arr::get($this->getXlsHeaders(), $xlsType, []);

        if (!$this->checkSheetNames(array_keys($content), $sheets)) {
            awsUploadFile(sprintf('%s/%s/%s/%s', $this->xls_data_storage_path, $this->orgId, $this->userId, 'status.json'), json_encode(['success' => false, 'message' => 'Sheet missing in xls file.'], JSON_THROW_ON_ERROR));

            return false;
        }

        foreach ($content as $sheetName=>$data) {
            $dataHeader = array_keys(Arr::get($data, '0', []));
            $actualHeader = array_keys(Arr::get($excelColumns, $sheetName, []));

            if (!$this->checkColumnHeader($dataHeader, $actualHeader) && !in_array($sheetName, ['Instructions', 'Options'])) {
                awsUploadFile(sprintf('%s/%s/%s/%s', $this->xls_data_storage_path, $this->orgId, $this->userId, 'status.json'), json_encode(['success' => false, 'message' => 'Header mismatch in xls file.'], JSON_THROW_ON_ERROR));

                return false;
            }
        }

        return true;
    }

    public function checkSheetNames($sheetNames, $sheets)
    {
        foreach ($sheets as $sheetName => $type) {
            if (!in_array($sheetName, $sheetNames) && $type === 'required') {
                return false;
            }

            unset($sheetNames[$sheetName]);
        }

        // if (count($sheetNames)) {
        //     return false;
        // }

        return true;
    }

    public function checkColumnHeader($dataHeader, $actualHeader)
    {
        if (count(array_diff($actualHeader, $dataHeader)) || count(array_diff($actualHeader, $dataHeader))) {
            return false;
        }

        return true;
    }

    /**
     * Returns content of xls sheets.
     *
     * @return array
     */
    public function getXlsSheets(): array
    {
        return json_decode(file_get_contents(app_path() . '/XlsImporter/Templates/excel-sheets.json'), true, 512, 0);
    }

    /**
     * Returns headers present in xls sheets.
     *
     * @return array
     */
    public function getXlsHeaders(): array
    {
        return json_decode(file_get_contents(app_path() . '/XlsImporter/Templates/excel-column-name-mapper.json'), true, 512, 0);
    }
}
