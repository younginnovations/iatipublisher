<?php

declare(strict_types=1);

namespace App\CsvImporter\Entities\Activity\Components\Elements;

use App\CsvImporter\Entities\Activity\Components\Elements\Foundation\Iati\Element;
use App\CsvImporter\Entities\Activity\Components\Factory\Validation;
use App\Http\Requests\Activity\CountryBudgetItem\CountryBudgetItemRequest;
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
     * @var CountryBudgetItemRequest
     */
    private CountryBudgetItemRequest $request;

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
        $this->request = new CountryBudgetItemRequest();
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
        if (!isset($this->data['country_budget_items']['country_budget_vocabulary'])) {
            $this->data['country_budget_items']['country_budget_vocabulary'] = '';
        }

        if ($key === $this->_csvHeaders[0]) {
            $value = (!$value) ? '' : trim($value);

            $validCountryBudgetItemVocab = $this->loadCodeList('BudgetIdentifierVocabulary');

            if ($value) {
                foreach ($validCountryBudgetItemVocab as $code => $name) {
                    if (strcasecmp($value, $name) === 0) {
                        $value = (string) $code;
                        break;
                    }
                }
            }

            $this->data['country_budget_items']['country_budget_vocabulary'] = Arr::get($this->data(), 'country_budget_items.country_budget_vocabulary', $value);
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
        if (!isset($this->data['country_budget_items']['budget_item'][$index]['code'])) {
            $this->data['country_budget_items']['budget_item'][$index]['code'] = '';
        }

        if ($key === $this->_csvHeaders[1]) {
            $value = (!$value) ? '' : trim($value);

            $validBudgetItemCode = $this->loadCodeList('BudgetIdentifier');

            if ($value) {
                foreach ($validBudgetItemCode as $code => $name) {
                    if (strcasecmp($value, $name) === 0) {
                        $value = (string) $code;
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
        if (!isset($this->data['country_budget_items']['budget_item'][$index]['percentage'])) {
            $this->data['country_budget_items']['budget_item'][$index]['percentage'] = '';
        }

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
        if (!isset($this->data['country_budget_items']['budget_item'][$index]['description'][0]['narrative'][0]['narrative'])) {
            $this->data['country_budget_items']['budget_item'][$index]['description'][0]['narrative'][0] = [
                'narrative' => '',
                'language'  => '',
            ];
        }

        if ($key === $this->_csvHeaders[3]) {
            $value = $value ?: '';
            $narrative = [
                'narrative' => $value,
                'language'  => '',
            ];

            $this->data['country_budget_items']['budget_item'][$index]['description'][0]['narrative'][0] = $narrative;
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
        return $this->getBaseRules($this->request->getRulesForCountryBudgetItem(Arr::get($this->data, 'country_budget_items', [])), false);
    }

    /**
     * Provides custom messages used for IATI Element Validation.
     *
     * @return array
     */
    public function messages(): array
    {
        return $this->getBaseMessages($this->request->getMessagesForCountryBudgetItem(Arr::get($this->data, 'country_budget_items', [])), false);
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
