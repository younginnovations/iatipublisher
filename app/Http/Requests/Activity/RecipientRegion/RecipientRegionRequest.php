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

    /**
     * RecipientRegionRequest Constructor.
     *
     * @param RecipientCountryService $recipientCountryService
     */
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
     *
     * @param array $formFields
     *
     * @return array
     */
    protected function getRulesForRecipientRegion(array $formFields): array
    {
        $rules = [];

        foreach ($formFields as $recipientRegionIndex => $recipientRegion) {
            $recipientRegionForm = 'recipient_region.' . $recipientRegionIndex;
            $rules[$recipientRegionForm . '.vocabulary_uri'] = 'nullable|url';
            $rules[$recipientRegionForm . '.percentage'] = 'nullable|numeric|max:100|digits_between:0,3';

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
            $messages[$recipientRegionForm . '.percentage.max'] = 'The @percentage cannot be greater than 100.';
            $messages[$recipientRegionForm . '.percentage.digits_between'] = 'The @percentage cannot be greater than 3 digits.';

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
                $regionVocabs[$regionVocab] += Arr::get($region, 'percentage', 0);
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
