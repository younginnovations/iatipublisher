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
                $diff = (strtotime($end) - strtotime($start)) / 86400;
            }

            $recipientCountryBudgetForm = sprintf('recipient_country_budget.%s', $recipientCountryBudgetIndex);
            $rules = array_merge(
                $rules,
                $this->getRecipientCountryBudgetRules(
                    $recipientCountryBudget['recipient_country'],
                    $recipientCountryBudgetForm
                ),
                $this->getRulesForPeriodStart($recipientCountryBudget['period_start'], $recipientCountryBudgetForm, $diff, 365),
                $this->getRulesForPeriodEnd($recipientCountryBudget['period_end'], $recipientCountryBudgetForm, $diff, 365),
                $this->getRulesForValue($recipientCountryBudget['value'], $recipientCountryBudgetForm),
                $this->getRulesForBudgetLine($recipientCountryBudget['budget_line'], $recipientCountryBudgetForm)
            );
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

        foreach ($this->get(
            'recipient_country_budget'
        ) as $recipientCountryBudgetIndex => $recipientCountryBudget) {
            $recipientCountryBudgetForm = sprintf('recipient_country_budget.%s', $recipientCountryBudgetIndex);
            $messages = array_merge(
                $messages,
                $this->getRecipientCountryBudgetMessages(
                    $recipientCountryBudget['recipient_country'],
                    $recipientCountryBudgetForm
                ),
                $this->getMessagesForPeriodStart($recipientCountryBudget['period_start'], $recipientCountryBudgetForm),
                $this->getMessagesForPeriodEnd($recipientCountryBudget['period_end'], $recipientCountryBudgetForm),
                $this->getMessagesForValue($recipientCountryBudget['value'], $recipientCountryBudgetForm),
                $this->getMessagesBudgetLine($recipientCountryBudget['budget_line'], $recipientCountryBudgetForm)
            );
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
            $rules = array_merge(
                $rules,
                $this->getRulesForNarrative($recipientCountry['narrative'], $recipientCountryForm)
            );
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
            $messages = array_merge(
                $messages,
                $this->getMessagesForNarrative($recipientCountry['narrative'], $recipientCountryForm)
            );
        }

        return $messages;
    }
}
