<?php

declare(strict_types=1);

namespace App\Http\Requests\Organization;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

/**
 * Class OrganizationBaseRequest.
 */
class OrganizationBaseRequest extends FormRequest
{
    public function __construct()
    {
        Validator::extendImplicit(
            'unique_lang',
            function ($attribute, $value) {
                return $this->uniqueLangValidator($attribute, $value);
            }
        );

        Validator::extendImplicit(
            'unique_default_lang',
            function ($attribute, $value, $parameters, $validator) {
                return $this->uniqueDefaultLangValidator($attribute, $value, $parameters, $validator);
            }
        );

        Validator::extendImplicit(
            'required_with_language',
            function ($attribute) {
                $language = preg_replace('/([^~]+).narrative/', '$1.language', $attribute);
                $request = FormRequest::all();

                return !(Arr::get($request, $language) && !Arr::get($request, $attribute));
            }
        );

        Validator::extendImplicit(
            'period_start_end',
            function ($attribute, $value, $parameter, $validator) {
                if ($parameter[1]) {
                    return $parameter[1] < $parameter[0] ? false : true;
                }

                return true;
            }
        );

        Validator::extendImplicit(
            'unique_category',
            function ($attribute, $value) {
                return $this->uniqueCategoryValidator($attribute, $value);
            }
        );

        Validator::extendImplicit(
            'unique_language',
            function ($attribute, $value) {
                return $this->uniqueLanguageValidator($attribute, $value);
            }
        );
    }

    /**
     * Validator for unique lang.
     *
     * @param      $attribute
     * @param      $value
     *
     * @return bool
     */
    public function uniqueLangValidator($attribute, $value): bool
    {
        $languages = [];

        foreach ($value as $narrative) {
            if (in_array($narrative['language'], $languages)) {
                return false;
            }

            $languages[] = $narrative['language'];
        }

        return true;
    }

    /**
     * Validator for unique language/code.
     *
     * @param      $attribute
     * @param      $value
     *
     * @return bool
     */
    public function uniqueLanguageValidator($attribute, $value): bool
    {
        $languageCodes = [];

        foreach ($value as $language) {
            $code = isset($language['code']) ? $language['code'] : ($language['language'] ?? '');

            if (in_array($code, $languageCodes)) {
                return false;
            }

            $languageCodes[] = $code;
        }

        return true;
    }

    /**
     * Validator for category.
     *
     * @param      $attribute
     * @param      $value
     *
     * @return bool
     */
    public function uniqueCategoryValidator($attribute, $value): bool
    {
        $categoryCodes = [];

        foreach ($value as $category) {
            $code = $category['code'];

            if (in_array($code, $categoryCodes, true)) {
                return false;
            }

            $categoryCodes[] = $code;
        }

        return true;
    }

    /**
     * Validator for unique lang.
     *
     * @param      $attribute
     * @param      $value
     * @param      $parameter
     * @param      $validator
     *
     * @return bool
     */
    public function uniqueDefaultLangValidator($attribute, $value, $parameters, $validator): bool
    {
        $languages = [];
        $defaultLanguage = Auth::user()->organization->settings->default_values['default_language'] ?? null;

        $validator->addReplacer(
            'unique_default_lang',
            function ($message) use ($validator, $defaultLanguage) {
                return 'The @xml:lang must be unique';
            }
        );

        $check = true;

        if ($defaultLanguage) {
            foreach ($value as $narrative) {
                $languages[] = $narrative['language'];
            }

            if (count($languages) === count(array_unique($languages))) {
                if (in_array('', $languages) && in_array($defaultLanguage, $languages)) {
                    $check = false;
                }
            }
        }

        return $check;
    }

    /**
     * returns rules for narrative form.
     *
     * @param $formFields
     * @param $formBase
     *
     * @return array
     */
    public function getRulesForNarrative($formFields, $formBase, $required = null): array
    {
        $rules = [];
        $rules[sprintf('%s.narrative', $formBase)][] = 'unique_lang';
        $rules[sprintf('%s.narrative', $formBase)][] = 'unique_default_lang';

        foreach ($formFields as $narrativeIndex => $narrative) {
            $rules[sprintf('%s.narrative.%s.narrative', $formBase, $narrativeIndex)][] = 'required_with_language';
        }

        return $rules;
    }

    /**
     * returns messages for narrative form.
     *
     * @param $formFields
     * @param $formBase
     *
     * @return array
     */
    public function getMessagesForNarrative($formFields, $formBase): array
    {
        $messages = [];
        $messages[sprintf('%s.narrative.unique_lang', $formBase)] = 'The @xml:lang field must be unique.';

        foreach ($formFields as $narrativeIndex => $narrative) {
            $messages[sprintf('%s.narrative.%s.narrative.required', $formBase, $narrativeIndex)] = 'The narrative field is required.';
            $messages[sprintf(
                '%s.narrative.%s.narrative.required_with_language',
                $formBase,
                $narrativeIndex
            )] = 'The language field is required when narrative field is present.';
        }

        return $messages;
    }

    /**
     * returns rules for value form.
     *
     * @param $formFields
     * @param $formBase
     *
     * @return array
     */
    public function getRulesForValue($formFields, $formBase): array
    {
        $rules = [];

        foreach ($formFields as $valueKey => $valueVal) {
            $valueForm = $formBase . '.value.' . $valueKey;
            $rules[$valueForm . '.amount'] = sprintf('nullable|numeric');
            $rules[$valueForm . '.value_date'] = sprintf('nullable|date');
        }

        return $rules;
    }

    /**
     * returns messages for value form.
     *
     * @param $formFields
     * @param $formBase
     *
     * @return array
     */
    public function getMessagesForValue($formFields, $formBase): array
    {
        $messages = [];

        foreach ($formFields as $valueKey => $valueVal) {
            $valueForm = $formBase . '.value.' . $valueKey;
            $messages[$valueForm . '.amount.required'] = 'The amount field is required.';
            $messages[$valueForm . '.amount.numeric'] = 'The amount must be numeric.';
            $messages[$valueForm . '.value_date.required'] = 'The @value-date field is required.';
            $messages[$valueForm . '.value_date.date'] = 'The @value-date must be date.';
        }

        return $messages;
    }

    /**
     * returns rules for budget line form.
     *
     * @param $formFields
     * @param $formBase
     *
     * @return array
     */
    public function getRulesForBudgetLine($formFields, $formBase): array
    {
        $rules = [];

        foreach ($formFields as $budgetLineKey => $budgetLineVal) {
            $budgetLineForm = $formBase . '.budget_line.' . $budgetLineKey;
            $rules = array_merge(
                $rules,
                $this->getRulesForBudgetOrExpenseLineValue($budgetLineVal['value'], $budgetLineForm),
                $this->getRulesForBudgetOrExpenseLineNarrative($budgetLineVal['narrative'], $budgetLineForm)
            );
        }

        return $rules;
    }

    /**
     * returns messages for budget line form.
     *
     * @param $formFields
     * @param $formBase
     *
     * @return array
     */
    public function getMessagesBudgetLine($formFields, $formBase): array
    {
        $messages = [];

        foreach ($formFields as $budgetLineKey => $budgetLineVal) {
            $budgetLineForm = $formBase . '.budget_line.' . $budgetLineKey;
            $messages = array_merge(
                $messages,
                $this->getMessagesForBudgetOrExpenseLineValue($budgetLineVal['value'], $budgetLineForm),
                $this->getMessagesForBudgetOrExpenseLineNarrative($budgetLineVal['narrative'], $budgetLineForm)
            );
        }

        return $messages;
    }

    /**
     * returns rules for period start form.
     *
     * @param $formFields
     * @param $formBase
     *
     * @return array
     */
    public function getRulesForPeriodStart($formFields, $formBase, $diff, $time_period = null): array
    {
        $rules = [];

        foreach ($formFields as $periodStartKey => $periodStartVal) {
            $rules[$formBase . '.period_start.' . $periodStartKey . '.date'] = 'nullable|date|period_start_end:' . $diff . ',' . $time_period;
        }

        return $rules;
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
            $messages[$formBase . '.period_start.' . $periodStartKey . '.date.required'] = 'The @iso-date field is required.';
            $messages[$formBase . '.period_end.' . $periodStartKey . '.date.date'] = 'The @iso-date field must be a date.';
            $messages[$formBase . '.period_start.' . $periodStartKey . '.date.period_start_end'] = 'The period must not be longer than one year.';
        }

        return $messages;
    }

    /**
     * returns rules for period end form.
     *
     * @param $formFields
     * @param $formBase
     *
     * @return array
     */
    public function getRulesForPeriodEnd($formFields, $formBase, $diff, $time_period = null): array
    {
        $rules = [];

        foreach ($formFields as $periodEndKey => $periodEndVal) {
            $rules[$formBase . '.period_end.' . $periodEndKey . '.date'] = sprintf('nullable|date|after:%s', $formBase . '.period_start.' . $periodEndKey . '.date|period_start_end:' . $diff . ',' . $time_period);
        }

        return $rules;
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
            $messages[$formBase . '.period_end.' . $periodEndKey . '.date.required'] = 'The @iso-date field is required.';
            $messages[$formBase . '.period_end.' . $periodEndKey . '.date.date'] = 'The @iso-date field must be a date.';
            $messages[$formBase . '.period_end.' . $periodEndKey . '.date.after'] = 'The @iso-date field must be a date after period-start date.';
            $messages[$formBase . '.period_end.' . $periodEndKey . '.date.period_start_end'] = 'The period must not be longer than one year.';
        }

        return $messages;
    }

    /** returns rules for budget line value or expense line value.
     *
     * @param $formField
     * @param $formBase
     *
     * @return array
     */
    public function getRulesForBudgetOrExpenseLineValue($formField, $formBase): array
    {
        $rules = [];

        foreach ($formField as $budgetLineIndex => $budgetLine) {
            $rules[$formBase . '.value.' . $budgetLineIndex . '.amount'] = 'nullable|numeric';
            $rules[$formBase . '.value.' . $budgetLineIndex . '.value_date'] = 'nullable|date';
        }

        return $rules;
    }

    /** returns messages for budget line value or expense line value .
     *
     * @param        $formField
     * @param        $formBase
     * @param string $type
     *
     * @return mixed
     */
    public function getMessagesForBudgetOrExpenseLineValue($formField, $formBase, $type = 'Budget line'): array
    {
        $messages = [];

        foreach ($formField as $budgetLineIndex => $budgetLine) {
            $messages[sprintf('%s.value.%s.amount.required_with', $formBase, $budgetLineIndex)] = 'The amount field is required with value.';
            $messages[sprintf('%s.value.%s.amount.numeric', $formBase, $budgetLineIndex)] = 'The amount field must be a number.';
            $messages[sprintf('%s.value.%s.value_date.date', $formBase, $budgetLineIndex)] = 'The @value-date must be a date.';
            $messages[sprintf('%s.value.%s.value_date.required_with', $formBase, $budgetLineIndex)] = 'The @value-date is required with value,.';
        }

        return $messages;
    }

    /** returns rules for narrative form.
     *
     * @param $formFields
     * @param $formBase
     *
     * @return array
     */
    public function getRulesForBudgetOrExpenseLineNarrative($formFields, $formBase): array
    {
        $rules = [];
        $rules[sprintf('%s.narrative', $formBase)] = 'unique_lang';
        $rules[sprintf('%s.narrative', $formBase)] = 'unique_default_lang';

        return $rules;
    }

    /**
     * returns messages for narrative form.
     *
     * @param        $formFields
     * @param        $formBase
     * @param string $type
     *
     * @return array
     */
    public function getMessagesForBudgetOrExpenseLineNarrative($formFields, $formBase, $type = 'Budget line'): array
    {
        $messages = [];
        $messages[sprintf('%s.narrative.unique_lang', $formBase)] = trans('validation.unique', ['attribute' => trans('elementForm.languages')]);
        $messages[sprintf('%s.narrative.unique_default_lang', $formBase)] = trans('validation.unique', ['attribute' => trans('elementForm.languages')]);

        foreach ($formFields as $narrativeIndex => $narrative) {
            $messages[sprintf('%s.narrative.%s.narrative.required_with', $formBase, $narrativeIndex)] = trans('validation.required', ['attribute' => trans('elementForm.narrative')]);
        }

        return $messages;
    }
}
