<?php

declare(strict_types=1);

namespace Tests\Unit\BulkPublishTest;

use App\IATI\Models\Activity\Activity;
use App\IATI\Models\Organization\Organization;
use App\IATI\Models\User\Role;
use App\IATI\Models\User\User;
use App\IATI\Services\Workflow\ActivityWorkflowService;
use App\XmlImporter\Foundation\XmlProcessor;
use DOMDocument;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Sabre\Xml\Service as SabreXmlService;
use Tests\TestCase;

class ValidatorResponseTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Location where test files are located.
     *
     * @var string
     */
    private string $testFilesPath = 'tests/Unit/TestFiles/BulkPublishTestFiles';

    public function test_response()
    {
        $activityWorkflowService = app()->make(ActivityWorkflowService::class);

        $identifiers = [
            'NP-IRD-qareg1-1'      => 'NP-IRD-qareg1-1',
            'NP-IRD-qareg1-2'      => 'NP-IRD-qareg1-2',
            'NP-IRD-qareg1-3'      => 'NP-IRD-qareg1-3',
            'NP-IRD-qareg1-4'      => 'NP-IRD-qareg1-4',
            'NP-IRD-qareg1-5'      => 'NP-IRD-qareg1-5',
            'NP-IRD-qareg1-6'      => 'NP-IRD-qareg1-6',
            'NP-IRD-qareg1-7'      => 'NP-IRD-qareg1-7',
            'NP-IRD-qareg1-8'      => 'NP-IRD-qareg1-8',
            'NP-IRD-qareg1-9'      => 'NP-IRD-qareg1-9',
            'NP-IRD-qareg1-10'     => 'NP-IRD-qareg1-10',
            'NP-IRD-qareg1-11'     => 'NP-IRD-qareg1-11',
            'NP-IRD-qareg1-12'     => 'NP-IRD-qareg1-12',
            'NP-IRD-qareg1-13'     => 'NP-IRD-qareg1-13',
            'NP-IRD-qareg1-14'     => 'NP-IRD-qareg1-14',
            'NP-IRD-qareg1-15'     => 'NP-IRD-qareg1-15',
            'NP-IRD-qareg1-16'     => 'NP-IRD-qareg1-16',
            'NP-IRD-qareg1-17'     => 'NP-IRD-qareg1-17',
            'NP-IRD-qareg1-18'     => 'NP-IRD-qareg1-18',
            'NP-IRD-qareg1-19'     => 'NP-IRD-qareg1-19',
            'NP-IRD-qareg1-20'     => 'NP-IRD-qareg1-20',
            'NP-IRD-qareg1-21'     => 'NP-IRD-qareg1-21',
            'NP-IRD-qareg1-22'     => 'NP-IRD-qareg1-22',
            'NP-IRD-qareg1-23'     => 'NP-IRD-qareg1-23',
            'NP-IRD-qareg1-24'     => 'NP-IRD-qareg1-24',
            'NP-IRD-qareg1-25'     => 'NP-IRD-qareg1-25',
        ];

        $fileNames = [
             'NP-IRD-qareg1-1'  => 'TestFile_1.xml',
             'NP-IRD-qareg1-2'  => 'TestFile_2.xml',
             'NP-IRD-qareg1-3'  => 'TestFile_3.xml',
             'NP-IRD-qareg1-4'  => 'TestFile_4.xml',
             'NP-IRD-qareg1-5'  => 'TestFile_5.xml',
             'NP-IRD-qareg1-6'  => 'TestFile_6.xml',
             'NP-IRD-qareg1-7'  => 'TestFile_7.xml',
             'NP-IRD-qareg1-8'  => 'TestFile_8.xml',
             'NP-IRD-qareg1-9'  => 'TestFile_9.xml',
             'NP-IRD-qareg1-10' => 'TestFile_10.xml',
             'NP-IRD-qareg1-11' => 'TestFile_11.xml',
             'NP-IRD-qareg1-12' => 'TestFile_12.xml',
             'NP-IRD-qareg1-13' => 'TestFile_13.xml',
             'NP-IRD-qareg1-14' => 'TestFile_14.xml',
             'NP-IRD-qareg1-15' => 'TestFile_15.xml',
             'NP-IRD-qareg1-16' => 'TestFile_16.xml',
             'NP-IRD-qareg1-17' => 'TestFile_17.xml',
             'NP-IRD-qareg1-18' => 'TestFile_18.xml',
             'NP-IRD-qareg1-19' => 'TestFile_19.xml',
             'NP-IRD-qareg1-20' => 'TestFile_20.xml',
             'NP-IRD-qareg1-21' => 'TestFile_21.xml',
             'NP-IRD-qareg1-22' => 'TestFile_22.xml',
             'NP-IRD-qareg1-23' => 'TestFile_23.xml',
             'NP-IRD-qareg1-24' => 'TestFile_24.xml',
             'NP-IRD-qareg1-25' => 'TestFile_25.xml',
        ];

        $individualActivityXmlLengthMap = [];
        $responses = [];

        foreach ($identifiers as $identifier) {
            $fileName = $fileNames[$identifier];
            $filePath = base_path("$this->testFilesPath/xmls/$fileName");
            $fileContent = trim(file_get_contents($filePath));

            $responses[$identifier] = $this->processFileResponse($activityWorkflowService, $fileContent, $fileName);

            $individualActivityXmlLengthMap[$identifier] = getIndividualActivityXmlLength($fileContent);
        }

        $combinedTestFile = trim(file_get_contents(base_path("$this->testFilesPath/xmls/TestFile_Combined.xml")));

        $dom = new DOMDocument();
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;

        if (!$dom->loadXml($combinedTestFile)) {
            throw new \Exception('Failed to load XML content.');
        }

        $xmlLineNumberMap = getLineNumbersOfEachActivity($dom, $identifiers, $individualActivityXmlLengthMap);

        $combinedResponse = $this->processFileResponse($activityWorkflowService, $combinedTestFile, 'TestFile_Combined.xml');

        $regroupedResponses = json_encode(regroupResponseForAllActivity(json_decode($combinedResponse, true), $identifiers, $xmlLineNumberMap));

        file_put_contents(base_path("$this->testFilesPath/responses/TestFile_Combined.json"), $regroupedResponses);
        dd($xmlLineNumberMap);
    }

    private function processFileResponse(ActivityWorkflowService $activityWorkflowService, $fileContent, $fileName)
    {
        $response = '';

        try {
            $response = $activityWorkflowService->getResponse($fileContent);
            $jsonFileName = str_replace('.xml', '.json', $fileName);
            file_put_contents(base_path("$this->testFilesPath/responses/$jsonFileName"), $response);
        } catch (\Exception $ex) {
            if ($ex->getCode() === 422) {
                $response = $ex->getResponse()->getBody()->getContents();
                $jsonFileName = str_replace('.xml', '.json', $fileName);
                file_put_contents(base_path("$this->testFilesPath/responses/$jsonFileName"), $response);
            }
        }

        return $response;
    }
//    /**
//     * A basic feature test example.
//     *
//     * @return void
//     */
//    public function test_xml_import_works()
//    {
//
//        $role = Role::factory()->create();
//
//        /** @var SabreXmlService $sabreXmlService */
//        $sabreXmlService  = app(SabreXmlService::class);
//
//        /** @var XmlProcessor $xmlProcessor */
//        $xmlProcessor     = app()->make(XmlProcessor::class);
//
//        /**@var ActivityWorkflowService $activityWorkflowService*/
//        $activityWorkflowService = app()->make(ActivityWorkflowService::class);
//
//
//        $organization     = Organization::factory()->has(User::factory(['role_id' => $role->id]))->create();
//        $user             = $organization->getAdminUser() ;
//        $orgRef           = $organization->identifier;
//        $dbIatiIdentifiers = [];
//
//
//        $testFileOne = file_get_contents(base_path("$this->testFilesPath/TestFile_One.xml"));
//        $xmlData  =  $sabreXmlService->parse($testFileOne);
//        $xmlProcessor->process($xmlData, $user->id, $organization->id, $orgRef, $dbIatiIdentifiers, $organization->reporting_org);
//
//        dd(Activity::all());
    ////        /**@var ActivityWorkflowService $activityWorkflowService*/
    ////        $activityWorkflowService = app()->make(ActivityWorkflowService::class);
    ////        $testFileOne = file_get_contents(base_path("$this->testFilesPath/TestFile_One.xml"));
    ////        $testFileTwo = file_get_contents(base_path("$this->testFilesPath/TestFile_Two.xml"));
    ////
    ////        $responses = [
    ////            'test_file_one' => json_decode($activityWorkflowService->getResponse($testFileOne)),
    ////            'test_file_two' => json_decode($activityWorkflowService->getResponse($testFileTwo))
    ////        ];
    ////
    ////
    ////        dd($responses);
//    }
}
