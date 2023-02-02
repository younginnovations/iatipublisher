<?php

declare(strict_types=1);

namespace App\CsvImporter\Entities\Activity\Components\Elements;

use App\CsvImporter\Entities\Activity\Components\Elements\Foundation\Iati\Element;
use App\CsvImporter\Entities\Activity\Components\Factory\Validation;
use App\Http\Requests\Activity\Budget\BudgetRequest;
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
    private array $_csvHeaders
    = [
        'budget_type',
        'budget_status',
        'budget_period_start',
        'budget_period_end',
        'budget_value',
        'budget_value_date',
        'budget_currency',
    ];

    /**
     * Index under which the data is stored within the object.
     *
     * @var string
     */
    protected string $index = 'budget';

    /**
     * @var BudgetRequest
     */
    private BudgetRequest $request;

    /**
     * Budget constructor.
     * @param            $fields
     * @param Validation $factory
     */
    public function __construct($fields, Validation $factory)
    {
        $this->prepare($fields);
        $this->factory = $factory;
        $this->request = new BudgetRequest();
    }

    /**
     * Prepare the IATI Element.
     *
     * @param $fields
     *
     * @return void
     * @throws \JsonException
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
     */
    protected function setBudgetType($key, $value, $index): void
    {
        if (!isset($this->data['budget'][$index]['budget_type'])) {
            $this->data['budget'][$index]['budget_type'] = '';
        }

        if ($key === $this->_csvHeaders[0]) {
            $validBudgetType = $this->loadCodeList('BudgetType');
            $value = $value ? trim($value) : '';

            if ($value) {
                foreach ($validBudgetType as $code => $name) {
                    if (strcasecmp($value, $name) === 0) {
                        $value = (string) $code;
                        break;
                    }
                }
            }

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
     */
    protected function setBudgetStatus($key, $value, $index): void
    {
        if (!isset($this->data['budget'][$index]['budget_status'])) {
            $this->data['budget'][$index]['budget_status'] = '';
        }
        if ($key === $this->_csvHeaders[1]) {
            $validBudgetStatus = $this->loadCodeList('BudgetStatus');

            if ($value) {
                foreach ($validBudgetStatus as $code => $name) {
                    if (strcasecmp(trim($value), $name) === 0) {
                        $value = (string) $code;
                        break;
                    }
                }
            }

            $this->data['budget'][$index]['budget_status'] = trim($value);
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
        if (!isset($this->data['budget'][$index]['budget_value'])) {
            $this->data['budget'][$index]['budget_value'][] = [];
        }

        if ($key === $this->_csvHeaders[4]) {
            $this->data['budget'][$index]['budget_value'][0]['amount'] = $value;
            $this->data['budget'][$index]['budget_value'][0]['currency'] = Arr::get($this->data(), 'budget.' . $index . '.budget_value.0.currency', null) ?? '';
        }

        if ($key === $this->_csvHeaders[5]) {
            $this->data['budget'][$index]['budget_value'][0]['value_date'] = dateFormat('Y-m-d', $value);
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
        if (!isset($this->data['budget'][$index]['budget_value'][0]['currency'])) {
            $this->data['budget'][$index]['budget_value'] = [
                [
                    'currency' => '',
                ],
            ];
        }

        if ($key === $this->_csvHeaders[6]) {
            $validCurrency = $this->loadCodeList('Currency');

            if ($value) {
                foreach ($validCurrency as $code => $name) {
                    if (strcasecmp(trim($value), $name) === 0) {
                        $value = (string) $code;
                        break;
                    }
                }
            }

            $this->data['budget'][$index]['budget_value'][0]['currency'] = strtoupper(trim($value));
        }
    }

    /**
     * Validate data for IATI Element.
     *
     * @return $this
     * @throws \JsonException
     */
    public function validate(): static
    {
        $this->validator = $this->factory->sign($this->data())
            ->with($this->rules(), $this->messages())
            ->getValidatorInstance();
        $this->criticalValidator = $this->factory->sign($this->data())
            ->with($this->criticalRules(), $this->messages())
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
        return $this->request->getRulesForBudget(Arr::get($this->data(), 'budget', []));
    }

    /**
     * Provides the critical rules for the IATI Element validation.
     *
     * @return array
     * @throws \JsonException
     */
    public function criticalRules(): array
    {
        return $this->request->getCriticalRulesForBudget(Arr::get($this->data(), 'budget', []));
    }

    /**
     * Provides custom messages used for IATI Element Validation.
     * @return array
     */
    public function messages(): array
    {
        return $this->request->getMessagesForBudget(Arr::get($this->data(), 'budget', []), true);
    }

    /**
     * Get the valid BudgetCodes from the Budget code list as a string.
     *
     * @param        $codeList
     *
     * @return string
     * @throws \JsonException
     */
    protected function budgetCodeListWithValue($codeList): string
    {
        $budgetCodeList = $this->loadCodeList($codeList);
        $codes = array_keys($budgetCodeList) + array_values($budgetCodeList);

        return implode(',', array_keys(array_flip($codes)));
    }
}
