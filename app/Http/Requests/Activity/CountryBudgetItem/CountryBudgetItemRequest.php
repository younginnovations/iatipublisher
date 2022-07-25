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
        return $this->getRulesForCountryBudgetItem(request()->except(['_token', '_method']));
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
    protected function getRulesForCountryBudgetItem(array $formFields): array
    {
        $rules = [];

        $code = $formFields['country_budget_vocabulary'] == 1 ? 'code' : 'code_text';
        $rules = array_merge(
            $rules,
            $this->getBudgetItemRules($formFields['budget_item'], $code)
        );

        return $rules;
    }

    /**
     * Returns messages for related activity validations.
     *
     * @param array $formFields
     *
     * @return array
     */
    protected function getMessagesForCountryBudgetItem(array $formFields): array
    {
        $messages = [];

        $code = $formFields['country_budget_vocabulary'] == 1 ? 'code' : 'code_text';
        $messages = array_merge(
            $messages,
            $this->getBudgetItemMessages($formFields['budget_item'], $code)
        );

        return $messages;
    }

    /**
     * returns budget item validation rules.
     *
     * @param $formFields
     * @param $code
     *
     * @return array
     */
    public function getBudgetItemRules(array $formFields, $code): array
    {
        $rules = [];

        foreach ($formFields as $budgetItemIndex => $budgetItem) {
            $budgetItemForm = sprintf('budget_item.%s', $budgetItemIndex);
            $rules[sprintf('%s.percentage', $budgetItemForm)] = 'nullable|numeric|max:100';
            $rules = array_merge(
                $rules,
                $this->getBudgetItemDescriptionRules($budgetItem['description'], $budgetItemForm)
            );
            $rules = array_merge(
                $rules,
                $this->getRulesForPercentage(request()->except(['_token', '_method']))
            );
        }

        return $rules;
    }

    /**
     * return budget item error message.
     *
     * @param $formFields
     * @param $code
     *
     * @return array
     */
    public function getBudgetItemMessages(array $formFields, $code): array
    {
        $messages = [];

        foreach ($formFields as $budgetItemIndex => $budgetItem) {
            $budgetItemForm = sprintf('budget_item.%s', $budgetItemIndex);
            $messages[sprintf('%s.percentage.%s', $budgetItemForm, 'numeric')] = 'The @percentage field must be a number.';
            $messages[sprintf('%s.percentage.%s', $budgetItemForm, 'max')] = 'The @percentage field cannot be greater than 100.';
            $messages[sprintf('%s.percentage.sum', $budgetItemForm)] = 'The sum of @percentage must add up to 100.';
            $messages[sprintf('%s.percentage.total', $budgetItemForm)] = 'The @percentage field should be 100 when there is only one budget item.';
            $messages = array_merge(
                $messages,
                $this->getBudgetItemDescriptionMessages($budgetItem['description'], $budgetItemForm)
            );
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
            $rules = $this->getRulesForNarrative($description['narrative'], $descriptionForm);
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
    protected function getRulesForPercentage($countryBudget): array
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
