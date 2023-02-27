<?php

namespace Tests\Unit\Csv;

use App\CsvImporter\Entities\Activity\Components\Factory\Validation;
use App\CsvImporter\Queue\CsvProcessor;
use App\IATI\Services\ImportActivity\ImportCsvService;
use App\Imports\CsvToArrayWithHeaders;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\UploadedFile;
use Maatwebsite\Excel\Facades\Excel;
use Tests\Unit\ImportBaseTest;

class CsvBaseTest extends ImportBaseTest
{
    private string $completeCsvFile = 'tests/Unit/TestFiles/Csv/complete.csv';

    /**
     * @var string
     */
    public string $csvFile;
    /**
     * @var object
     */
    protected object $validation;

    protected array $completeData;

    /**
     * @return void
     * @throws BindingResolutionException
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->validation = app()->make(Validation::class);
        $this->getCompleteData();
    }

    /**
     * Receives data set and makes csv files.
     *
     * @param array $data
     * @return void
     */
    public function initializeCsv(array $data): void
    {
        $dirname = dirname($this->csvFile);

        if (!is_dir($dirname)) {
            mkdir($dirname, 0755, true);
        }

        $fp = fopen($this->csvFile, 'w');

        foreach ($data as $rows) {
            fputcsv($fp, $rows);
        }

        fclose($fp);
    }

    /**
     * @param $data
     * @return array
     */
    public function convertActivityData($data): array
    {
        $keys = array_keys($data);
        $values = array_values($data);
        $num_rows = max(array_map('count', $values));
        $num_cols = count($keys);
        $new_data = [array_values($keys)];

        for ($i = 0; $i < $num_rows; $i++) {
            $row = [];
            for ($j = 0; $j < $num_cols; $j++) {
                if (isset($values[$j][$i])) {
                    $row[] = $values[$j][$i];
                } else {
                    $row[] = '';
                }
            }
            $new_data[] = $row;
        }

        return $new_data;
    }

    /**
     * Fetches csv rows in to array.
     *
     * @param $filePath
     * @return array
     * @throws \ReflectionException
     * @throws BindingResolutionException
     */
    public function getCsvRows($filePath): array
    {
        $file = new UploadedFile($filePath, basename($filePath));
        $str = mb_convert_encoding(file_get_contents($file->getPathName()), 'UTF-8');
        file_put_contents($file->getPathName(), $str);
        $csv = Excel::toCollection(new CsvToArrayWithHeaders, $file)->first()->toArray();

        $csvProcessorObj = new CsvProcessor($csv);
        $csvProcessorObjReflection = new \ReflectionClass($csvProcessorObj);

        $groupvalues = $csvProcessorObjReflection->getMethod('groupValues');
        $groupvalues->setAccessible(true);
        $groupvalues->invoke($csvProcessorObj);

        $dataProperty = $csvProcessorObjReflection->getProperty('data');
        $dataProperty->setAccessible(true);

        return $dataProperty->getValue($csvProcessorObj);
    }

    /**
     * @return array
     * @throws BindingResolutionException
     * @throws \ReflectionException
     */
    public function getIdentifiers(): array
    {
        $importCsvService = app()->make(ImportCsvService::class);
        $reflectionImportCsvService = new \ReflectionClass($importCsvService);
        $activityIdentifier = $reflectionImportCsvService->getMethod('getIdentifiers');
        $activityIdentifier->setAccessible(true);

        return $activityIdentifier->invoke($importCsvService);
    }

    /**
     * Returns perfect data for system.
     *
     * @return array
     */
    public function getPerfectData(): array
    {
        return [
            'Activity Identifier' => ['12345', '67890'],
            'Activity Default Currency' => [],
            'Activity Default Language' => [],
            'Humanitarian' => [],
            'Reporting Org Reference' => [],
            'Reporting Org Type' => [],
            'Reporting Org Secondary Reporter' => [],
            'Reporting Org Narrative' => [],
            'Activity Title' => ['title one', 'title two'],
            'Activity Description (General)' => [],
            'Activity Description (Objectives)' => [],
            'Activity Description (Target Groups)' => [],
            'Activity Description (Others)' => [],
            'Activity Status' => [],
            'Actual Start Date' => [],
            'Actual End Date' => [],
            'Planned Start Date' => [],
            'Planned End Date' => [],
            'Participating Organisation Role' => [],
            'Participating Organisation Reference' => [],
            'Participating Organisation Type' => [],
            'Participating Organisation Name' => [],
            'Participating Organisation Identifier' => [],
            'Participating Organisation Crs Channel Code' => [],
            'Recipient Country Code' => [],
            'Recipient Country Percentage' => [],
            'Recipient Country Narrative' => [],
            'Recipient Region Code' => [],
            'Recipient Region Percentage' => [],
            'Recipient Region Vocabulary Uri' => [],
            'Recipient Region Narrative' => [],
            'Sector Vocabulary' => [],
            'Sector Vocabulary URI' => [],
            'Sector Code' => [],
            'Sector Percentage' => [],
            'Sector Narrative' => [],
            'Transaction Internal Reference' => [],
            'Transaction Type' => [],
            'Transaction Date' => [],
            'Transaction Value' => [],
            'Transaction Value Date' => [],
            'Transaction Description' => [],
            'Transaction Provider Organisation Identifier' => [],
            'Transaction Provider Organisation Type' => [],
            'Transaction Provider Organisation Activity Identifier' => [],
            'Transaction Provider Organisation Description' => [],
            'Transaction Receiver Organisation Identifier' => [],
            'Transaction Receiver Organisation Type' => [],
            'Transaction Receiver Organisation Activity Identifier' => [],
            'Transaction Receiver Organisation Description' => [],
            'Transaction Sector Vocabulary' => [],
            'Transaction Sector Vocabulary URI' => [],
            'Transaction Sector Code' => [],
            'Transaction Sector Narrative' => [],
            'Transaction Recipient Country Code' => [],
            'Transaction Recipient Region Code' => [],
            'Transaction Recipient Region Vocabulary Uri' => [],
            'Policy Marker Vocabulary' => [],
            'Policy Marker Code' => [],
            'Policy Marker Significance' => [],
            'Policy Marker Vocabulary Uri' => [],
            'Policy Marker Narrative' => [],
            'Activity Scope' => [],
            'Budget Type' => [],
            'Budget Status' => [],
            'Budget Period Start' => [],
            'Budget Period End' => [],
            'Budget Value' => [],
            'Budget Value Date' => [],
            'Budget Currency' => [],
            'Related Activity Identifier' => [],
            'Related Activity Type' => [],
            'Contact Type' => [],
            'Contact Organization' => [],
            'Contact Department' => [],
            'Contact Person Name' => [],
            'Contact Job Title' => [],
            'Contact Telephone' => [],
            'Contact Email' => [],
            'Contact Website' => [],
            'Contact Mailing Address' => [],
            'Other Identifier Reference' => [],
            'Other Identifier Type' => [],
            'Owner Org Reference' => [],
            'Owner Org Narrative' => [],
            'Tag Vocabulary' => [],
            'Tag Code' => [],
            'Tag Vocabulary Uri' => [],
            'Tag Narrative' => [],
            'Collaboration Type' => [],
            'Default Flow Type' => [],
            'Default Finance Type' => [],
            'Default Aid Type Vocabulary' => [],
            'Default Aid Type Code' => [],
            'Default Tied Status' => [],
            'Country Budget Item Vocabulary' => [],
            'Budget Item Code' => [],
            'Budget Item Percentage' => [],
            'Budget Item Description' => [],
            'Humanitarian Scope Type' => [],
            'Humanitarian Scope Vocabulary' => [],
            'Humanitarian Scope Vocabulary Uri' => [],
            'Humanitarian Scope Code' => [],
            'Humanitarian Scope Narrative' => [],
            'Capital Spend' => [],
            'Conditions Attached' => [],
            'Condition Type' => [],
            'Condition Narrative' => [],
            'Legacy Data Name' => [],
            'Legacy Data Value' => [],
            'Legacy Data IATI Equivalent' => [],
            'Document Link Url' => [],
            'Document Link Format' => [],
            'Document Link Title' => [],
            'Document Link Description' => [],
            'Document Link Category' => [],
            'Document Link Language' => [],
            'Document Date' => [],
            'Location Reference' => [],
            'Location Reach Code' => [],
            'Location Id Vocabulary' => [],
            'Location Id Code' => [],
            'Location Name' => [],
            'Location Description' => [],
            'Location Activity Description' => [],
            'Location Administrative Vocabulary' => [],
            'Location Administrative Code' => [],
            'Location Administrative Level' => [],
            'Location Point srsName' => [],
            'Pos Latitude' => [],
            'Pos Longitude' => [],
            'Location Exactness' => [],
            'Location Class' => [],
            'Feature Designation' => [],
            'Planned Disbursement Type' => [],
            'Planned Disbursement Period Start' => [],
            'Planned Disbursement Period End' => [],
            'Planned Disbursement Value' => [],
            'Planned Disbursement Value Currency' => [],
            'Planned Disbursement Value Date' => [],
            'Planned Disbursement Provider Org Reference' => [],
            'Planned Disbursement Provider Org Activity Id' => [],
            'Planned Disbursement Provider Org Type' => [],
            'Planned Disbursement Provider Org Narrative' => [],
            'Planned Disbursement Receiver Org Reference' => [],
            'Planned Disbursement Receiver Org Activity Id' => [],
            'Planned Disbursement Receiver Org Type' => [],
            'Planned Disbursement Receiver Org Narrative' => [],
        ];
    }

    /**
     * Sets 100% complete csv file to array variable.
     *
     * @return void
     * @throws BindingResolutionException
     * @throws \ReflectionException
     */
    public function getCompleteData(): void
    {
        $this->completeData = $this->getCsvRows($this->completeCsvFile);
    }
}
