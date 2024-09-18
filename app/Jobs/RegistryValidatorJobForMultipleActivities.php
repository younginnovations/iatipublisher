<?php

namespace App\Jobs;

use App\Constants\Enums;
use App\Exceptions\MaxMergeSizeExceededException;
use App\IATI\Elements\Xml\XmlGenerator;
use App\IATI\Repositories\Activity\ValidationStatusRepository;
use App\IATI\Services\ApiLog\ApiLogService;
use App\IATI\Services\Validator\ActivityValidatorResponseService;
use App\IATI\Services\Workflow\ActivityWorkflowService;
use App\IATI\Traits\IatiValidatorResponseTrait;
use DOMDocument;
use Exception;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use JsonException;

class RegistryValidatorJobForMultipleActivities implements ShouldQueue
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
     *
     * @return void
     *
     * @throws Exception
     * @throws GuzzleException
     */
    public function handle(ActivityWorkflowService $activityWorkflowService): void
    {
        $activityPublished = $this->organization->activityPublished;
        $uniqueIdentifiers = $this->activities->pluck('iati_identifier.iati_identifier_text', 'id')->toArray();
        $sizeInMB = $activityPublished->filesize;
        $tmpSize = 0;

        try {
            if ($sizeInMB > Enums::MAX_MERGE_SIZE) {
                throw new MaxMergeSizeExceededException();
            }

            $xmlData = $this->generateValidatableFileForActivities($this->activities, $this->organization, $this->settings);

            $tmpSize = $sizeInMB + calculateStringSizeInMb($xmlData);

            if ($tmpSize > Enums::MAX_MERGE_SIZE) {
                throw new MaxMergeSizeExceededException();
            }

            /** @var $validationStatusRepository ValidationStatusRepository */
            $validationStatusRepository = app()->make(ValidationStatusRepository::class);

            foreach ($this->activities as $activity) {
                $validationStatusRepository->storeValidationStatus((int) $activity->id, (int) $this->user->id);
            }

            $response = $activityWorkflowService->validateMultipleActivities($xmlData);
            $groupedResponse = $this->regroupResponseForAllActivity(json_decode($response, true), $uniqueIdentifiers, $this->xmlLineNumberDetails);
            $sizeInMB = $tmpSize;

            $this->storeValidation($groupedResponse, $sizeInMB);
        } catch (BadResponseException $ex) {
            if ($ex->getCode() === 422) {
                $response = $ex->getResponse()->getBody()->getContents();
                $groupedResponse = $this->regroupResponseForAllActivity(json_decode($response, true), $uniqueIdentifiers, $this->xmlLineNumberDetails);

                $this->storeValidation($groupedResponse, $sizeInMB + $tmpSize);
            }
        } catch (BindingResolutionException | JsonException $e) {
            logger($e);
        } catch (MaxMergeSizeExceededException $e) {
            // TODO: Refactor this
            $activityIds = $this->activities->pluck('id')->toArray();
            DB::table('validation_status')
                ->whereIn('activity_id', $activityIds)
                ->update(['status' => 'max_merge_size_exception']);
        }
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
        $xmlGeneratorService = app()->make(XmlGenerator::class);
        $dom = new DOMDocument();
        $iatiActivities = $dom->appendChild($dom->createElement('iati-activities'));

        $iatiActivities->setAttribute('version', '2.03');
        $iatiActivities->setAttribute('generated-datetime', gmdate('c'));

        foreach ($activities as $activity) {
            $addDom = new DOMDocument();
            $iatiIdentifier = Arr::get($activity, 'iati_identifier.iati_identifier_text');
            $fileContent = $xmlGeneratorService->getXml($activity, $activity->transactions ?? [], $activity->results ?? [], $settings, $organization)->saveXML();
            $fileContent = trim($fileContent);

            $identifiers[] = $iatiIdentifier;
            $individualActivityXmlLengthMap[$iatiIdentifier] = $this->getIndividualActivityXmlLength($fileContent);

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

    private function getIndividualActivityXmlLength(string $fileContent): int
    {
        return substr_count($fileContent, PHP_EOL) + 1 - 3;
    }
}
