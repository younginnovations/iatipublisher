<?php

declare(strict_types=1);

namespace App\Http\Requests\Activity\RecipientCountry;

use App\Http\Requests\Activity\ActivityBaseRequest;

/**
 * Class RecipientCountryRequest.
 */
class RecipientCountryRequest extends ActivityBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return $this->getRulesForRecipientCountry($this->get('recipient_country'));
    }

    /**
     * Get the error message as required.
     *
     * @return array
     */
    public function messages(): array
    {
        return $this->getMessagesForRecipientCountry($this->get('recipient_country'));
    }

    /**
     * Returns rules for related activity.
     *
     * @param array $formFields

     * @return array
     */
    protected function getRulesForRecipientCountry(array $formFields): array
    {
        $rules = [];

        foreach ($formFields as $recipientCountryIndex => $recipientCountry) {
            $recipientCountryForm = 'recipient_country.' . $recipientCountryIndex;
            $rules[$recipientCountryForm . '.percentage'] = 'nullable|numeric|max:100|not_regex:/^0{2,}/';

            $rules = array_merge(
                $rules,
                $this->getRulesForNarrative(
                    $recipientCountry['narrative'],
                    $recipientCountryForm
                )
            );
        }

        $totalPercentage = $this->getPercentageRules($this->get('recipient_country'));

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
    protected function getMessagesForRecipientCountry(array $formFields): array
    {
        $messages = [];

        foreach ($formFields as $recipientCountryIndex => $recipientCountry) {
            $recipientCountryForm = 'recipient_country.' . $recipientCountryIndex;
            $messages[$recipientCountryForm . '.percentage.numeric'] = 'The @percentage must be a number.';
            $messages[$recipientCountryForm . '.percentage.max'] = 'The @percentage cannot be greater than 100';
            $messages[$recipientCountryForm . '.percentage.not_regex'] = 'The @percentage field format is invalid.';

            $messages = array_merge(
                $messages,
                $this->getMessagesForNarrative(
                    $recipientCountry['narrative'],
                    $recipientCountryForm
                )
            );
            $messages[$recipientCountryForm . '.percentage.sum'] = 'The overall sum of @percentage must not be more than 100.';
        }

        return $messages;
    }

    /**
     * generate rules for percentage.
     *
     * @param $recipient_countries
     *
     * @return array
     */
    protected function getPercentageRules($recipient_countries): array
    {
        $array = [];

        if (count($recipient_countries) > 1) {
            foreach ($recipient_countries as $countryIndex => $country) {
                $countryForm = sprintf('recipient_country.%s', $countryIndex);
                $percentage = $country['percentage'] ?: 0;
                $recipient_country = $country['country_code'] ?: 'Not Specified';
                $newIndex = $countryIndex + 1;

                if (isset($array['country_code']) && array_key_exists($recipient_country, $array)) {
                    $totalPercentage = (int) $array[$recipient_country] + (float) $percentage;
                    $array[$newIndex] = $totalPercentage;
                    $array[sprintf('%s.percentage', $countryForm)] = (string) $newIndex;
                } else {
                    $array['country_code'] = $recipient_country;
                    $array[$newIndex] = $percentage;
                    $array[sprintf('%s.percentage', $countryForm)] = (string) $newIndex;
                }
            }
        }

        return $array;
    }
}
