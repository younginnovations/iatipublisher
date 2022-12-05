<?php

declare(strict_types=1);

namespace App\Http\Requests\Activity\RecipientRegion;

use App\Http\Requests\Activity\ActivityBaseRequest;
use App\IATI\Services\Activity\ActivityService;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Validator;

/**
 * Class RecipientRegionRequest.
 */
class RecipientRegionRequest extends ActivityBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * @throws BindingResolutionException
     */
    public function rules($recipient_region = []): array
    {
        return $this->getRulesForRecipientRegion($this->get('recipient_region') ?? $recipient_region);
    }

    /**
     * Get the error message as required.
     *
     * @return array
     */
    public function messages($recipient_region = []): array
    {
        return $this->getMessagesForRecipientRegion($this->get('recipient_region') ?? $recipient_region);
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
                $groupedRegion[$formField['region_vocabulary']]['total'] += (float) $formField['percentage'];
            } else {
                $groupedRegion[$formField['region_vocabulary']] = ['count' => 1, 'total' => (float) $formField['percentage']];
            }
        }

        return $groupedRegion;
    }

    /**
     * Returns rules for related activity.
     *
     * @param array $formFields
     * @param bool $fileUpload
     * @param array $recipientCountries
     *
     * @return array
     * @throws BindingResolutionException
     */
    public function getRulesForRecipientRegion(array $formFields, bool $fileUpload = false, array $recipientCountries = []): array
    {
        if (empty($formFields)) {
            return [];
        }

        $rules = [];
        $activityService = app()->make(ActivityService::class);

        if (!$fileUpload) {
            $params = $this->route()->parameters();

            if ($activityService->hasRecipientRegionDefinedInTransactions($params['id'])) {
                Validator::extend('already_in_transactions', function () {
                    return false;
                });

                return ['recipient_region' => 'already_in_transactions'];
            }

            $allottedRegionPercent = $activityService->getAllottedRecipientRegionPercent($params['id']);
        } else {
            $allottedRegionPercent = $activityService->getAllottedRecipientRegionPercentFileUpload($recipientCountries);
        }

        Validator::extend('allocated_region_total_mismatch', function () {
            return false;
        });

        Validator::extend('sum_greater_than', function () {
            return false;
        });

        Validator::extend('percentage_within_vocabulary', function () {
            return false;
        });

        $groupedPercentRegion = $this->groupRegion($formFields);

        foreach ($formFields as $recipientRegionIndex => $recipientRegion) {
            $recipientRegionForm = 'recipient_region.' . $recipientRegionIndex;
            $rules[sprintf('%s.region_vocabulary', $recipientRegionForm)] = 'nullable|in:' . implode(',', array_keys(getCodeList('RegionVocabulary', 'Activity', false)));
            $rules[sprintf('%s.region_code', $recipientRegionForm)] = 'nullable|in:' . implode(',', array_keys(getCodeList('Region', 'Activity', false)));
            $rules[$recipientRegionForm . '.vocabulary_uri'] = 'nullable|url';
            $rules[$recipientRegionForm . '.percentage'] = 'nullable|numeric|min:0';

            $narrativeRules = $this->getRulesForNarrative($recipientRegion['narrative'], $recipientRegionForm);

            foreach ($narrativeRules as $key => $item) {
                $rules[$key] = $item;
            }

            if ($allottedRegionPercent !== 100.0) {
                if ($groupedPercentRegion[$recipientRegion['region_vocabulary']]['count'] > 1) {
                    if ($groupedPercentRegion[$recipientRegion['region_vocabulary']]['total'] !== $allottedRegionPercent) {
                        $rules[$recipientRegionForm . '.percentage'] .= '|allocated_region_total_mismatch:';
                    }
                } else {
                    $rules[$recipientRegionForm . '.percentage'] .= '|in:' . $allottedRegionPercent;
                }
            } elseif ($groupedPercentRegion[$recipientRegion['region_vocabulary']]['total'] > 100.0) {
                $rules[$recipientRegionForm . '.percentage'] .= '|sum_greater_than';
            } elseif ($groupedPercentRegion[$recipientRegion['region_vocabulary']]['total'] !== $groupedPercentRegion[array_key_first($groupedPercentRegion)]['total']) {
                $rules[$recipientRegionForm . '.percentage'] .= '|percentage_within_vocabulary';
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
    public function getMessagesForRecipientRegion(array $formFields): array
    {
        $messages = ['recipient_region.already_in_transactions' => 'Recipient Region already defined in Transactions'];

        foreach ($formFields as $recipientRegionIndex => $recipientRegion) {
            $recipientRegionForm = 'recipient_region.' . $recipientRegionIndex;
            $messages[sprintf('%s.region_vocabulary.in', $recipientRegionForm)] = 'The recipient region vocabulary is invalid.';
            $messages[sprintf('%s.region_code.in', $recipientRegionForm)] = 'The recipient region code is invalid.';
            $messages[$recipientRegionForm . '.percentage.numeric'] = 'The recipient region percentage field must be a number.';
            $messages[sprintf('%s.vocabulary_uri.url', $recipientRegionForm)] = 'The recipient region vocabulary uri must be a valid url.';

            $narrativeMessages = $this->getMessagesForNarrative($recipientRegion['narrative'], $recipientRegionForm);

            foreach ($narrativeMessages as $key => $item) {
                $messages[$key] = $item;
            }

            $messages[$recipientRegionForm . '.percentage.in'] = 'Region percent must be equal to allocated percent';
            $messages[$recipientRegionForm . '.percentage.allocated_region_total_mismatch'] = 'Region percent must match with allocated percent';
            $messages[$recipientRegionForm . '.percentage.sum_greater_than'] = 'Sum of percentage within vocabulary cannot be greater than 100';
            $messages[$recipientRegionForm . '.percentage.percentage_within_vocabulary'] = 'The total percentage within different vocabulary must be equal.';
        }

        return $messages;
    }
}
