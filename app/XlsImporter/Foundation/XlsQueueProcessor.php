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
        $systemSheets = Arr::get($this->getXlsSheets(), $xlsType, []);
        $excelColumns = $this->getXlsHeaders();
        $activityElements = [
            'Title' => 'title',
            'Other Identifier' => 'other_identifier',
            'Description' => 'description',
            'Activity Date' => 'activity_date',
            'Recipient Country' => 'recipient_country',
            'Recipient Region' => 'recipient_region',
            'Sector' => 'sector',
            'Tag' => 'tag',
            'Policy Marker' => 'policy_marker',
            'Default Aid Type' => 'default_aid_type',
            'Country Budget Items' => 'country_budget_items',
            'Humanitarian Scope' => 'humanitarian_scope',
            'Related Activity' => 'related_activity',
            'Conditions' => 'conditions',
            'Legacy Data' => 'legacy_data',
            'Document Link' => 'document_link',
            'Contact Info' => 'contact_info',
            'Location' => 'location',
            'Planned Disbursement' => 'planned_disbursement',
            'Participating Org' => 'participating_org',
            'Budget' => 'budget',
            'Transaction' => 'transactions',
            'Settings' => 'settings',
            'Element with single field' => 'element_with_single_field',
            'Result Mapper' => 'result_mapper',
            'Result' => 'result',
            'Result Document Link' => 'result_document_link',
            'Indicator Mapper' => 'indicator_mapper',
            'Indicator Baseline Mapper' => 'indicator_baseline_mapper',
            'Indicator' => 'indicator',
            'Indicator Document Link' => 'indicator_document_link',
            'Indicator Baseline' => 'indicator_baseline',
            'Baseline Document Link' => 'baseline_document_link',
            'Period Mapper' => 'period_mapper',
            'Target Mapper' => 'target_mapper',
            'Actual Mapper' => 'actual_mapper',
            'Period' => 'period',
            'Target' => 'target',
            'Target Document Link' => 'target_document_link',
            'Actual' => 'actual',
            'Actual Document Link' => 'actual_document_link',
        ];

        $mainMappingSheet = [
            'activity' => 'Settings',
            'result' => 'Result Mapper',
            'indicator' => 'Indicator Mapper',
            'period' => 'Period Mapper',
        ];

        if (!$this->checkSheetNames(array_keys($content), $systemSheets)) {
            return false;
        }

        foreach ($content as $sheetName => $data) {
            if (!in_array($sheetName, ['Instructions', 'Options', 'Identifiers'])) {
                $dataHeader = array_keys(Arr::get($data, '0', []));
                $actualHeader = array_values(Arr::get($excelColumns, $activityElements[$sheetName], []));

                if (!$this->checkColumnHeader($dataHeader, $actualHeader) && count($data) > 0) {
                    awsUploadFile(sprintf('%s/%s/%s/%s', $this->xls_data_storage_path, $this->orgId, $this->userId, 'status.json'), json_encode(['success' => false, 'message' => 'Header mismatch in ' . $sheetName . ' sheet of xls file.'], JSON_THROW_ON_ERROR));

                    return false;
                }

                if ($sheetName === $mainMappingSheet[$xlsType] && (count($data) === 0 || is_array_value_empty(Arr::get($data, '0', [])))) {
                    awsUploadFile(sprintf('%s/%s/%s/%s', $this->xls_data_storage_path, $this->orgId, $this->userId, 'status.json'), json_encode(['success' => false, 'message' => 'The xls file is empty.'], JSON_THROW_ON_ERROR));

                    return false;
                }
            }
        }

        return true;
    }

    public function checkSheetNames($xlsSheetNames, $systemSheets)
    {
        foreach ($systemSheets as $sheetName => $type) {
            if (!in_array($sheetName, $xlsSheetNames) && $type === 'required') {
                awsUploadFile(sprintf('%s/%s/%s/%s', $this->xls_data_storage_path, $this->orgId, $this->userId, 'status.json'), json_encode(['success' => false, 'message' => $sheetName . ' sheet missing in xls file. Please ensure that the file you have uploaded has correct template.'], JSON_THROW_ON_ERROR));

                return false;
            }

            $xlsSheetNames = array_diff($xlsSheetNames, [$sheetName]);
        }

        if (count($xlsSheetNames)) {
            awsUploadFile(sprintf('%s/%s/%s/%s', $this->xls_data_storage_path, $this->orgId, $this->userId, 'status.json'), json_encode(['success' => false, 'message' => 'Unnecessary sheet is present in the xls file:' . implode(',', $xlsSheetNames)], JSON_THROW_ON_ERROR));

            return false;
        }

        return true;
    }

    public function checkFileEmpty($xlsSheetNames, $systemSheets)
    {
        foreach ($systemSheets as $sheetName => $type) {
            if (!in_array($sheetName, $xlsSheetNames) && $type === 'required') {
                awsUploadFile(sprintf('%s/%s/%s/%s', $this->xls_data_storage_path, $this->orgId, $this->userId, 'status.json'), json_encode(['success' => false, 'message' => $sheetName . ' sheet missing in xls file.'], JSON_THROW_ON_ERROR));

                return false;
            }

            $xlsSheetNames = array_diff($xlsSheetNames, [$sheetName]);
        }

        if (count($xlsSheetNames)) {
            awsUploadFile(sprintf('%s/%s/%s/%s', $this->xls_data_storage_path, $this->orgId, $this->userId, 'status.json'), json_encode(['success' => false, 'message' => 'Unnecessary sheet is present in the xls file:' . implode(',', $xlsSheetNames)], JSON_THROW_ON_ERROR));

            return false;
        }

        return true;
    }

    public function checkColumnHeader($dataHeader, $actualHeader)
    {
        if (count(array_diff($actualHeader, $dataHeader))) {
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
        return json_decode(file_get_contents(app_path() . '/XlsImporter/Templates/linearized-activity.json'), true, 512, 0);
    }
}
