<?php

declare(strict_types=1);

namespace App\Http\Requests\Activity\Budget;

use App\Http\Requests\Activity\ActivityBaseRequest;
use App\IATI\Services\Activity\ActivityService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

/**
 * Class BudgetRequest.
 */
class BudgetRequest extends ActivityBaseRequest
{
    /**
     * @var array
     */
    protected array $identicalIds = [];

    /**
     * @var array
     */
    protected array $revisedIds = [];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $data = $this->get('budget');
        $totalRules = [$this->getErrorsForBudget($data), $this->getWarningForBudget($data)];

        return mergeRules($totalRules);
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
    public function getErrorsForBudget(array $formFields): array
    {
        $rules = [];
        $activityService = app()->make(ActivityService::class);
        $formFields = $activityService->setBudgets($formFields);
        $this->identicalIds = $activityService->checkSameMultipleBudgets($formFields);
        $this->revisedIds = $activityService->checkRevisedBudgets($formFields);

        foreach ($formFields as $budgetIndex => $budget) {
            $budgetForm = sprintf('budget.%s', $budgetIndex);
            $rules[sprintf('%s.budget_type', $budgetForm)] = sprintf('nullable|in:%s', implode(',', array_keys(getCodeList('BudgetType', 'Activity', false))));
            $rules[sprintf('%s.budget_status', $budgetForm)][] = 'nullable';
            $rules[sprintf('%s.budget_status', $budgetForm)][] = sprintf('in:%s', implode(',', array_keys(getCodeList('BudgetStatus', 'Activity', false))));

            $periodStartRules = $this->getCriticalBudgetWarningForPeriodStart($budget['period_start'], $budgetForm);

            foreach ($periodStartRules as $key => $periodStartRule) {
                $rules[$key] = $periodStartRule;
            }

            $periodEndRules = $this->getCriticalBudgetWarningForPeriodEnd($budget['period_end'], $budgetForm);

            foreach ($periodEndRules as $key => $periodEndRule) {
                $rules[$key] = $periodEndRule;
            }

            $valueRules = $this->getErrorsForValue($budget['budget_value'], $budgetForm);

            foreach ($valueRules as $key => $valueRule) {
                $rules[$key] = $valueRule;
            }
        }

        return $rules;
    }

    /**
     * Returns rules for related activity.
     *
     * @param array $formFields
     *
     * @return array
     */
    public function getWarningForBudget(array $formFields): array
    {
        $rules = [];
        $activityService = app()->make(ActivityService::class);
        $formFields = $activityService->setBudgets($formFields);
        $this->identicalIds = $activityService->checkSameMultipleBudgets($formFields);
        $this->revisedIds = $activityService->checkRevisedBudgets($formFields);

        if (count($this->identicalIds)) {
            Validator::extend('budgets_identical', function () {
                return false;
            });

            foreach ($this->identicalIds as $ids) {
                foreach ($ids as $id) {
                    $rules['budget.' . $id . '.budget_type'][] = 'budgets_identical';
                }
            }
        }

        if (count($this->revisedIds)) {
            Validator::extend('budget_revised_invalid', function () {
                return false;
            });

            foreach ($this->revisedIds as $ids) {
                foreach ($ids as $id) {
                    $rules['budget.' . $id . '.budget_type'][] = 'budget_revised_invalid';
                }
            }
        }

        foreach ($formFields as $budgetIndex => $budget) {
            $budgetForm = sprintf('budget.%s', $budgetIndex);
            $diff = 0;
            $start = $budget['period_start'][0]['date'];
            $end = $budget['period_end'][0]['date'];

            if ($start && $end) {
                $diff = (dateStrToTime($end) - dateStrToTime($start)) / 86400;
            }

            $periodStartRules = $this->getBudgetWarningForPeriodStart($budget['period_start'], $budgetForm, $diff);

            foreach ($periodStartRules as $key => $periodStartRule) {
                $rules[$key] = $periodStartRule;
            }

            $periodEndRules = $this->getBudgetWarningForPeriodEnd($budget['period_end'], $budgetForm, $diff);

            foreach ($periodEndRules as $key => $periodEndRule) {
                $rules[$key] = $periodEndRule;
            }

            $valueRules = $this->getWarningForValue($budget['budget_value'], $budgetForm);

            foreach ($valueRules as $key => $valueRule) {
                $rules[$key] = $valueRule;
            }

            $startDate = Arr::get($budget, 'period_start.0.date', null);
            $newDate = $startDate && isDate($startDate) ? date('Y-m-d', strtotime($startDate . '+1year')) : null;

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
    protected function getWarningForValue($formFields, $formBase): array
    {
        $rules = [];
        $periodStartFormBase = sprintf('%s.period_start.0.date', $formBase);
        $periodEndFormBase = sprintf('%s.period_end.0.date', $formBase);
        $betweenRule = sprintf('nullable|after_or_equal:%s|before_or_equal:%s', $periodStartFormBase, $periodEndFormBase);

        foreach ($formFields as $valueIndex => $value) {
            $valueForm = sprintf('%s.budget_value.%s', $formBase, $valueIndex);
            $rules[sprintf('%s.value_date', $valueForm)] = $betweenRule;
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
    protected function getErrorsForValue($formFields, $formBase): array
    {
        $rules = [];

        foreach ($formFields as $valueIndex => $value) {
            $valueForm = sprintf('%s.budget_value.%s', $formBase, $valueIndex);
            $rules[sprintf('%s.amount', $valueForm)] = 'nullable|numeric|min:0';
            $rules[sprintf('%s.value_date', $valueForm)] = 'nullable|date';
            $rules[sprintf('%s.currency', $valueForm)] = 'nullable|in:' . implode(',', array_keys(getCodeList('Currency', 'Activity', false)));
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
    public function getBudgetWarningForPeriodStart($formFields, $formBase, $diff): array
    {
        $rules = [];

        foreach ($formFields as $periodStartKey => $periodStartVal) {
            $rules[$formBase . '.period_start.' . $periodStartKey . '.date'] = 'nullable|date_greater_than:1900|period_start_end:' . $diff . ',365';
        }

        return $rules;
    }

    /**
     * returns rules for period start form.
     *
     * @param $formFields
     * @param $formBase
     *
     * @return array
     */
    public function getCriticalBudgetWarningForPeriodStart($formFields, $formBase): array
    {
        $rules = [];

        foreach ($formFields as $periodStartKey => $periodStartVal) {
            $rules[$formBase . '.period_start.' . $periodStartKey . '.date'] = 'nullable|date';
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
    public function getBudgetWarningForPeriodEnd($formFields, $formBase, $diff): array
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
     * returns rules for period end form.
     *
     * @param $formFields
     * @param $formBase
     *
     * @return array
     */
    public function getCriticalBudgetWarningForPeriodEnd($formFields, $formBase): array
    {
        $rules = [];

        foreach ($formFields as $periodEndKey => $periodEndVal) {
            $rules[$formBase . '.period_end.' . $periodEndKey . '.date'][] = 'nullable';
            $rules[$formBase . '.period_end.' . $periodEndKey . '.date'][] = 'date';
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
    public function getMessagesForBudget(array $formFields, bool $fileUpload = false): array
    {
        $messages = [];
        $activityService = app()->make(ActivityService::class);
        $formFields = $activityService->setBudgets($formFields);
        $this->identicalIds = $activityService->checkSameMultipleBudgets($formFields);
        $this->revisedIds = $activityService->checkRevisedBudgets($formFields);

        if (count($this->identicalIds)) {
            foreach ($this->identicalIds as $ids) {
                foreach ($ids as $id) {
                    $messages['budget.' . $id . '.budget_type.budgets_identical'] = trans('requests.multiple_budget_periods_should_not_be_same');
                }
            }
        }

        if (count($this->revisedIds)) {
            foreach ($this->revisedIds as $ids) {
                foreach ($ids as $id) {
                    $messages['budget.' . $id . '.budget_type.budget_revised_invalid'] = trans('requests.budget_with_type_revised_must_have_same_type') . $this->getIdenticalIds($ids);
                }
            }
        }

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

            $messages[$budgetForm . '.budget_type.in'] = translateRequestMessage('budget', 'type_is_invalid');
            $messages[$budgetForm . '.budget_status.in'] = translateRequestMessage('budget', 'status_is_invalid');
            $messages[$budgetForm . '.period_end.0.date.before'] = translateRequestMessage('period_end_iso', 'must_be_within_a_year');
            $messages[$budgetForm . '.period_end.0.date.period_start_end'] = translateRequestMessage('budget_period', 'must_not_be_longer_than_1_year');
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
            $messages[$formBase . '.period_start.' . $periodStartKey . '.date.date'] = translateRequestMessage('iso_field', 'must_be_a_valid_date');
            $messages[$formBase . '.period_start.' . $periodStartKey . '.date.date_greater_than'] = translateRequestMessage('iso_field', 'date_must_be_greater');
            $messages[$formBase . '.period_start.' . $periodStartKey . '.date.period_start_end'] = translateRequestMessage('budget_period', 'must_not_be_longer_than_1_year');
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
            $messages[$formBase . '.period_end.' . $periodEndKey . '.date.date'] = translateRequestMessage('iso_field', 'must_be_a_valid_date');
            $messages[$formBase . '.period_end.' . $periodEndKey . '.date.date_greater_than'] = translateRequestMessage('iso_field', 'date_must_be_greater');
            $messages[$formBase . '.period_end.' . $periodEndKey . '.date.after'] = translateRequestMessage('period_end_iso', 'must_be_a_date_after_period_start');
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
            $messages[sprintf('%s.amount.numeric', $valueForm)] = translateRequestMessage('amount_field', 'must_be_a_number');
            $messages[sprintf('%s.amount.min', $valueForm)] = translateRequestMessage('amount_field', 'must_not_be_negative');
            $messages[sprintf('%s.value_date.date', $valueForm)] = translateRequestMessage('value_date_field', 'must_be_a_valid_date');
            $messages[sprintf('%s.value_date.after_or_equal', $valueForm)] = translateRequestMessage('value_date_field', 'must_be_between');
            $messages[sprintf('%s.value_date.before_or_equal', $valueForm)] = translateRequestMessage('value_date_field', 'must_be_between');
        }

        return $messages;
    }

    /**
     * Implodes identical ids and returns them.
     *
     * @param $ids
     *
     * @return string
     */
    public function getIdenticalIds($ids): string
    {
        foreach ($ids as $key => $id) {
            $ids[$key] = $id + 1;
        }

        return implode(', ', $ids);
    }
}
