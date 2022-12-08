<?php

declare(strict_types=1);

namespace App\Http\Requests\Organization\RecipientCountryBudget;

use App\Http\Requests\Organization\OrganizationBaseRequest;

/**
 * Class RecipientCountryBudgetRequest.
 */
class RecipientCountryBudgetRequest extends OrganizationBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = [];

        foreach ($this->get('recipient_country_budget') as $recipientCountryBudgetIndex => $recipientCountryBudget) {
            $diff = 0;
            $start = $recipientCountryBudget['period_start'][0]['date'];
            $end = $recipientCountryBudget['period_end'][0]['date'];

            if ($start && $end) {
                $diff = (dateStrToTime($end) - dateStrToTime($start)) / 86400;
            }

            $recipientCountryBudgetForm = sprintf('recipient_country_budget.%s', $recipientCountryBudgetIndex);

            $budgetRules = $this->getRecipientCountryBudgetRules($recipientCountryBudget['recipient_country'], $recipientCountryBudgetForm);

            foreach ($budgetRules as $key => $budgetRule) {
                $rules[$key] = $budgetRule;
            }

            $periodStartRules = $this->getRulesForPeriodStart($recipientCountryBudget['period_start'], $recipientCountryBudgetForm, $diff, 365);

            foreach ($periodStartRules as $key => $periodStartRule) {
                $rules[$key] = $periodStartRule;
            }

            $periodEndRules = $this->getRulesForPeriodEnd($recipientCountryBudget['period_end'], $recipientCountryBudgetForm, $diff, 365);

            foreach ($periodEndRules as $key => $periodEndRule) {
                $rules[$key] = $periodEndRule;
            }

            $valueRules = $this->getRulesForValue($recipientCountryBudget['value'], $recipientCountryBudgetForm);

            foreach ($valueRules as $key => $valueRule) {
                $rules[$key] = $valueRule;
            }

            $budgetLineRules = $this->getRulesForBudgetLine($recipientCountryBudget['budget_line'], $recipientCountryBudgetForm);

            foreach ($budgetLineRules as $key => $budgetLineRule) {
                $rules[$key] = $budgetLineRule;
            }
        }

        return $rules;
    }

    /**
     * return validation messages to the rules.
     *
     * @return array
     */
    public function messages(): array
    {
        $messages = [];

        foreach ($this->get('recipient_country_budget') as $recipientCountryBudgetIndex => $recipientCountryBudget) {
            $recipientCountryBudgetForm = sprintf('recipient_country_budget.%s', $recipientCountryBudgetIndex);

            $budgetMessages = $this->getRecipientCountryBudgetMessages($recipientCountryBudget['recipient_country'], $recipientCountryBudgetForm);

            foreach ($budgetMessages as $key => $budgetMessage) {
                $messages[$key] = $budgetMessage;
            }

            $periodStartMessages = $this->getMessagesForPeriodStart($recipientCountryBudget['period_start'], $recipientCountryBudgetForm);

            foreach ($periodStartMessages as $key => $periodStartMessage) {
                $messages[$key] = $periodStartMessage;
            }

            $periodEndMessages = $this->getMessagesForPeriodEnd($recipientCountryBudget['period_end'], $recipientCountryBudgetForm);

            foreach ($periodEndMessages as $key => $periodEndMessage) {
                $messages[$key] = $periodEndMessage;
            }

            $valueMessages = $this->getMessagesForValue($recipientCountryBudget['value'], $recipientCountryBudgetForm);

            foreach ($valueMessages as $key => $valueMessage) {
                $messages[$key] = $valueMessage;
            }

            $budgetLineMessages = $this->getMessagesBudgetLine($recipientCountryBudget['budget_line'], $recipientCountryBudgetForm);

            foreach ($budgetLineMessages as $key => $budgetLineMessage) {
                $messages[$key] = $budgetLineMessage;
            }
        }

        return $messages;
    }

    /**
     * Rules for recipient country budget.
     *
     * @param array $formFields
     * @param       $formBase
     *
     * @return array
     */
    public function getRecipientCountryBudgetRules(array $formFields, $formBase): array
    {
        $rules = [];

        foreach ($formFields as $recipientCountryIndex => $recipientCountry) {
            $recipientCountryForm = sprintf('%s.recipient_country.%s', $formBase, $recipientCountryIndex);
            $rules[sprintf('%s.code', $recipientCountryForm)] = 'nullable';
            $narrativeRules = $this->getRulesForNarrative($recipientCountry['narrative'], $recipientCountryForm);

            foreach ($narrativeRules as $key => $narrativeRule) {
                $rules[$key] = $narrativeRule;
            }
        }

        return $rules;
    }

    /**
     * Custom messages for recipient country budget form.
     *
     * @param array $formFields
     * @param       $formBase
     *
     * @return array
     */
    public function getRecipientCountryBudgetMessages(array $formFields, $formBase): array
    {
        $messages = [];

        foreach ($formFields as $recipientCountryIndex => $recipientCountry) {
            $recipientCountryForm = sprintf('%s.recipient_country.%s', $formBase, $recipientCountryIndex);
            $messages[sprintf('%s.code.required', $recipientCountryForm)] = trans('validation.required', ['attribute' => trans('elementForm.code')]);
            $narrativeMessages = $this->getMessagesForNarrative($recipientCountry['narrative'], $recipientCountryForm);

            foreach ($narrativeMessages as $key => $narrativeMessage) {
                $messages[$key] = $narrativeMessage;
            }
        }

        return $messages;
    }
}
