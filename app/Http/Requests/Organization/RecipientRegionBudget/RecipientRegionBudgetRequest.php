<?php

declare(strict_types=1);

namespace App\Http\Requests\Organization\RecipientRegionBudget;

use App\Http\Requests\Organization\OrganizationBaseRequest;

/**
 * Class RecipientRegionBudgetRequest.
 */
class RecipientRegionBudgetRequest extends OrganizationBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules()
    {
        $rules = [];
        foreach ($this->get('recipient_region_budget') as $recipientRegionBudgetIndex => $recipientRegionBudget) {
            $diff = 0;
            $start = $recipientRegionBudget['period_start'][0]['date'];
            $end = $recipientRegionBudget['period_end'][0]['date'];

            if ($start && $end) {
                $diff = (strtotime($end) - strtotime($start)) / 86400;
            }

            $recipientRegionBudgetForm = sprintf('recipient_region_budget.%s', $recipientRegionBudgetIndex);
            $rules = array_merge(
                $rules,
                $this->getRecipientRegionBudgetRules($recipientRegionBudget['recipient_region'], $recipientRegionBudgetForm),
                $this->getRulesForPeriodStart($recipientRegionBudget['period_start'], $recipientRegionBudgetForm, $diff, 365),
                $this->getRulesForPeriodEnd($recipientRegionBudget['period_end'], $recipientRegionBudgetForm, $diff, 365),
                $this->getRulesForValue($recipientRegionBudget['value'], $recipientRegionBudgetForm),
                $this->getRulesForBudgetLine($recipientRegionBudget['budget_line'], $recipientRegionBudgetForm)
            );
        }

        return $rules;
    }

    /**
     * Get the validation messages for the rules.
     * @return array
     */
    public function messages()
    {
        $messages = [];
        foreach ($this->get(
            'recipient_region_budget'
        ) as $recipientRegionBudgetIndex => $recipientRegionBudget) {
            $recipientRegionBudgetForm = sprintf('recipient_region_budget.%s', $recipientRegionBudgetIndex);
            $messages = array_merge(
                $messages,
                $this->getRecipientRegionBudgetMessages($recipientRegionBudget['recipient_region'], $recipientRegionBudgetForm),
                $this->getMessagesForPeriodStart($recipientRegionBudget['period_start'], $recipientRegionBudgetForm),
                $this->getMessagesForPeriodEnd($recipientRegionBudget['period_end'], $recipientRegionBudgetForm),
                $this->getMessagesForValue($recipientRegionBudget['value'], $recipientRegionBudgetForm),
                $this->getMessagesBudgetLine($recipientRegionBudget['budget_line'], $recipientRegionBudgetForm)
            );
        }

        return $messages;
    }

    /**
     * @param array $formFields
     * @param       $formBase
     * @return array
     */
    public function getRecipientRegionBudgetRules(array $formFields, $formBase)
    {
        $rules = [];
        foreach ($formFields as $recipientRegionIndex => $recipientRegion) {
            $recipientRegionForm = sprintf('%s.recipient_region.%s', $formBase, $recipientRegionIndex);
            $rules[sprintf('%s.vocabulary_uri', $recipientRegionForm)] = 'nullable|url';
            $rules[sprintf('%s.code', $recipientRegionForm)] = 'nullable';
            $rules = array_merge(
                $rules,
                $this->getRulesForNarrative($recipientRegion['narrative'], $recipientRegionForm)
            );
        }

        return $rules;
    }

    /**
     * @param array $formFields
     * @param       $formBase
     * @return array
     */
    public function getRecipientRegionBudgetMessages(array $formFields, $formBase)
    {
        $messages = [];
        foreach ($formFields as $recipientRegionIndex => $recipientRegion) {
            $recipientRegionForm = sprintf('%s.recipient_region.%s', $formBase, $recipientRegionIndex);
            $messages[sprintf('%s.recipient_region.%s.vocabulary_uri.url', $formBase, $recipientRegionIndex)] = trans('validation.url');
            $messages[sprintf('%s.recipient_region.%s.code.required', $formBase, $recipientRegionIndex)] = trans('validation.required', ['attribute' => trans('elementForm.code')]);
            $messages = array_merge(
                $messages,
                $this->getMessagesForNarrative($recipientRegion['narrative'], $recipientRegionForm)
            );
        }

        return $messages;
    }
}
