<?php

declare(strict_types=1);

namespace App\Http\Requests\Organization\TotalExpenditure;

use App\Http\Requests\Organization\OrganizationBaseRequest;

/**
 * Class TotalExpenditureRequest.
 */
class TotalExpenditureRequest extends OrganizationBaseRequest
{
    /**
     * rules for total expenditure.
     *
     * @return array
     */
    public function rules(): array
    {
        return $this->getRulesForTotalExpenditure($this->get('total_expenditure'));
    }

    /**
     * prepare messages for total expenditure.
     *
     * @return array
     */
    public function messages(): array
    {
        return $this->getMessagesForTotalExpenditure($this->get('total_expenditure'));
    }

    /**
     * rules for organization total expenditure.
     *
     * @param $formFields
     *
     * @return array
     */
    public function getRulesForTotalExpenditure($formFields): array
    {
        $rules = [];

        foreach ($formFields as $totalExpenditureIndex => $totalExpenditure) {
            $diff = 0;
            $start = $totalExpenditure['period_start'][0]['date'];
            $end = $totalExpenditure['period_end'][0]['date'];

            if ($start && $end) {
                $diff = (strtotime($end) - strtotime($start)) / 86400;
            }

            $totalExpenditureForm = sprintf('total_expenditure.%s', $totalExpenditureIndex);
            $rules = array_merge(
                $rules,
                $this->getRulesForPeriodStart($totalExpenditure['period_start'], $totalExpenditureForm, $diff, 365),
                $this->getRulesForPeriodEnd($totalExpenditure['period_end'], $totalExpenditureForm, $diff, 365),
                $this->getRulesForValue($totalExpenditure['value'], $totalExpenditureForm),
                $this->getRulesForExpenseLine($totalExpenditure['expense_line'], $totalExpenditureForm)
            );
        }

        return $rules;
    }

    /**
     * messages for organization total expenditure.
     *
     * @param $formFields
     *
     * @return array
     */
    public function getMessagesForTotalExpenditure($formFields): array
    {
        $messages = [];

        foreach ($formFields as $totalExpenditureIndex => $totalExpenditure) {
            $totalExpenditureForm = sprintf('total_expenditure.%s', $totalExpenditureIndex);
            $messages = array_merge(
                $messages,
                $this->getMessagesForPeriodStart($totalExpenditure['period_start'], $totalExpenditureForm),
                $this->getMessagesForPeriodEnd($totalExpenditure['period_end'], $totalExpenditureForm),
                $this->getMessagesForValue($totalExpenditure['value'], $totalExpenditureForm),
                $this->getMessagesForExpenseLine($totalExpenditure['expense_line'], $totalExpenditureForm)
            );
        }

        return $messages;
    }

    /**
     * rules for expense line.
     *
     * @param $formFields
     * @param $formBase
     *
     * @return array
     */
    public function getRulesForExpenseLine($formFields, $formBase): array
    {
        $rules = [];

        foreach ($formFields as $expenseLineIndex => $expenseLine) {
            $expenseLineForm = sprintf('%s.expense_line.%s', $formBase, $expenseLineIndex);
            $rules = array_merge(
                $rules,
                $this->getRulesForBudgetOrExpenseLineValue($expenseLine['value'], $expenseLineForm),
                $this->getRulesForBudgetOrExpenseLineNarrative($expenseLine['narrative'], $expenseLineForm, $expenseLineIndex)
            );
        }

        return $rules;
    }

    /**
     * messages for expense line.
     *
     * @param $formFields
     * @param $formBase
     *
     * @return array
     */
    public function getMessagesForExpenseLine($formFields, $formBase): array
    {
        $messages = [];

        foreach ($formFields as $expenseLineIndex => $expenseLine) {
            $expenseLineForm = sprintf('%s.expense_line.%s', $formBase, $expenseLineIndex);
            $messages[sprintf('%s.expense_line.%s.reference.required', $formBase, $expenseLineIndex)] = trans('validation.required', ['attribute' => trans('elementForm.reference')]);
            $messages = array_merge(
                $messages,
                $this->getMessagesForBudgetOrExpenseLineValue($expenseLine['value'], $expenseLineForm, 'Expense Line'),
                $this->getMessagesForBudgetOrExpenseLineNarrative($expenseLine['narrative'], $expenseLineForm, 'Expense line')
            );
        }

        return $messages;
    }
}
