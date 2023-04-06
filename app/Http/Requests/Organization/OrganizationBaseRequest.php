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
        parent::__construct();

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
                    return !($parameter[1] < $parameter[0]);
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

        Validator::extend(
            'must_match',
            function () {
                return false;
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
            if (in_array($narrative['language'], $languages, true)) {
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
            $code = $language['code'] ?? ($language['language'] ?? '');

            if (in_array($code, $languageCodes, true)) {
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
     * @param      $parameters
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
                if (in_array('', $languages, true) && in_array($defaultLanguage, $languages, true)) {
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
    public function getWarningForNarrative($formFields, $formBase): array
    {
        $rules = [];
        $rules[sprintf('%s.narrative', $formBase)][] = 'unique_lang';
        $rules[sprintf('%s.narrative', $formBase)][] = 'unique_default_lang';
        $validLanguages = implode(',', array_keys(getCodeList('Language', 'Activity', false)));

        foreach ($formFields as $narrativeIndex => $narrative) {
            $rules[sprintf('%s.narrative.%s.language', $formBase, $narrativeIndex)][] = 'nullable';
            $rules[sprintf('%s.narrative.%s.language', $formBase, $narrativeIndex)][] = sprintf('in:%s', $validLanguages);
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
        $messages[sprintf('%s.narrative.unique_default_lang', $formBase)] = 'The narrative language field must be unique.';

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
    public function getWarningForValue($formFields, $formBase): array
    {
        $rules = [];
        $periodStartFormBase = sprintf('%s.period_start.0.date', $formBase);
        $periodEndFormBase = sprintf('%s.period_end.0.date', $formBase);
        $valueDateRule = sprintf('nullable|date|after_or_equal:%s|before_or_equal:%s', $periodStartFormBase, $periodEndFormBase);

        foreach ($formFields as $valueKey => $valueVal) {
            $valueForm = $formBase . '.value.' . $valueKey;
            $rules[$valueForm . '.amount'] = 'nullable|numeric|min:0';
            $rules[$valueForm . '.currency'] = sprintf('nullable|in:%s', implode(',', array_keys(getCodeList('Currency', 'Activity'))));
            $rules[$valueForm . '.value_date'] = $valueDateRule;
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
            $messages[$valueForm . '.amount.min'] = 'The amount must not be in negative.';
            $messages[$valueForm . '.value_date.required'] = 'The @value-date field is required.';
            $messages[$valueForm . '.value_date.date'] = 'The @value-date must be date.';
            $messages[sprintf('%s.value_date.after_or_equal', $valueForm)] = 'The @value-date field must be a between period start and period end';
            $messages[sprintf('%s.value_date.before_or_equal', $valueForm)] = 'The @value-date field must be a between period start and period end';
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
    public function getWarningForBudgetLine($formFields, $formBase): array
    {
        $rules = [];

        foreach ($formFields as $budgetLineKey => $budgetLineVal) {
            $budgetLineForm = $formBase . '.budget_line.' . $budgetLineKey;
            $valueRules = $this->getWarningForBudgetOrExpenseLineValue($budgetLineVal['value'], $budgetLineForm, $formBase);

            foreach ($valueRules as $key => $valueRule) {
                $rules[$key] = $valueRule;
            }

            $narrativeRules = $this->getWarningForBudgetOrExpenseLineNarrative($budgetLineVal['narrative'], $budgetLineForm);

            foreach ($narrativeRules as $key => $narrativeRule) {
                $rules[$key] = $narrativeRule;
            }
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
            $valueMessages = $this->getMessagesForBudgetOrExpenseLineValue($budgetLineVal['value'], $budgetLineForm);

            foreach ($valueMessages as $key => $valueMessage) {
                $messages[$key] = $valueMessage;
            }

            $narrativeMessages = $this->getMessagesForBudgetOrExpenseLineNarrative($budgetLineVal['narrative'], $budgetLineForm);

            foreach ($narrativeMessages as $key => $narrativeMessage) {
                $messages[$key] = $narrativeMessage;
            }
        }

        return $messages;
    }

    /**
     * returns rules for period start form.
     *
     * @param      $formFields
     * @param      $formBase
     * @param      $diff
     * @param null $time_period
     *
     * @return array
     */
    public function getWarningForPeriodStart($formFields, $formBase, $diff, $time_period = null): array
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
     * @param      $formFields
     * @param      $formBase
     * @param      $diff
     * @param null $time_period
     *
     * @return array
     */
    public function getWarningForPeriodEnd($formFields, $formBase, $diff, $time_period = null): array
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
     * @param $parentFormBase
     *
     * @return array
     */
    public function getWarningForBudgetOrExpenseLineValue($formField, $formBase, $parentFormBase): array
    {
        $rules = [];
        $periodStartFormBase = sprintf('%s.period_start.0.date', $parentFormBase);
        $periodEndFormBase = sprintf('%s.period_end.0.date', $parentFormBase);
        $valueDateRule = sprintf('nullable|date|after_or_equal:%s|before_or_equal:%s', $periodStartFormBase, $periodEndFormBase);

        foreach ($formField as $budgetLineIndex => $budgetLine) {
            $rules[$formBase . '.value.' . $budgetLineIndex . '.amount'] = 'nullable|numeric|min:0';
            $rules[$formBase . '.value.' . $budgetLineIndex . '.currency'] = sprintf('nullable|in:%s', implode(',', array_keys(getCodeList('Currency', 'Activity'))));
            $rules[$formBase . '.value.' . $budgetLineIndex . '.value_date'] = $valueDateRule;
        }

        return $rules;
    }

    /** returns messages for budget line value or expense line value .
     *
     * @param        $formField
     * @param        $formBase
     *
     * @return mixed
     */
    public function getMessagesForBudgetOrExpenseLineValue($formField, $formBase): array
    {
        $messages = [];

        foreach ($formField as $budgetLineIndex => $budgetLine) {
            $messages[sprintf('%s.value.%s.amount.required_with', $formBase, $budgetLineIndex)] = 'The amount field is required with value.';
            $messages[sprintf('%s.value.%s.amount.numeric', $formBase, $budgetLineIndex)] = 'The amount field must be a number.';
            $messages[sprintf('%s.value.%s.amount.min', $formBase, $budgetLineIndex)] = 'The amount field must not be in negative.';
            $messages[sprintf('%s.value.%s.value_date.date', $formBase, $budgetLineIndex)] = 'The @value-date must be a date.';
            $messages[sprintf('%s.value.%s.value_date.required_with', $formBase, $budgetLineIndex)] = 'The @value-date is required with value,.';
            $messages[sprintf('%s.value.%s.value_date.after_or_equal', $formBase, $budgetLineIndex)] = 'The @value-date field must be a between period start and period end';
            $messages[sprintf('%s.value.%s.value_date.before_or_equal', $formBase, $budgetLineIndex)] = 'The @value-date field must be a between period start and period end';
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
    public function getWarningForBudgetOrExpenseLineNarrative($formFields, $formBase): array
    {
        $rules = [];
        $rules[sprintf('%s.narrative', $formBase)] = 'unique_lang';
        $rules[sprintf('%s.narrative', $formBase)] = 'unique_default_lang';
        $validLanguages = implode(',', array_keys(getCodeList('Language', 'Activity', false)));

        foreach ($formFields as $narrativeIndex => $narrative) {
            $rules[sprintf('%s.narrative.%s.language', $formBase, $narrativeIndex)][] = 'nullable';
            $rules[sprintf('%s.narrative.%s.language', $formBase, $narrativeIndex)][] = sprintf('in:%s', $validLanguages);
            $rules[sprintf('%s.narrative.%s.narrative', $formBase, $narrativeIndex)][] = 'required_with_language';
        }

        return $rules;
    }

    /**
     * returns messages for narrative form.
     *
     * @param        $formFields
     * @param        $formBase
     *
     * @return array
     */
    public function getMessagesForBudgetOrExpenseLineNarrative($formFields, $formBase): array
    {
        $messages = [];
        $messages[sprintf('%s.narrative.unique_lang', $formBase)] = 'The narrative language field must be unique.';
        $messages[sprintf('%s.narrative.unique_default_lang', $formBase)] = 'The narrative language field must be unique.';

        foreach ($formFields as $narrativeIndex => $narrative) {
            $messages[sprintf('%s.narrative.%s.narrative.required_with_language', $formBase, $narrativeIndex)] = 'The narrative field is required with language field.';
        }

        return $messages;
    }
}
