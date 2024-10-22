<?php

declare(strict_types=1);

namespace Tests\Unit\BulkPublishTest;

use App\IATI\Elements\Xml\XmlGenerator;
use App\IATI\Models\Organization\Organization;
use App\IATI\Models\Setting\Setting;
use App\IATI\Models\User\Role;
use App\IATI\Models\User\User;
use App\IATI\Services\Workflow\ActivityWorkflowService;
use App\IATI\Services\Xml\XmlGeneratorService;
use DOMDocument;
use Exception;
use Generator;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
        dump('1');
        /** @var ActivityWorkflowService $activityWorkflowService */
        /** @var XmlGeneratorService $xmlGeneratorService */
        /** @var XmlGenerator $xmlGenerator */
        $activityWorkflowService = app()->make(ActivityWorkflowService::class);
        $xmlGeneratorService = app()->make(XmlGeneratorService::class);
        $xmlGenerator = app()->make(XmlGenerator::class);

        $role = Role::factory()->create();
        $org = Organization::factory()->has(User::factory(['role_id' => $role->id]))->create();
        Setting::factory()->create(['organization_id' => $org->id]);
        dump('2');
//        $this->actingAs($org->user)->post('setting/store/default', ['default_currency' => 'BND', 'default_language' => 'ab', 'hierarchy' => '2', 'budget_not_provided' => '1', 'humanitarian' => '0',]);

        dump('started');
//        $systemDataFilePath = 'tests/Unit/TestFiles/Xls/SystemData/activity.json';
//        $actualData = json_decode(file_get_contents($systemDataFilePath), true, 512, 0);
//
//        $activity2 = Activity::factory()->has(Transaction::factory()->count(3))->has(Result::factory(2))->create(
//            [...$actualData,
//                'org_id' => $org->id,
//                'iati_identifier' => [
//                    'activity_identifier' => 'SYRZ000043',
//                    'iati_identifier_text' => 'CZ-ICO-25755277-SYRZ000043',
//                    'present_organization_identifier' => 'CZ-ICO-25755277',
//                ]
//            ]);
//        $activity1 = Activity::factory()->has(Transaction::factory()->count(2))->has(Result::factory(3))->create(
//            [
//                ...$actualData,
//                'org_id' => $org->id,
//                'iati_identifier' => [
//                    'activity_identifier' => 'SYRZ000044',
//                    'iati_identifier_text' => 'CZ-ICO-25755277-SYRZ000044',
//                    'present_organization_identifier' => 'CZ-ICO-25755277',
//                ]
//            ]);

        $settings = $org->settings;

//        $xml1 = $xmlGeneratorService->generateActivityXml($activity1, $activity1->transactions ?? [], $activity1->results ?? [], $settings, $org);
//        $xml2 = $xmlGeneratorService->generateActivityXml($activity2, $activity2->transactions ?? [], $activity2->results ?? [], $settings, $org);
//        $xml1 = $xml1->saveXML();
//        $xml2 = $xml2->saveXML();
//
//        file_put_contents('activity_3.xml', $xml1);
//        file_put_contents('activity_4.xml', $xml2);

//        $xml1 = file_get_contents("$this->testFilesPath/xmls/activity_1.xml");
//        $xml2 = file_get_contents("$this->testFilesPath/xmls/activity_2.xml");
//        $xml3 = file_get_contents("$this->testFilesPath/xmls/activity_3.xml");
//        $xml4 = file_get_contents("$this->testFilesPath/xmls/activity_4.xml");

        $promises = [
            'response1' => function () use ($activityWorkflowService, $xml1) {
                return $this->processFileResponse($activityWorkflowService, $xml1, 'activity_1.xml');
            },
            'response2' => function () use ($activityWorkflowService, $xml2) {
                return $this->processFileResponse($activityWorkflowService, $xml2, 'activity_2.xml');
            },
            'response3' => function () use ($activityWorkflowService, $xml3) {
                return $this->processFileResponse($activityWorkflowService, $xml3, 'activity_3.xml');
            },
            'response4' => function () use ($activityWorkflowService, $xml4) {
                return $this->processFileResponse($activityWorkflowService, $xml4, 'activity_4.xml');
            },
        ];

        $xmlMerged = file_get_contents("$this->testFilesPath/xmls/activity_merged.xml");

        $publisherId = $org->toArray()['publisher_id'];

        ///        $response1 = $this->processFileResponse($activityWorkflowService, $xml1, 'activity_1.xml');//these are all async process. can i do something like await all in laravel
        ///        $response2 = $this->processFileResponse($activityWorkflowService, $xml2, 'activity_2.xml');//these are all async process. can i do something like await all in laravel
        ///        $response3 = $this->processFileResponse($activityWorkflowService, $xml3, 'activity_3.xml');//these are all async process. can i do something like await all in laravel
        ///        $response4 = $this->processFileResponse($activityWorkflowService, $xml4, 'activity_4.xml');//these are all async process. can i do something like await all in laravel
        $combinedResponse = $this->processFileResponse($activityWorkflowService, $xmlMerged, 'activity_merged.xml');

        dump('processed combined');
        $identifiers = [
            'CZ-ICO-25755277-SYRZ000042'=>'CZ-ICO-25755277-SYRZ000042',
            'CZ-ICO-25755277-SYRZ000041'=>'CZ-ICO-25755277-SYRZ000041',
            'CZ-ICO-25755277-SYRZ000044'=>'CZ-ICO-25755277-SYRZ000044',
            'CZ-ICO-25755277-SYRZ000043'=>'CZ-ICO-25755277-SYRZ000043',
        ];

        $lineNumbers = $this->getActivityLineNumbers(base_path("$this->testFilesPath/xmls/activity_merged.xml"));
        $xmlLineNumberMap = iterator_to_array($lineNumbers);

        dump('calcd');
        $regroupedResponses = json_encode(regroupResponseForAllActivity(json_decode($combinedResponse, true), $identifiers, $xmlLineNumberMap));
        file_put_contents(base_path("$this->testFilesPath/responses/TestFile_Combined.json"), $regroupedResponses);

        dump('here');
        $regroupedResponses = json_decode($regroupedResponses, true);

        $fileIndex = 1;
        $index = 0;

        dd('fun');
        foreach ($identifiers as $identifier) {
            $individualResponse = json_decode(file_get_contents("$this->testFilesPath/responses/activity_$fileIndex.json"), true);
            $arrayOfErrorLineNumbersInValue_1 = getItemsWhereKeyContains($individualResponse, 'line');
            $arrayOfErrorLineNumbersInTextMessage_1 = getItemsWhereKeyContains($individualResponse, '.text');

            $responseFromComined = $regroupedResponses[$identifier];

            $arrayOfErrorLineNumbersInValue_2 = getItemsWhereKeyContains($responseFromComined, 'line');
            $arrayOfErrorLineNumbersInTextMessage_2 = getItemsWhereKeyContains($responseFromComined, '.text');

            assert($arrayOfErrorLineNumbersInValue_1 === $arrayOfErrorLineNumbersInValue_2, 'Error line numbers in values do not match');
            assert($arrayOfErrorLineNumbersInTextMessage_1 === $arrayOfErrorLineNumbersInTextMessage_2, 'Error text messages do not match');

//            dd($responseFromComined, $arrayOfErrorLineNumbersInTextMessage_1, $arrayOfErrorLineNumbersInTextMessage_2);

            $index++;
        }
//

//
//
//        $combinedTestFile = trim(file_get_contents(base_path("$this->testFilesPath/xmls/TestFile_Combined.xml")));
//
//        $dom = new DOMDocument();
//        $dom->preserveWhiteSpace = false;
//        $dom->formatOutput = true;
//
//        if (!$dom->loadXml($combinedTestFile)) {
//            throw new \Exception('Failed to load XML content.');
//        }
//
//
//        $lineNumbers      = $this->getActivityLineNumbers(base_path("$this->testFilesPath/xmls/TestFile_Combined.xml"));
//        $xmlLineNumberMap = iterator_to_array($lineNumbers);
//
//        $combinedResponse = $this->processFileResponse($activityWorkflowService, $combinedTestFile, 'TestFile_Combined.xml');
//        file_put_contents(base_path("$this->testFilesPath/responses/TestFile_Combined.json"), $combinedResponse);
//
//        $regroupedResponses = json_encode(regroupResponseForAllActivity(json_decode($combinedResponse, true), $identifiers, $xmlLineNumberMap));
//
//        file_put_contents(base_path("$this->testFilesPath/responses/Merged_Combined.json"), $regroupedResponses);
//        dd($xmlLineNumberMap);
    }

    private function processFileResponse(ActivityWorkflowService $activityWorkflowService, $fileContent, $fileName, $toggle = true)
    {
        $response = '';

        if ($toggle) {
            $query = ['group' => 'false', 'details' => 'true'];
        } else {
            $query = ['group' => 'activity', 'details' => 'true'];
        }
        try {
            $response = $activityWorkflowService->getResponse($fileContent, $query);
            $jsonFileName = str_replace('.xml', '.json', $fileName);
            file_put_contents(base_path("$this->testFilesPath/responses/$jsonFileName"), $response);
        } catch (Exception $ex) {
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

    public function getActivityLineNumbers($xmlFilePath): Generator
    {
        libxml_use_internal_errors(true);

        $dom = new DOMDocument();
        $dom->load($xmlFilePath);

        $activities = $dom->getElementsByTagName('iati-activity');

        foreach ($activities as $index => $activity) {
            $identifierElement = $activity->getElementsByTagName('iati-identifier')->item(0);

            $lineNo = $activity->getLineNo();

            yield $identifierElement->textContent => [
                'order' => $index,
                'offset' => $lineNo,
            ];
        }
    }
}
