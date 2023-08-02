<?php

declare(strict_types=1);

namespace App\Http\Requests\Activity\CountryBudgetItem;

use App\Http\Requests\Activity\ActivityBaseRequest;
use Illuminate\Support\Arr;

/**
 * Class CountryBudgetItemRequest.
 */
class CountryBudgetItemRequest extends ActivityBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $data = request()->except(['_token', '_method']);
        $totalRules = [$this->getErrorsForCountryBudgetItem($data), $this->getWarningForCountryBudgetItem($data)];

        return mergeRules($totalRules);
    }

    /**
     * Get the error message as required.
     *
     * @return array
     */
    public function messages(): array
    {
        return $this->getMessagesForCountryBudgetItem(request()->except(['_token', '_method']));
    }

    /**
     * Returns rules for related activity.
     *
     * @param array $formFields
     *
     * @return array
     */
    public function getWarningForCountryBudgetItem(array $formFields): array
    {
        $rules = $this->getBudgetItemRules(Arr::get($formFields, 'budget_item', []), $formFields);

        return $rules;
    }

    /**
     * Returns rules for related activity.
     *
     * @param array $formFields
     *
     * @return array
     */
    public function getErrorsForCountryBudgetItem(array $formFields): array
    {
        $rules = $this->getErrorBudgetItemRules(Arr::get($formFields, 'budget_item', []), $formFields);
        $rules['country_budget_vocabulary'] = 'nullable|in:' . implode(',', array_keys(getCodeList('BudgetIdentifierVocabulary', 'Activity', false)));

        return $rules;
    }

    /**
     * Returns messages for related activity validations.
     *
     * @param array $formFields
     *
     * @return array
     */
    public function getMessagesForCountryBudgetItem(array $formFields): array
    {
        $messages = $this->getBudgetItemMessages(Arr::get($formFields, 'budget_item', []));
        $messages['country_budget_vocabulary.in'] = translateRequestMessage('country_budget_item', 'vocabulary_is_invalid');

        return $messages;
    }

    /**
     * returns budget item validation rules.
     *
     * @param array $formFields
     * @param array $allFields
     * @param array $budgetItemForm
     *
     * @return array
     */
    public function getBudgetItemRules(array $formFields, array $allFields): array
    {
        $rules = [];

        foreach ($formFields as $budgetItemIndex => $budgetItem) {
            $budgetItemForm = sprintf('budget_item.%s', $budgetItemIndex);
            $rules[sprintf('%s.percentage', $budgetItemForm)] = 'max:100';

            foreach ($this->getBudgetItemDescriptionRules($budgetItem['description'], $budgetItemForm) as $budgetItemDescriptionIndex => $budgetItemDescriptionNarrativeRules) {
                $rules[$budgetItemDescriptionIndex] = $budgetItemDescriptionNarrativeRules;
            }

            foreach ($this->getWarningForPercentage($allFields) as $budgetItemPercentageIndex => $budgetItemPercentageRules) {
                $rules[$budgetItemPercentageIndex] = $budgetItemPercentageRules;
            }
        }

        return $rules;
    }

    /**
     * returns budget item validation rules.
     *
     * @param array $formFields
     * @param array $allFields
     * @param array $budgetItemForm
     *
     * @return array
     */
    public function getErrorBudgetItemRules(array $formFields, array $allFields): array
    {
        $rules = [];

        foreach ($formFields as $budgetItemIndex => $budgetItem) {
            $budgetItemForm = sprintf('budget_item.%s', $budgetItemIndex);
            $rules[sprintf('%s.code', $budgetItemForm)] = 'nullable|in:' . implode(',', array_keys(getCodeList('BudgetIdentifier', 'Activity', false)));
            $rules[sprintf('%s.percentage', $budgetItemForm)] = 'nullable|numeric';

            foreach ($this->getCriticalBudgetItemDescriptionRules($budgetItem['description'], $budgetItemForm) as $budgetItemDescriptionIndex => $budgetItemDescriptionNarrativeRules) {
                $rules[$budgetItemDescriptionIndex] = $budgetItemDescriptionNarrativeRules;
            }
        }

        return $rules;
    }

    /**
     * return budget item error message.
     *
     * @param $formFields
     *
     * @return array
     */
    public function getBudgetItemMessages(array $formFields): array
    {
        $messages = [];

        foreach ($formFields as $budgetItemIndex => $budgetItem) {
            $budgetItemForm = sprintf('budget_item.%s', $budgetItemIndex);
            $messages[sprintf('%s.code.in', $budgetItemForm)] = translateRequestMessage('the_budget_item', 'code_is_invalid');
            $messages[sprintf('%s.percentage.%s', $budgetItemForm, 'numeric')] = translateRequestMessage('the_budget_percentage', 'must_be_a_number');
            $messages[sprintf('%s.percentage.%s', $budgetItemForm, 'max')] = translateRequestMessage('the_budget_percentage', 'cannot_be_greater_than_100');
            $messages[sprintf('%s.percentage.sum', $budgetItemForm)] = translateRequestMessage('sum_of_percentage_with_budget_items_must_add_up_to_100');
            $messages[sprintf('%s.percentage.total', $budgetItemForm)] = translateRequestMessage('the_budget_percentage', 'should_be_100');

            foreach ($this->getBudgetItemDescriptionMessages($budgetItem['description'], $budgetItemForm) as $budgetItemDescriptionIndex => $budgetItemDescriptionNarrativeMessages) {
                $messages[$budgetItemDescriptionIndex] = $budgetItemDescriptionNarrativeMessages;
            }
        }

        return $messages;
    }

    /**
     * return budget item description rule.
     *
     * @param $formFields
     * @param $formBase
     *
     * @return array
     */
    public function getBudgetItemDescriptionRules(array $formFields, $formBase): array
    {
        $rules = [];

        foreach ($formFields as $descriptionIndex => $description) {
            $descriptionForm = sprintf('%s.description.%s', $formBase, $descriptionIndex);
            $rules = $this->getWarningForNarrative($description['narrative'], $descriptionForm);
        }

        return $rules;
    }

    /**
     * return budget item description critical rules.
     *
     * @param $formFields
     * @param $formBase
     *
     * @return array
     */
    public function getCriticalBudgetItemDescriptionRules(array $formFields, $formBase): array
    {
        $rules = [];

        foreach ($formFields as $descriptionIndex => $description) {
            $descriptionForm = sprintf('%s.description.%s', $formBase, $descriptionIndex);
            $rules = $this->getErrorsForNarrative($description['narrative'], $descriptionForm);
        }

        return $rules;
    }

    /**
     * return budget item description error message.
     *
     * @param $formFields
     * @param $formBase
     *
     * @return array
     */
    public function getBudgetItemDescriptionMessages(array $formFields, $formBase): array
    {
        $messages = [];

        foreach ($formFields as $descriptionIndex => $description) {
            $descriptionForm = sprintf('%s.description.%s', $formBase, $descriptionIndex);
            $messages = $this->getMessagesForNarrative($description['narrative'], $descriptionForm);
        }

        return $messages;
    }

    /**
     * Returns rules for percentage.
     *
     * @param $countryBudget
     *
     * @return array
     */
    public function getWarningForPercentage($countryBudget): array
    {
        $countryBudgetItems = Arr::get($countryBudget, 'budget_item', []);
        $totalPercentage = 0;

        $rules = [];

        if (count($countryBudgetItems) > 1) {
            foreach ($countryBudgetItems as $key => $countryBudgetItem) {
                $countryBudgetPercentage = $countryBudgetItem['percentage'] ?: 0;
                $totalPercentage = $totalPercentage + (float) $countryBudgetPercentage;
            }

            foreach ($countryBudgetItems as $key => $countryBudgetItem) {
                if ($totalPercentage != 100) {
                    $rules["budget_item.$key.percentage"] = 'sum';
                }
            }
        } else {
            $rules['budget_item.0.percentage'] = 'nullable|total';
        }

        return $rules;
    }
}
