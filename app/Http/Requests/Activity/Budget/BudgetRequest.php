<?php

declare(strict_types=1);

namespace App\Http\Requests\Activity\Budget;

use App\Http\Requests\Activity\ActivityBaseRequest;
use Illuminate\Support\Arr;

/**
 * Class BudgetRequest.
 */
class BudgetRequest extends ActivityBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return $this->getRulesForBudget($this->get('budget'));
    }

    /**
     * Get the error message as required.
     *
     * @return array
     */
    public function messages(): array
    {
        return $this->getMessagesForBudget($this->get('budget'));
    }

    /**
     * Returns rules for related activity.
     *
     * @param array $formFields
     *
     * @return array
     */
    protected function getRulesForBudget(array $formFields): array
    {
        $rules = [];

        foreach ($formFields as $budgetIndex => $budget) {
            $diff = 0;
            $start = $budget['period_start'][0]['date'];
            $end = $budget['period_end'][0]['date'];

            if ($start && $end) {
                $diff = (strtotime($end) - strtotime($start)) / 86400;
            }

            $budgetForm = sprintf('budget.%s', $budgetIndex);
            $periodStartRules = $this->getBudgetRulesForPeriodStart($budget['period_start'], $budgetForm, $diff);

            foreach ($periodStartRules as $key => $periodStartRule) {
                $rules[$key] = $periodStartRule;
            }

            $periodEndRules = $this->getBudgetRulesForPeriodEnd($budget['period_end'], $budgetForm, $diff);

            foreach ($periodEndRules as $key => $periodEndRule) {
                $rules[$key] = $periodEndRule;
            }

            $valueRules = $this->getRulesForValue($budget['budget_value'], $budgetForm);

            foreach ($valueRules as $key => $valueRule) {
                $rules[$key] = $valueRule;
            }

            $startDate = Arr::get($budget, 'period_start.0.date', null);
            $newDate = $startDate ? date('Y-m-d', strtotime($startDate . '+1year')) : '';

            if ($newDate) {
                $rules[$budgetForm . '.period_end.0.date'][] = sprintf('before:%s', $newDate);
            }
        }

        return $rules;
    }

    /**
     * Returns rules for value.
     *
     * @param $formFields
     * @param $formBase
     *
     * @return array
     */
    protected function getRulesForValue($formFields, $formBase): array
    {
        $rules = [];
        $periodStartFormBase = sprintf('%s.period_start.0.date', $formBase);
        $periodEndFormBase = sprintf('%s.period_end.0.date', $formBase);
        $betweenRule = sprintf('nullable|date|after:%s|before:%s', $periodStartFormBase, $periodEndFormBase);

        foreach ($formFields as $valueIndex => $value) {
            $valueForm = sprintf('%s.budget_value.%s', $formBase, $valueIndex);
            $rules[sprintf('%s.amount', $valueForm)] = 'nullable|numeric';
            $rules[sprintf('%s.value_date', $valueForm)] = $betweenRule;
        }

        return $rules;
    }

    /**
     * returns rules for period start form.
     *
     * @param $formFields
     * @param $formBase
     * @param $diff
     *
     * @return array
     */
    public function getBudgetRulesForPeriodStart($formFields, $formBase, $diff): array
    {
        $rules = [];

        foreach ($formFields as $periodStartKey => $periodStartVal) {
            $rules[$formBase . '.period_start.' . $periodStartKey . '.date'] = 'nullable|date|date_greater_than:1900|period_start_end:' . $diff . ',365';
        }

        return $rules;
    }

    /**
     * returns rules for period end form.
     *
     * @param $formFields
     * @param $formBase
     * @param $diff
     *
     * @return array
     */
    public function getBudgetRulesForPeriodEnd($formFields, $formBase, $diff): array
    {
        $rules = [];

        foreach ($formFields as $periodEndKey => $periodEndVal) {
            $rules[$formBase . '.period_end.' . $periodEndKey . '.date'][] = 'nullable';
            $rules[$formBase . '.period_end.' . $periodEndKey . '.date'][] = 'date';
            $rules[$formBase . '.period_end.' . $periodEndKey . '.date'][] = sprintf(
                'after:%s',
                $formBase . '.period_start.' . $periodEndKey . '.date'
            );
            $rules[$formBase . '.period_end.' . $periodEndKey . '.date'][] = 'date_greater_than:1900';
            $rules[$formBase . '.period_end.' . $periodEndKey . '.date'][] = 'period_start_end:' . $diff . ',365';
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
    protected function getMessagesForBudget(array $formFields): array
    {
        $messages = [];

        foreach ($formFields as $budgetIndex => $budget) {
            $budgetForm = sprintf('budget.%s', $budgetIndex);
            $periodStartMessages = $this->getMessagesForPeriodStart($budget['period_start'], $budgetForm);

            foreach ($periodStartMessages as $key => $periodStartMessage) {
                $messages[$key] = $periodStartMessage;
            }

            $periodEndMessages = $this->getMessagesForPeriodEnd($budget['period_end'], $budgetForm);

            foreach ($periodEndMessages as $key => $periodEndMessage) {
                $messages[$key] = $periodEndMessage;
            }

            $valueMessages = $this->getMessagesForValue($budget['budget_value'], $budgetForm);

            foreach ($valueMessages as $key => $valueMessage) {
                $messages[$key] = $valueMessage;
            }

            $messages[$budgetForm . '.period_end.0.date.before'] = 'The Period End @iso-date must be within a year after Period Start @iso-date.';
            $messages[$budgetForm . '.period_end.0.date.period_start_end'] = 'he Budget Period must not be longer than one year';
        }

        return $messages;
    }

    /**
     * returns messages for period start form.
     *
     * @param $formFields
     * @param $formBase
     *
     * @return array
     */
    public function getMessagesForPeriodStart($formFields, $formBase): array
    {
        $messages = [];

        foreach ($formFields as $periodStartKey => $periodStartVal) {
            $messages[$formBase . '.period_start.' . $periodStartKey . '.date.date'] = 'The @iso-date field must be a valid date.';
            $messages[$formBase . '.period_start.' . $periodStartKey . '.date.date_greater_than'] = 'The @iso-date field must date after year 1900.';
            $messages[$formBase . '.period_start.' . $periodStartKey . '.date.period_start_end'] = 'The Budget Period must not be longer than one year';
        }

        return $messages;
    }

    /**
     * returns messages for period end form.
     *
     * @param $formFields
     * @param $formBase
     *
     * @return array
     */
    public function getMessagesForPeriodEnd($formFields, $formBase): array
    {
        $messages = [];

        foreach ($formFields as $periodEndKey => $periodEndVal) {
            $messages[$formBase . '.period_end.' . $periodEndKey . '.date.date'] = 'The @iso-date field must be a valid date.';
            $messages[$formBase . '.period_end.' . $periodEndKey . '.date.date_greater_than'] = 'The @iso-date field must be date after year 1900.';
            $messages[$formBase . '.period_end.' . $periodEndKey . '.date.after'] = 'The Period End @iso-date must be a date after Period Start @iso-date';
        }

        return $messages;
    }

    /**
     * Returns messages for value.
     *
     * @param $formFields
     * @param $formBase
     *
     * @return array
     */
    protected function getMessagesForValue($formFields, $formBase): array
    {
        $messages = [];

        foreach ($formFields as $valueIndex => $value) {
            $valueForm = sprintf('%s.budget_value.%s', $formBase, $valueIndex);
            $messages[sprintf('%s.amount.numeric', $valueForm)] = 'The amount field must be a number.';
            $messages[sprintf('%s.value_date.date', $valueForm)] = 'The @value-date field must be a valid date.';
            $messages[sprintf('%s.value_date.after', $valueForm)] = 'The @value-date field must be a between period start and period end';
            $messages[sprintf('%s.value_date.before', $valueForm)] = 'The @value-date field must be a between period start and period end';
        }

        return $messages;
    }
}
