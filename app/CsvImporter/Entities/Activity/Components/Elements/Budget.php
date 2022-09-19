<?php

declare(strict_types=1);

namespace App\CsvImporter\Entities\Activity\Components\Elements;

use App\CsvImporter\Entities\Activity\Components\Elements\Foundation\Iati\Element;
use App\CsvImporter\Entities\Activity\Components\Factory\Validation;
use Illuminate\Support\Arr;

/**
 * Class Budget.
 */
class Budget extends Element
{
    /**
     * Csv Header for Budget element.
     * @var array
     */
    private array $_csvHeaders = ['budget_type', 'budget_status', 'budget_period_start', 'budget_period_end', 'budget_value', 'budget_value_date', 'budget_currency'];

    /**
     * Index under which the data is stored within the object.
     *
     * @var string
     */
    protected string $index = 'budget';

    /**
     * Budget constructor.
     * @param            $fields
     * @param Validation $factory
     */
    public function __construct($fields, Validation $factory)
    {
        $this->prepare($fields);
        $this->factory = $factory;
    }

    /**
     * Prepare the IATI Element.
     *
     * @param $fields
     *
     * @return void
     */
    protected function prepare($fields): void
    {
        foreach ($fields as $key => $values) {
            if (!is_null($values) && array_key_exists($key, array_flip($this->_csvHeaders))) {
                foreach ($values as $index => $value) {
                    $this->map($key, $value, $index);
                }
            }
        }
    }

    /**
     * Map data from CSV file into Budget data format.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function map($key, $value, $index): void
    {
        if (!(is_null($value) || $value === '')) {
            $this->setBudgetType($key, $value, $index);
            $this->setBudgetStatus($key, $value, $index);
            $this->setBudgetPeriodStart($key, $value, $index);
            $this->setBudgetPeriodEnd($key, $value, $index);
            $this->setBudgetValue($key, $value, $index);
            $this->setBudgetCurrency($key, $value, $index);
        }
    }

    /**
     * Set Budget type for Budget Element.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     * @throws \JsonException
     */
    protected function setBudgetType($key, $value, $index): void
    {
        if (!isset($this->data['budget'][$index]['budget_type'])) {
            $this->data['budget'][$index]['budget_type'] = '';
        }

        if ($key === $this->_csvHeaders[0]) {
            $validBudgetTypes = $this->loadCodeList('BudgetType');

            // foreach ($validBudgetTypes as $name => $budgetType) {
            //     if (ucwords($value) == $budgetType) {
            //         $value = $name;
            //         break;
            //     }
            // }

            $this->data['budget'][$index]['budget_type'] = $value;
        }
    }

    /**
     * Set Budget status for Budget Element.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     * @throws \JsonException
     */
    protected function setBudgetStatus($key, $value, $index): void
    {
        if (!isset($this->data['budget'][$index]['status'])) {
            $this->data['budget'][$index]['status'] = '';
        }
        if ($key === $this->_csvHeaders[1]) {
            $validBudgetStatus = $this->loadCodeList('BudgetStatus');

            // foreach ($validBudgetStatus as $name => $budgetStatus) {
            //     if (ucwords($value) == $budgetStatus) {
            //         $value = $name;
            //         break;
            //     }
            // }
            $this->data['budget'][$index]['status'] = $value;
        }
    }

    /**
     * Set Budget period start for Budget Element.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setBudgetPeriodStart($key, $value, $index): void
    {
        if (!isset($this->data['budget'][$index]['period_start'][0]['date'])) {
            $this->data['budget'][$index]['period_start'][0]['date'] = '';
        }
        if ($key === $this->_csvHeaders[2]) {
            $this->data['budget'][$index]['period_start'][0]['date'] = dateFormat('Y-m-d', $value);
        }
    }

    /**
     * Set Budget period end for Budget Element.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setBudgetPeriodEnd($key, $value, $index): void
    {
        if (!isset($this->data['budget'][$index]['period_end'][0]['date'])) {
            $this->data['budget'][$index]['period_end'][0]['date'] = '';
        }
        if ($key === $this->_csvHeaders[3]) {
            $this->data['budget'][$index]['period_end'][0]['date'] = dateFormat('Y-m-d', $value);
        }
    }

    /**
     * Set Budget value and value date for Budget Element.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setBudgetValue($key, $value, $index): void
    {
        if (!isset($this->data['budget'][$index]['value'])) {
            $this->data['budget'][$index]['value'] = '';
        }
        if ($key === $this->_csvHeaders[4]) {
            $this->data['budget'][$index]['value'][0]['amount'] = $value;
        }
        if ($key === $this->_csvHeaders[5]) {
            $this->data['budget'][$index]['value'][0]['value_date'] = dateFormat('Y-m-d', $value);
        }
    }

    /**
     * Set Budget currency for Budget Element.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setBudgetCurrency($key, $value, $index): void
    {
        if (!isset($this->data['budget'][$index]['value'][0]['currency'])) {
            $this->data['budget'][$index]['value'] = [
                [
                    'currency' => '',
                ],
            ];
        }
        if ($key === $this->_csvHeaders[6]) {
            $this->data['budget'][$index]['value'][0]['currency'] = strtoupper($value);
        }
    }

    /**
     * Validate data for IATI Element.
     *
     * @return $this
     */
    public function validate(): static
    {
        $this->validator = $this->factory->sign($this->data())
            ->with($this->rules(), $this->messages())
            ->getValidatorInstance();

        $this->setValidity();

        return $this;
    }

    /**
     * Provides the IATI Currency code list.
     *
     * @return string
     * @throws \JsonException
     */
    protected function currencyCodeList(): string
    {
        $currencyList = $this->loadCodeList('Currency');
        $codes = array_keys($currencyList);

        return implode(',', $codes);
    }

    /**
     * Provides the rules for the IATI Element validation.
     *
     * @return array
     * @throws \JsonException
     */
    public function rules(): array
    {
        $rules = ['budget' => 'start_before_end_date|diff_one_year'];

        foreach (Arr::get($this->data(), 'budget', []) as $key => $value) {
            $rules['budget.' . $key . '.budget_type'] = sprintf('in:%s', $this->budgetCodeListWithValue('BudgetType'));
            $rules['budget.' . $key . '.status'] = sprintf(
                'required_with:%s,%s,%s,%s,%s|in:%s',
                'budget.' . $key . '.budget_type',
                'budget.' . $key . '.period_start.0.date',
                'budget.' . $key . '.period_end.0.date',
                'budget.' . $key . '.value.0.amount',
                'budget.' . $key . '.value.0.value_date',
                $this->budgetCodeListWithValue('BudgetStatus')
            );
            $rules['budget.' . $key . '.period_start.0.date'] = sprintf(
                'required_with:%s,%s,%s,%s,%s|date_format:Y-m-d',
                'budget.' . $key . '.budget_type',
                'budget.' . $key . '.status',
                'budget.' . $key . '.period_end.0.date',
                'budget.' . $key . '.value.0.amount',
                'budget.' . $key . '.value.0.value_date'
            );
            $rules['budget.' . $key . '.period_end.0.date'] = sprintf(
                'required_with:%s,%s,%s,%s,%s|date_format:Y-m-d',
                'budget.' . $key . '.budget_type',
                'budget.' . $key . '.status',
                'budget.' . $key . '.period_start.0.date',
                'budget.' . $key . '.value.0.amount',
                'budget.' . $key . '.value.0.value_date'
            );
            $rules['budget.' . $key . '.value.0.amount'] = sprintf(
                'required_with:%s,%s,%s,%s,%s|numeric|min:0',
                'budget.' . $key . '.budget_type',
                'budget.' . $key . '.status',
                'budget.' . $key . '.period_start.0.date',
                'budget.' . $key . '.period_end.0.date',
                'budget.' . $key . '.value.0.value_date'
            );
            $rules['budget.' . $key . '.value.0.value_date'] = sprintf(
                'required_with:%s,%s,%s, %s,%s|date_format:Y-m-d',
                'budget.' . $key . '.budget_type',
                'budget.' . $key . '.status',
                'budget.' . $key . '.period_start.0.date',
                'budget.' . $key . '.period_end.0.date',
                'budget.' . $key . '.value.0.amount'
            );
            $rules['budget.' . $key . '.value.0.currency'] = sprintf('in:%s', $this->currencyCodeList());
        }

        return $rules;
    }

    /**
     * Provides custom messages used for IATI Element Validation.
     * @return array
     */
    public function messages(): array
    {
        $messages = [
            'budget.start_before_end_date' => 'Budget Period Start Date should be before Budget Period End Date.',
            'budget.diff_one_year'         => 'The difference of Budget Period Start Date and Budget Period End Date should not exceed 1 year.',
        ];

        foreach (Arr::get($this->data(), 'budget', []) as $key => $value) {
            $messages['budget.' . $key . '.budget_type.in'] = trans('validation.code_list', ['attribute' => trans('elementForm.budget_type')]);
            $messages['budget.' . $key . '.status.required_with'] = trans('validation.required', ['attribute' => trans('elementForm.budget_status')]);
            $messages['budget.' . $key . '.status.in'] = trans('validation.code_list', ['attribute' => trans('element.budget_status')]);
            $messages['budget.' . $key . '.period_start.0.date.date_format'] = trans('validation.csv_date', ['attribute' => trans('elementForm.budget_period_start_date')]);
            $messages['budget.' . $key . '.period_start.0.date.required_with'] = trans('validation.required', ['attribute' => trans('elementForm.budget_period_start_date')]);
            $messages['budget.' . $key . '.period_end.0.date.date_format'] = trans('validation.budget_period_end_date', ['attribute' => trans('elementForm.budget_period_end_date')]);
            $messages['budget.' . $key . '.period_end.0.date.required_with'] = trans('validation.required', ['attribute' => trans('elementForm.budget_period_end_date')]);
            $messages['budget.' . $key . '.value.0.amount.required_with'] = trans('validation.required', ['attribute' => trans('elementForm.budget_value')]);
            $messages['budget.' . $key . '.value.0.amount.numeric'] = trans('validation.numeric', ['attribute' => trans('elementForm.budget_value')]);
            $messages['budget.' . $key . '.value.0.amount.min'] = trans('validation.negative', ['attribute' => trans('elementForm.budget_value')]);
            $messages['budget.' . $key . '.value.0.value_date.required_with'] = trans('validation.required', ['attribute' => trans('elementForm.budget_value_date')]);
            $messages['budget.' . $key . '.value.0.value_date.date_format'] = trans('validation.csv_date', ['attribute' => trans('elementForm.budget_value_date')]);
            $messages['budget.' . $key . '.value.0.currency.in'] = trans('validation.code_list', ['attribute' => trans('elementForm.budget_currency_code')]);
        }

        return $messages;
    }

    /**
     * Get the valid BudgetCodes from the Budget codelist as a string.
     *
     * @param        $codeList
     *
     * @return string
     * @throws \JsonException
     */
    protected function budgetCodeListWithValue($codeList): string
    {
        [$budgetCodeList, $codes] = [$this->loadCodeList($codeList), []];
        $codes = array_keys($budgetCodeList) + array_values($budgetCodeList);

        return implode(',', array_keys(array_flip($codes)));
    }
}
