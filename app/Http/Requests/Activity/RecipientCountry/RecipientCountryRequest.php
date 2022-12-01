<?php

declare(strict_types=1);

namespace App\Http\Requests\Activity\RecipientCountry;

use App\Http\Requests\Activity\ActivityBaseRequest;
use App\IATI\Services\Activity\ActivityService;
use Illuminate\Contracts\Container\BindingResolutionException;
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
     * @throws BindingResolutionException
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
     * @return float
     */
    public function getTotalPercent($formFields): float
    {
        $total = 0;

        foreach ($formFields as $formField) {
            //if clause added to bypass server error. Numeric validation will invoke and data wont be saved
            if (is_numeric($formField['percentage'])) {
                $total += $formField['percentage'];
            }
        }

        return $total;
    }

    /**
     * Returns rules for related activity.
     *
     * @param array $formFields
     *
     * @return array
     * @throws BindingResolutionException
     */
    public function getRulesForRecipientCountry(array $formFields): array
    {
        if (empty($formFields)) {
            return [];
        }

//        $params = $this->route()->parameters();
//        $activityService = app()->make(ActivityService::class);
//
//        if ($activityService->hasRecipientCountryDefinedInTransactions($params['id'])) {
//            Validator::extend('already_in_transactions', function () {
//                return false;
//            });
//
//            return ['recipient_country' => 'already_in_transactions'];
//        }
//
        Validator::extend('allocated_country_percent_exceeded', function () {
            return false;
        });

        Validator::extend('sum_exceeded', function () {
            return false;
        });

        $rules = [];
//        $allottedCountryPercent = $activityService->getAllottedRecipientCountryPercent($params['id']);
        $allottedCountryPercent = 100;
        $totalCountryPercent = $this->getTotalPercent($formFields);

        foreach ($formFields as $recipientCountryIndex => $recipientCountry) {
            $recipientCountryForm = 'recipient_country.' . $recipientCountryIndex;
            $rules[$recipientCountryForm . '.percentage'] = 'nullable|numeric|min:0';

            $narrativeRules = $this->getRulesForNarrative($recipientCountry['narrative'], $recipientCountryForm);

            foreach ($narrativeRules as $key => $item) {
                $rules[$key] = $item;
            }

            if ($totalCountryPercent > 100.0) {
                $rules[$recipientCountryForm . '.percentage'] .= '|sum_exceeded';
            }

            if ($allottedCountryPercent === 100.0) {
                $rules[$recipientCountryForm . '.percentage'] .= '|max:100';
            }

            if ($totalCountryPercent !== $allottedCountryPercent && $allottedCountryPercent !== 100.0) {
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
    public function getMessagesForRecipientCountry(array $formFields): array
    {
        $messages = ['recipient_country.already_in_transactions' => 'Recipient Country Already defined in Transactions'];

        foreach ($formFields as $recipientCountryIndex => $recipientCountry) {
            $recipientCountryForm = 'recipient_country.' . $recipientCountryIndex;
            $messages[$recipientCountryForm . '.percentage.numeric'] = 'The @percentage must be a number.';
            $messages[$recipientCountryForm . '.percentage.max'] = 'The @percentage cannot be greater than 100';
            $messages[$recipientCountryForm . '.percentage.sum_exceeded'] = 'The sum of percentage cannot be greater than 100';

            $narrativeMessages = $this->getMessagesForNarrative($recipientCountry['narrative'], $recipientCountryForm);

            foreach ($narrativeMessages as $key => $item) {
                $messages[$key] = $item;
            }
            $messages[$recipientCountryForm . '.percentage.in'] = 'Country percent must be equal to allocated percent';
            $messages[$recipientCountryForm . '.percentage.allocated_country_percent_exceeded'] = 'Country percent must match with allocated percent';
        }

        return $messages;
    }
}
