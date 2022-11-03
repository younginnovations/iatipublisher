<?php

declare(strict_types=1);

namespace App\Http\Requests\Activity\RecipientRegion;

use App\Http\Requests\Activity\ActivityBaseRequest;
use App\IATI\Services\Activity\ActivityService;
use App\IATI\Services\Activity\IndicatorService;
use App\IATI\Services\Activity\RecipientCountryService;
use App\IATI\Services\Activity\ResultService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

/**
 * Class RecipientRegionRequest.
 */
class RecipientRegionRequest extends ActivityBaseRequest
{
    /**
     * @var RecipientCountryService
     */
    protected RecipientCountryService $recipientCountryService;

    /**
     * RecipientRegionRequest Constructor.
     *
     * @param IndicatorService        $indicatorService
     * @param ResultService           $resultService
     * @param ActivityService         $activityService
     * @param RecipientCountryService $recipientCountryService
     */
    public function __construct(IndicatorService $indicatorService, ResultService $resultService, ActivityService $activityService, RecipientCountryService $recipientCountryService)
    {
        parent::__construct($indicatorService, $resultService, $activityService);

        $this->recipientCountryService = $recipientCountryService;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return $this->getRulesForRecipientRegion($this->get('recipient_region'));
    }

    /**
     * Get the error message as required.
     *
     * @return array
     */
    public function messages(): array
    {
        return $this->getMessagesForRecipientRegion($this->get('recipient_region'));
    }

    /**
     * @param $formFields
     *
     * @return array
     */
    public function groupRegion($formFields): array
    {
        $groupedRegion = [];

        foreach ($formFields as $formField) {
            if (array_key_exists($formField['region_vocabulary'], $groupedRegion)) {
                $groupedRegion[$formField['region_vocabulary']]['count'] += 1;
                $groupedRegion[$formField['region_vocabulary']]['total'] += $formField['percentage'];
            } else {
                $groupedRegion[$formField['region_vocabulary']] = ['count' => 1, 'total' => $formField['percentage']];
            }
        }

        return $groupedRegion;
    }

    /**
     * Returns rules for related activity.
     *
     * @param array $formFields
     *
     * @return array
     */
    protected function getRulesForRecipientRegion(array $formFields): array
    {
        Validator::extend('allocated_region_total_mismatch', function () {
            return false;
        });
        $rules = [];
        $groupedPercentRegion = $this->groupRegion($formFields);
        $params = $this->route()->parameters();
        $allottedRegionPercent = $this->activityService->getAllottedRecipientRegionPercent($params['id']);

        foreach ($formFields as $recipientRegionIndex => $recipientRegion) {
            $recipientRegionForm = 'recipient_region.' . $recipientRegionIndex;
            $rules[$recipientRegionForm . '.vocabulary_uri'] = 'nullable|url';
            $rules[$recipientRegionForm . '.percentage'] = 'nullable|numeric';

            $narrativeRules = $this->getRulesForNarrative($recipientRegion['narrative'], $recipientRegionForm);

            foreach ($narrativeRules as $key => $item) {
                $rules[$key] = $item;
            }

            if ($groupedPercentRegion[$recipientRegion['region_vocabulary']]['count'] > 1) {
                if ($groupedPercentRegion[$recipientRegion['region_vocabulary']]['total'] !== $allottedRegionPercent) {
                    $rules[$recipientRegionForm . '.percentage'] .= '|allocated_region_total_mismatch:';
                }
            } else {
                $rules[$recipientRegionForm . '.percentage'] .= '|in:' . $allottedRegionPercent;
            }
        }

        return $rules;
    }

    /**
     * Returns messages for related activity validations.
     *
     * @param array $formFields
     *
     * @return array
     */
    protected function getMessagesForRecipientRegion(array $formFields): array
    {
        $messages = [];

        foreach ($formFields as $recipientRegionIndex => $recipientRegion) {
            $recipientRegionForm = 'recipient_region.' . $recipientRegionIndex;
            $messages[$recipientRegionForm . '.percentage.numeric'] = 'The @percentage field must be a number.';

            $narrativeMessages = $this->getMessagesForNarrative($recipientRegion['narrative'], $recipientRegionForm);

            foreach ($narrativeMessages as $key => $item) {
                $messages[$key] = $item;
            }

            $messages[$recipientRegionForm . '.percentage.in'] = 'Region percent must be equal to allocated percent';
            $messages[$recipientRegionForm . '.percentage.allocated_region_total_mismatch'] = 'Region percent must match with allocated percent';
        }

        return $messages;
    }

    /**
     * generate rules for percentage.
     *
     * @param $regions
     *
     * @return array
     */
    protected function getPercentageRules($regions): array
    {
        $array = [];
        $totalPercentage = 0;
        $regionVocabs = [];

        if (count($regions) > 1) {
            foreach ($regions as $regionIndex => $region) {
                $regionVocab = $region['region_vocabulary'] ?: 'Not Specified';
                $regionVocabs[$regionVocab] = 0;
            }

            foreach ($regions as $regionIndex => $region) {
                $regionVocab = $region['region_vocabulary'] ?: 'Not Specified';
                $regionVocabs[$regionVocab] += (float) Arr::get($region, 'percentage', 0);
                $regionForm = sprintf('recipient_region.%s', $regionIndex);
                $percentage = $region['percentage'] ?: 0;
                $recipient_region = $regionVocab;

                if (array_key_exists($recipient_region, $array)) {
                    $totalPercentage = (int) $array[$recipient_region] + (float) $percentage;
                    $array[$recipient_region] = $totalPercentage;
                    $array[sprintf('%s.percentage', $regionForm)] = $recipient_region;
                } else {
                    $array[$recipient_region] = $percentage;
                    $array[sprintf('%s.percentage', $regionForm)] = $recipient_region;
                }
            }

            foreach ($regions as $regionIndex => $region) {
                $regionVocab = $region['region_vocabulary'] ?: 'Not Specified';

                if ($regionVocabs[$regionVocab] > 100) {
                    return $array;
                }
            }
        }

        return [];
    }
}
