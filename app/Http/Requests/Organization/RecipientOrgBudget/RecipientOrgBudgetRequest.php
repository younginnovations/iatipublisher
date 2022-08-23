<?php

declare(strict_types=1);

namespace App\Http\Requests\Organization\RecipientOrgBudget;

use App\Http\Requests\Organization\OrganizationBaseRequest;

/**
 * Class RecipientOrgBudgetRequest.
 */
class RecipientOrgBudgetRequest extends OrganizationBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];
        foreach ($this->get('recipient_org_budget') as $recipientOrganizationBudgetIndex => $recipientOrganizationBudget) {
            $diff = 0;
            $start = $recipientOrganizationBudget['period_start'][0]['date'];
            $end = $recipientOrganizationBudget['period_end'][0]['date'];

            if ($start && $end) {
                $diff = (strtotime($end) - strtotime($start)) / 86400;
            }

            $recipientOrganizationBudgetForm = sprintf('recipient_org_budget.%s', $recipientOrganizationBudgetIndex);
            $narrativeField = sprintf('%s.recipient_org.0.narrative.0.narrative', $recipientOrganizationBudgetForm);
            // $narrativeRuleWithoutRef = sprintf('required_without:%s.recipient_org.0.ref', $recipientOrganizationBudgetForm);
            // $rules[$narrativeField][] = $narrativeRuleWithoutRef;
            $rules = array_merge_recursive(
                $rules,
                $this->getRulesForPeriodStart($recipientOrganizationBudget['period_start'], $recipientOrganizationBudgetForm, $diff, 365),
                $this->getRulesForPeriodEnd($recipientOrganizationBudget['period_end'], $recipientOrganizationBudgetForm, $diff, 365),
                $this->getRulesForValue($recipientOrganizationBudget['value'], $recipientOrganizationBudgetForm),
                $this->getRulesForBudgetLine($recipientOrganizationBudget['budget_line'], $recipientOrganizationBudgetForm),
                $this->getRulesForNarrative($recipientOrganizationBudget['recipient_org'][0]['narrative'], $recipientOrganizationBudgetForm . '.recipient_org.0')
            );
        }

        return $rules;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        $messages = [];
        foreach ($this->get('recipient_org_budget') as $recipientOrganizationBudgetIndex => $recipientOrganizationBudget) {
            $recipientOrganizationBudgetForm = sprintf('recipient_org_budget.%s', $recipientOrganizationBudgetIndex);
            $narrativeField = sprintf('%s.recipient_org.0.narrative.0.narrative.required_without', $recipientOrganizationBudgetForm);
            $messages[$narrativeField] = trans('validation.required_without', ['attribute' => trans('elementForm.narrative'), 'values' => trans('elementForm.ref')]);
            $messages = array_merge(
                $messages,
                $this->getMessagesForPeriodStart($recipientOrganizationBudget['period_start'], $recipientOrganizationBudgetForm),
                $this->getMessagesForPeriodEnd($recipientOrganizationBudget['period_end'], $recipientOrganizationBudgetForm),
                $this->getMessagesForValue($recipientOrganizationBudget['value'], $recipientOrganizationBudgetForm),
                $this->getMessagesBudgetLine($recipientOrganizationBudget['budget_line'], $recipientOrganizationBudgetForm),
                $this->getMessagesForNarrative($recipientOrganizationBudget['recipient_org'][0]['narrative'], $recipientOrganizationBudgetForm . '.recipient_org.0')
            );
        }

        return $messages;
    }
}
