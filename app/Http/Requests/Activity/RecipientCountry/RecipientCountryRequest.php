<?php

declare(strict_types=1);

namespace App\Http\Requests\Activity\RecipientCountry;

use App\Http\Requests\Activity\ActivityBaseRequest;
use Illuminate\Support\Facades\Validator;

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
     * @param $formFields
     *
     * @return int
     */
    public function getTotalPercent($formFields): int
    {
        $total = 0;

        foreach ($formFields as $formField) {
            $total += $formField['percentage'];
        }

        return $total;
    }

    /**
     * Returns rules for related activity.
     *
     * @param array $formFields
     *
     * @return array
     */
    protected function getRulesForRecipientCountry(array $formFields): array
    {
        Validator::extend('allocated_country_percent_exceeded', function () {
            return false;
        });
        $rules = [];
        $totalCountryPercent = $this->getTotalPercent($formFields);
        $params = $this->route()->parameters();
        $allottedCountryPercent = app()->make(ActivityService::class)->getAllottedRecipientCountryPercent($params['id']);

        foreach ($formFields as $recipientCountryIndex => $recipientCountry) {
            $recipientCountryForm = 'recipient_country.' . $recipientCountryIndex;
            $rules[$recipientCountryForm . '.percentage'] = 'nullable|numeric|';

            $narrativeRules = $this->getRulesForNarrative($recipientCountry['narrative'], $recipientCountryForm);

            foreach ($narrativeRules as $key => $item) {
                $rules[$key] = $item;
            }

            if ($allottedCountryPercent === 100) {
                $rules[$recipientCountryForm . '.percentage'] .= '|max:100';
            }

            if ($totalCountryPercent > $allottedCountryPercent) {
                $rules[$recipientCountryForm . '.percentage'] .= '|allocated_country_percent_exceeded:';
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
    protected function getMessagesForRecipientCountry(array $formFields): array
    {
        $messages = [];

        foreach ($formFields as $recipientCountryIndex => $recipientCountry) {
            $recipientCountryForm = 'recipient_country.' . $recipientCountryIndex;
            $messages[$recipientCountryForm . '.percentage.numeric'] = 'The @percentage must be a number.';
            $messages[$recipientCountryForm . '.percentage.max'] = 'The @percentage cannot be greater than 100';

            $narrativeMessages = $this->getMessagesForNarrative($recipientCountry['narrative'], $recipientCountryForm);

            foreach ($narrativeMessages as $key => $item) {
                $messages[$key] = $item;
            }
            $messages[$recipientCountryForm . '.percentage.in'] = 'Country percent must be equal to allocated percent';
            $messages[$recipientCountryForm . '.percentage.allocated_country_percent_exceeded'] = 'Country percent must match with allocated percent';
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
