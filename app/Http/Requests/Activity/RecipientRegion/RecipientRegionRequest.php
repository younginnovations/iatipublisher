<?php

declare(strict_types=1);

namespace App\Http\Requests\Activity\RecipientRegion;

use App\Http\Requests\Activity\ActivityBaseRequest;
use App\IATI\Services\Activity\RecipientCountryService;
use Illuminate\Support\Arr;

/**
 * Class RecipientRegionRequest.
 */
class RecipientRegionRequest extends ActivityBaseRequest
{
    /**
     * @var RecipientCountryService
     */
    protected $recipientCountryService;

    public function __construct(RecipientCountryService $recipientCountryService)
    {
        parent::__construct();
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
     * Returns rules for related activity.
     * @param array $formFields
     * @return array
     */
    protected function getRulesForRecipientRegion(array $formFields): array
    {
        $activityId = (int) $this->segment(2);
        $recipientCountry = $this->recipientCountryService->getRecipientCountryData($activityId);
        $rules = [];

        foreach ($formFields as $recipientRegionIndex => $recipientRegion) {
            $recipientRegionForm = 'recipient_region.' . $recipientRegionIndex;

            if (Arr::get($recipientRegion, 'region_vocabulary', 1) == 1) {
                $rules[$recipientRegionForm . '.region_code'] = 'required';
            } elseif (Arr::get($recipientRegion, 'region_vocabulary', 1) == 2) {
                $rules[$recipientRegionForm . '.custom_code'] = 'required';
            } elseif (Arr::get($recipientRegion, 'region_vocabulary', 1) == 99) {
                $rules[$recipientRegionForm . '.region_code_input'] = 'required';
            }

            $rules[$recipientRegionForm . '.vocabulary_uri'] = 'nullable|url';
            $rules[$recipientRegionForm . '.percentage'] = 'nullable|numeric|max:100';

            if (count($formFields) > 1 || $recipientCountry != null) {
                $rules[$recipientRegionForm . '.percentage'] = 'required|numeric|max:100';
            }

            $rules = array_merge(
                $rules,
                $this->getRulesForNarrative($recipientRegion['narrative'], $recipientRegionForm)
            );
        }
        $totalPercentage = $this->getPercentageRules($this->get('recipient_region'));

        $indexes = [];
        $fields = [];
        $overallPercentage = [];

        foreach ($totalPercentage as $index => $value) {
            if (is_numeric($index) && $value != 100) {
                $overallPercentage[] = $value;
                $indexes[] = $index;
            }
        }

        foreach ($totalPercentage as $i => $percentage) {
            if (array_sum($overallPercentage) > 100) {
                foreach ($indexes as $index) {
                    if ($index == $percentage) {
                        $fields[] = $i;
                    }
                }
            }
        }

        foreach ($fields as $field) {
            $rules[$field] = 'required|sum|numeric|max:100';
        }

        return $rules;
    }

    /**
     * Returns messages for related activity validations.
     * @param array $formFields
     * @return array
     */
    protected function getMessagesForRecipientRegion(array $formFields): array
    {
        $messages = [];

        foreach ($formFields as $recipientRegionIndex => $recipientRegion) {
            $recipientRegionForm = 'recipient_region.' . $recipientRegionIndex;
            $messages[$recipientRegionForm . '.region_code.required'] = 'The @cde field is required.';
            $messages[$recipientRegionForm . '.custom_code.required'] = 'The @cde field is required.';
            $messages[$recipientRegionForm . '.region_code_input.required'] = 'The @cde field is required.';
            $messages[$recipientRegionForm . '.percentage.numeric'] = 'The @percentage field must be a number.';
            $messages[$recipientRegionForm . '.percentage.max'] = 'The @percentage cannot be greater than 100.';
            $messages[$recipientRegionForm . '.percentage.required'] = 'The @percentage field is required.';
            $messages = array_merge(
                $messages,
                $this->getMessagesForNarrative(
                    $recipientRegion['narrative'],
                    $recipientRegionForm
                )
            );
            $messages[$recipientRegionForm . '.percentage.sum'] = 'The sum of @percentage within @vocabulary cannot be greater than 100.';
        }

        return $messages;
    }

    /**
     * generate rules for percentage.
     * @param $regions
     * @return array
     */
    protected function getPercentageRules($regions): array
    {
        $array = [];
        $totalPercentage = 0;
        $regionVocabs = [];

        if (count($regions) > 1) {
            foreach ($regions as $regionIndex => $region) {
                $regionVocabs[$region['region_vocabulary']] = 0;
            }

            foreach ($regions as $regionIndex => $region) {
                $regionVocabs[$region['region_vocabulary']] += Arr::get($region, 'percentage', 0);
                $regionForm = sprintf('recipient_region.%s', $regionIndex);
                $percentage = $region['percentage'];
                $recipient_region = $region['region_vocabulary'];

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
                if ($regionVocabs[$region['region_vocabulary']] > 100) {
                    return $array;
                }
            }
        }

        return [];
    }
}
