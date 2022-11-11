<?php

declare(strict_types=1);

namespace App\CsvImporter\Entities\Activity\Components\Elements;

use App\CsvImporter\Entities\Activity\Components\Elements\Foundation\Iati\Element;
use App\CsvImporter\Entities\Activity\Components\Factory\Validation;
use Illuminate\Support\Arr;

/**
 * Class CountryBudgetItem.
 */
class CountryBudgetItem extends Element
{
    /**
     * Csv Header for CountryBudgetItem element.
     * @var array
     */
    private array $_csvHeaders
        = [
            'country_budget_item_vocabulary',
            'budget_item_code',
            'budget_item_percentage',
            'budget_item_description',
        ];

    /**
     * Index under which the data is stored within the object.
     *
     * @var string
     */
    protected string $index = 'country_budget_items';

    /**
     * CountryBudgetItem constructor.
     *
     * @param            $fields
     * @param Validation $factory
     */
    public function __construct($fields, Validation $factory)
    {
        $this->prepare($fields);
        $this->factory = $factory;
    }

    /**
     * Prepare CountryBudgetItem element.
     *
     * @param $fields
     *
     * @return void
     */
    public function prepare($fields): void
    {
        foreach ($fields as $key => $values) {
            if (!is_null($values) && array_key_exists($key, array_flip($this->_csvHeaders))) {
                foreach ($values as $index => $value) {
                    $this->map($key, $index, $value);
                }
            }
        }
    }

    /**
     * Map data from CSV file into CountryBudgetItem data format.
     *
     * @param $key
     * @param $index
     * @param $value
     *
     * @return void
     */
    public function map($key, $index, $value): void
    {
        if (!(is_null($value) || $value === '')) {
            $this->setCountryBudgetItemVocabulary($key, $value);
            $this->setBudgetItemCode($key, $value, $index);
            $this->setBudgetItemPercentage($key, $value, $index);
            $this->setBudgetItemDescriptionNarrative($key, $value, $index);
        }
    }

    /**
     * Maps CountryBudgetItem Vocabulary.
     *
     * @param $key
     * @param $value
     *
     * @return void
     */
    protected function setCountryBudgetItemVocabulary($key, $value): void
    {
        if ($key === $this->_csvHeaders[0]) {
            $value = (!$value) ? '' : $value;

            $validCountryBudgetItemVocab = $this->loadCodeList('BudgetIdentifierVocabulary');

            if ($value) {
                foreach ($validCountryBudgetItemVocab as $code => $name) {
                    if (strcasecmp(trim($value), $name) === 0) {
                        $value = strval($code);
                        break;
                    }
                }
            }

            $this->data['country_budget_items']['country_budget_vocabulary'] = $value;
        }
    }

    /**
     * Maps BudgetItem Code.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setBudgetItemCode($key, $value, $index): void
    {
        if ($key === $this->_csvHeaders[1]) {
            $value = (!$value) ? '' : $value;

            $validBudgetItemCode = $this->loadCodeList('BudgetIdentifier');

            if ($value) {
                foreach ($validBudgetItemCode as $code => $name) {
                    if (strcasecmp(trim($value), $name) === 0) {
                        $value = strval($code);
                        break;
                    }
                }
            }

            $this->data['country_budget_items']['budget_item'][$index]['code'] = $value;
        }
    }

    /**
     * Maps BudgetItem Percentage.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setBudgetItemPercentage($key, $value, $index): void
    {
        if ($key === $this->_csvHeaders[2]) {
            $value = (!$value) ? 0 : $value;

            $this->data['country_budget_items']['budget_item'][$index]['percentage'] = $value;
        }
    }

    /**
     * Set narrative for BudgetItem Description.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setBudgetItemDescriptionNarrative($key, $value, $index): void
    {
        if ($key === $this->_csvHeaders[3]) {
            $value = $value ?: '';
            $narrative = [
                'narrative' => $value,
                'language'  => '',
            ];

            $this->data['country_budget_items']['budget_item'][$index]['description'][0]['narrative'][] = $narrative;
        }
    }

    /**
     * Provides the rules for the IATI Element validation.
     *
     * @return array
     * @throws \JsonException
     */
    public function rules(): array
    {
        $validVocabulary = implode(',', $this->validCountryBudgetItemCodeList('BudgetIdentifierVocabulary'));
        $validCode = implode(',', $this->validCountryBudgetItemCodeList('BudgetIdentifier'));

        $rules = [];

        $rules['country_budget_items.country_budget_vocabulary'][] = sprintf(
            'in:%s',
            $validVocabulary
        );

        $totalPercentage = 0;

        if (count(Arr::get($this->data, 'country_budget_items.budget_item', []))) {
            foreach (Arr::get($this->data, 'country_budget_items.budget_item', []) as $key => $budgetItem) {
                $totalPercentage += Arr::get($budgetItem, 'percentage', 0);
                $rules['country_budget_items.country_budget_vocabulary'][] = sprintf(
                    'required_with: %s,%s,%s',
                    'country_budget_items.budget_item.' . $key . '.code',
                    'country_budget_items.budget_item.' . $key . '.percentage',
                    'country_budget_items.budget_item.' . $key . '.description.0.narrative.0.narrative',
                );

                $rules['country_budget_items.budget_item.' . $key . '.code'] = sprintf(
                    'in:%s|required_with: %s,%s,%s',
                    $validCode,
                    'country_budget_items.country_budget_vocabulary',
                    'country_budget_items.budget_item.' . $key . '.percentage',
                    'country_budget_items.budget_item.' . $key . '.description.0.narrative.0.narrative',
                );

                $rules['country_budget_items.budget_item.' . $key . '.description.0.narrative.0.narrative'] = sprintf(
                    'required_with: %s,%s,%s',
                    'country_budget_items.country_budget_vocabulary',
                    'country_budget_items.budget_item.' . $key . '.code',
                    'country_budget_items.budget_item.' . $key . '.percentage',
                );
            }

            if ($totalPercentage !== 100) {
                $rules['country_budget_items.budget_item.0.percentage'] = 'sum';
            }
        }

        return $rules;
    }

    /**
     * Return Valid CountryBudgetItem Type.
     *
     * @param $name
     *
     * @return array
     * @throws \JsonException
     */
    protected function validCountryBudgetItemCodeList($name): array
    {
        return array_keys($this->loadCodeList($name));
    }

    /**
     * Provides custom messages used for IATI Element Validation.
     *
     * @return array
     */
    public function messages(): array
    {
        $messages = [];

        $messages['country_budget_items.country_budget_vocabulary.in'] = trans(
            'validation.code_list',
            ['attribute' => trans('elementForm.country_budget_vocabulary')]
        );

        if (count(Arr::get($this->data, 'country_budget_items.budget_item', []))) {
            foreach (Arr::get($this->data(), 'country_budget_items.budget_item', []) as $key => $budgetItem) {
                $messages['country_budget_items.country_budget_vocabulary.required_with'] = trans(
                    'validation.required_with',
                    [
                        'attribute' => trans('elementForm.country_budget_vocabulary'),
                        'values'    => 'code, percentage or description',
                    ]
                );

                $messages['country_budget_items.budget_item.' . $key . '.code.in'] = trans(
                    'validation.code_list',
                    ['attribute' => trans('elementForm.budget_item_code')]
                );

                $messages['country_budget_items.budget_item.' . $key . '.code.required_with'] = trans(
                    'validation.required_with',
                    [
                        'attribute' => trans('elementForm.budget_item_code'),
                        'values'    => 'vocabulary, percentage or description',
                    ]
                );

                $messages['country_budget_items.budget_item.' . $key . '.description.0.narrative.0.narrative.required_with'] = trans(
                    'validation.required_with',
                    [
                        'attribute' => trans('elementForm.budget_item_code'),
                        'values'    => 'vocabulary, percentage or description',
                    ]
                );
            }
        }

        $messages['country_budget_items.budget_item.0.percentage.sum'] = 'Sum of percentage for all budget items must be 100%';

        return $messages;
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
        $this->setValidity();

        return $this;
    }
}
