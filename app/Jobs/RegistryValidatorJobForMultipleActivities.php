<?php

namespace App\Jobs;

use App\IATI\Elements\Xml\XmlGenerator;
use App\IATI\Repositories\Activity\ValidationStatusRepository;
use App\IATI\Services\ApiLog\ApiLogService;
use App\IATI\Services\Validator\ActivityValidatorResponseService;
use App\IATI\Services\Workflow\ActivityWorkflowService;
use App\IATI\Traits\IatiValidatorResponseTrait;
use DOMDocument;
use Exception;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Promise\Utils;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use JsonException;

class RegistryValidatorJobForMultipleActivities
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, IatiValidatorResponseTrait;

    public array $xmlLineNumberDetails;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public $user, public $activities, public $organization, public $settings)
    {
    }

    /**
     * Execute the job.
     *
     * @param ActivityWorkflowService $activityWorkflowService
     * @param XmlGenerator $xmlGenerator
     *
     * @return void
     *
     * @throws JsonException
     */
    public function handle(ActivityWorkflowService $activityWorkflowService, XmlGenerator $xmlGenerator): void
    {
        $organization = Arr::first($this->activities)->organization;
        $settings = $organization->settings;
        $promises = [];

        foreach ($this->activities as $activity) {
            $activityId = $activity->id;
            $transactions = $activity->transactions ?? [];
            $results = $activity->results ?? [];
            $xmlDom = $xmlGenerator->getXml($activity, $transactions, $results, $settings, $organization);
            $promises[$activityId] = $this->createValidateXmlPromise($activityWorkflowService, $xmlDom->saveXML());
        }

        $parallelResponses = Utils::settle($promises)->wait();
        dd($parallelResponses);
    }

    /**
     * Stores Validation after response.
     *
     * @param $groupedResponse
     * @param $sizeInMB
     *
     * @return void
     *
     * @throws BindingResolutionException
     * @throws JsonException
     */
    public function storeValidation($groupedResponse, $sizeInMB): void
    {
        $apiLogService = app()->make(ApiLogService::class);
        $validatorService = app()->make(ActivityValidatorResponseService::class);
        $validationStatusRepository = app()->make(ValidationStatusRepository::class);

        foreach ($this->activities as $key => $activity) {
            $identifier = Arr::get($activity, 'iati_identifier.iati_identifier_text');
            $response = json_encode($groupedResponse[$identifier]);
            $response = $this->addElementOnIatiValidatorResponse($response, $activity);

            $apiLogService->store(generateApiInfo('POST', env('IATI_VALIDATOR_ENDPOINT'), ['form_params' => json_encode($activity)], json_encode($response)));

            $recordResponse = [
                'activity_id' => $activity->id,
                'title'       => Arr::get($activity->title, '0.narrative', 'Not Available') ?: 'Not Available',
                'response'    => $response,
            ];

            if ($validatorService->updateOrCreateResponse($activity->id, $response)) {
                $validationStatusRepository->updateValidationStatus((int) $activity->id, (int) $this->user->id, status: 'completed', response: $recordResponse);
            }
        }

        $organisation = $activity->organization;
        $activityPublished = $organisation->activityPublished;
        $activityPublished->filesize = $sizeInMB;
        $activityPublished->save();
    }

    /**
     * Clears up the failed validation.
     *
     * @return void
     *
     * @throws BindingResolutionException
     */
    public function failed(): void
    {
        $validationStatusRepository = app()->make(ValidationStatusRepository::class);

        foreach ($this->activities as $activity) {
            $validationStatusRepository->updateValidationStatus((int) $activity->id, (int) $this->user->id, status: 'failed');
        }
    }

    private function generateValidatableFileForActivities($activities, $organization, $settings): bool|string
    {
        $identifiers = [];
        $individualActivityXmlLengthMap = [];

        /** @var XmlGenerator $xmlGeneratorService */
        $dom = new DOMDocument();
        $iatiActivities = $dom->appendChild($dom->createElement('iati-activities'));

        $iatiActivities->setAttribute('version', '2.03');
        $iatiActivities->setAttribute('generated-datetime', gmdate('c'));

        foreach ($activities as $activity) {
            $addDom = new DOMDocument();
            $iatiIdentifier = Arr::get($activity, 'iati_identifier.iati_identifier_text');
            $fileContent = $xmlGeneratorService->getXml($activity, $activity->transactions ?? [], $activity->results ?? [], $settings, $organization)->saveXML();
            $fileContent = trim($fileContent);
            $xmlGeneratorService = app()->make(XmlGenerator::class);

            $identifiers[] = $iatiIdentifier;
            $individualActivityXmlLengthMap[$iatiIdentifier] = getIndividualActivityXmlLength($fileContent);

            awsUploadFile("xmlValidation/$activity->org_id/activity_$activity->id.xml", $fileContent);

            $addDom->loadXML($fileContent);

            if ($addDom->documentElement) {
                foreach ($addDom->documentElement->childNodes as $node) {
                    $dom->documentElement->appendChild($dom->importNode($node, true));
                }
            }
        }

        $this->xmlLineNumberDetails = getLineNumbersOfEachActivity($dom, $identifiers, $individualActivityXmlLengthMap);

        return $dom->saveXML();
    }

    public function regroupResponseForAllActivity(array $response, array $uniqueIdentifiers, array $xmlLineNumberMap): array
    {
        $groupedResponses = [];

        foreach ($uniqueIdentifiers as $identifier) {
            $clonedResponse = $response;
            $clonedResponse['errors'] = filterErrorsByIdentifier($response['errors'], $identifier);
            $clonedResponse['summary'] = ['critical' => 0, 'error' => 0, 'warning' => 0, 'advisory' => 0];

            foreach ($clonedResponse['errors'] as $error) {
                $severity = Arr::get($error, 'severity');
                $clonedResponse['summary'][$severity]++;
            }

            $clonedResponse = flattenArrayWithKeys($clonedResponse);
            $arrayOfErrorLineNumbersInValue = getItemsWhereKeyContains($clonedResponse, 'line');
            $arrayOfErrorLineNumbersInTextMessage = getItemsWhereKeyContains($clonedResponse, '.text');

            [$mappedLineNumbersInValue, $mappedLineNumbersInTextMessage] = mapErrorLinesToChildren($xmlLineNumberMap[$identifier], $arrayOfErrorLineNumbersInValue, $arrayOfErrorLineNumbersInTextMessage);

            foreach ($arrayOfErrorLineNumbersInValue as $key => $value) {
                $clonedResponse[$key] = $mappedLineNumbersInValue[$key];
            }

            foreach ($arrayOfErrorLineNumbersInTextMessage as $key => $value) {
                $clonedResponse[$key] = $mappedLineNumbersInTextMessage[$key];
            }

            $clonedResponse = convertDotKeysToNestedArray($clonedResponse);

            $groupedResponses[$identifier] = $clonedResponse;
        }

        return $groupedResponses;
    }

    private function createValidateXmlPromise(ActivityWorkflowService $activityWorkflowService, string $xmlData): PromiseInterface
    {
        return $activityWorkflowService->getResponseAsync($xmlData)
            ->then(
                function ($response) {
                    return $response;
                },
                function (Exception $ex) {
                    $response = '';

                    if ($ex->getCode() === 422) {
                        $response = $ex->getResponse()->getBody()->getContents();
                    }

                    return $response;
                }
            );
    }
}
