<?php

declare(strict_types=1);

namespace App\Http\Requests\Activity\CountryBudgetItem;

use App\Http\Requests\Activity\ActivityBaseRequest;
use Illuminate\Support\Arr;

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
     * @param array $formFields
     * @return array
     */
    protected function getRulesForCountryBudgetItem(array $formFields): array
    {
        $rules = [];

        $rules['vocabulary'] = 'required';
        $code = $formFields['vocabulary'] == 1 ? 'code' : 'code_text';
        $rules = array_merge(
            $rules,
            $this->getBudgetItemRules($formFields['budget_item'], $code)
        );

        return $rules;
    }

    /**
     * Returns messages for related activity validations.
     * @param array $formFields
     * @return array
     */
    protected function getMessagesForCountryBudgetItem(array $formFields): array
    {
        $messages = [];

        $code = $formFields['vocabulary'] == 1 ? 'code' : 'code_text';
        $messages[sprintf('vocabulary.required')] = 'The @vocabulary field is required.';
        $messages = array_merge(
            $messages,
            $this->getBudgetItemMessages($formFields['budget_item'], $code)
        );

        return $messages;
    }

    /**
     * returns budget item validation rules.
     * @param $formFields
     * @param $code
     * @return array
     */
    public function getBudgetItemRules(array $formFields, $code)
    {
        $rules = [];

        foreach ($formFields as $budgetItemIndex => $budgetItem) {
            $budgetItemForm = sprintf('budget_item.%s', $budgetItemIndex);
            $rules[sprintf('%s.percentage', $budgetItemForm)] = 'numeric|max:100';
            $rules[sprintf('%s.%s', $budgetItemForm, $code)] = 'required';
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
     * @param $formFields
     * @param $code
     * @return array
     */
    public function getBudgetItemMessages(array $formFields, $code)
    {
        $messages = [];
        foreach ($formFields as $budgetItemIndex => $budgetItem) {
            $budgetItemForm = sprintf('budget_item.%s', $budgetItemIndex);
            $messages[sprintf('%s.%s.required', $budgetItemForm, $code)] = 'The @code field is required.';
            $messages[sprintf('%s.percentage.%s', $budgetItemForm, 'numeric')] = 'The @percentage field must be a number.';
            $messages[sprintf('%s.percentage.%s', $budgetItemForm, 'max')] = 'The @percentage field cannot be greater than 100.';
            $messages[sprintf('%s.percentage.sum', $budgetItemForm)] = 'The sum of @percentage within a vocabulary must add up to 100.';
            $messages[sprintf('%s.percentage.required', $budgetItemForm)] = 'The @percentage field is required when there are multiple codes.';
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
     * @param $formFields
     * @param $formBase
     * @return array
     */
    public function getBudgetItemDescriptionRules(array $formFields, $formBase)
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
     * @param $formFields
     * @param $formBase
     * @return array
     */
    public function getBudgetItemDescriptionMessages(array $formFields, $formBase)
    {
        $messages = [];

        foreach ($formFields as $descriptionIndex => $description) {
            $descriptionForm = sprintf('%s.description.%s', $formBase, $descriptionIndex);
            $messages = $this->getMessagesForNarrative($description['narrative'], $descriptionForm);
        }

        return $messages;
    }

    /** Returns rules for percentage.
     * @param $countryBudget
     * @return array
     */
    protected function getRulesForPercentage($countryBudget)
    {
        $countryBudgetItems = Arr::get($countryBudget, 'budget_item', []);
        $totalPercentage = 0;
        $isEmpty = false;
        $countryBudgetPercentage = 0;
        $rules = [];

        if (count($countryBudgetItems) > 1) {
            foreach ($countryBudgetItems as $key => $countryBudgetItem) {
                (!empty($countryBudgetItem['percentage'])) ? $countryBudgetPercentage = $countryBudgetItem['percentage'] : $isEmpty = true;
                $totalPercentage = $totalPercentage + $countryBudgetPercentage;
            }

            foreach ($countryBudgetItems as $key => $countryBudgetItem) {
                if ($isEmpty) {
                    $rules["budget_item.$key.percentage"] = 'required';
                } elseif ($totalPercentage != 100) {
                    $rules["budget_item.$key.percentage"] = 'sum';
                }
            }
        } else {
            $rules['budget_item.0.percentage'] = 'total';
        }

        return $rules;
    }
}
