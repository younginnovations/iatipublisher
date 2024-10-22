<?php

namespace App\Console\Commands;

use App\IATI\Elements\Xml\XmlGenerator;
use App\IATI\Models\Activity\Activity;
use App\IATI\Services\Workflow\ActivityWorkflowService;
use Exception;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Promise\Utils;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;

class BruhThis extends Command
{
    private string $testFilesPath = 'tests/Unit/TestFiles/BulkPublishTestFiles';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:Bruh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $activities = Activity::whereBetween('id', [1099, 1123])->get();
        $xmlGenerator = app(XmlGenerator::class);
        $activityWorkflowService = app(ActivityWorkflowService::class);
        $organization = Arr::first($activities)->organization;
        $settings = $organization->settings;
        $promises = [];

        foreach ($activities as $activity) {
            $activityId = $activity->id;
            $transactions = $activity->transactions ?? [];
            $results = $activity->results ?? [];
            $xmlDom = $xmlGenerator->getXml($activity, $transactions, $results, $settings, $organization);
            $promises[$activityId] = $this->createValidateXmlPromise($activityWorkflowService, $xmlDom->saveXML());
        }

        $parallelResponses = Utils::settle($promises)->wait();
        dd($parallelResponses);
    }

    private function createValidateXmlPromise(ActivityWorkflowService $activityWorkflowService, string $xmlData): PromiseInterface
    {
    }

    /**
     * Creates a promise for processing an XML file asynchronously.
     */
    private function createPromise(ActivityWorkflowService $activityWorkflowService, $fileContent)
    {
        return $this->processFileResponseAsync($activityWorkflowService, $fileContent);
    }

    /**
     * Process the file response.
     */
    private function processFileResponse(ActivityWorkflowService $activityWorkflowService, $fileContent, $fileName)
    {
        $response = '';

        try {
            $response = $activityWorkflowService->getResponse($fileContent);
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

    private function processFileResponseAsync(ActivityWorkflowService $activityWorkflowService, $fileContent): PromiseInterface
    {
        return $activityWorkflowService->getResponseAsync($fileContent)
            ->then(
                function ($response) use ($fileName) {
                    $jsonFileName = str_replace('.xml', '.json', $fileName);
                    file_put_contents(base_path("$this->testFilesPath/responses/$jsonFileName"), $response);

                    return $response;
                },
                function (Exception $ex) use ($fileName) {
                    $response = '';
                    if ($ex->getCode() === 422) {
                        $response = $ex->getResponse()->getBody()->getContents();
                        $jsonFileName = str_replace('.xml', '.json', $fileName);
                        file_put_contents(base_path("$this->testFilesPath/responses/$jsonFileName"), $response);
                    }

                    return $response;
                }
            );
    }
}
