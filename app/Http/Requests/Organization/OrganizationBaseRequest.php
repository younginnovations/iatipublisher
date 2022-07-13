<?php

namespace App\Http\Requests\Organization;

use Illuminate\Foundation\Http\FormRequest;
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
            function ($attribute, $value, $parameters, $validator) {
                $languages = [];
                foreach ($value as $narrative) {
                    $language = $narrative['language'];
                    if (in_array($language, $languages)) {
                        return false;
                    }
                    $languages[] = $language;
                }

                return true;
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
            function ($attribute, $value, $parameters, $validator) {
                $language = preg_replace('/([^~]+).narrative/', '$1.language', $attribute);

                // return !(Request::get($language) && !Request::get($attribute));
                return true;
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
        // dd($attribute, $value);

        foreach ($value as $category) {
            $code = $category['code'];

            if (in_array($code, $categoryCodes)) {
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
        $defaultLanguage = 'en';

        $validator->addReplacer(
            'unique_default_lang',
            function ($message) use ($validator, $defaultLanguage) {
                return str_replace(':language', getCodeListArray('Languages', 'ActivityArray')[$defaultLanguage], $message);
            }
        );

        $check = true;

        foreach ($value as $narrative) {
            $languages[] = $narrative['language'];
        }

        if (count($languages) === count(array_unique($languages))) {
            if (in_array('', $languages) && in_array($defaultLanguage, $languages)) {
                $check = false;
            }
        }

        return $check;
    }

    /**
     * returns rules for narrative form.
     * @param $formFields
     * @param $formBase
     * @return array
     */
    public function getRulesForNarrative($formFields, $formBase, $required = null)
    {
        $rules = [];
        $rules[sprintf('%s.narrative', $formBase)][] = 'unique_lang';
        $rules[sprintf('%s.narrative', $formBase)][] = 'unique_default_lang';
        // foreach ($formFields as $narrativeIndex => $narrative) {
        //     $rules[sprintf('%s.narrative.%s.narrative', $formBase, $narrativeIndex)][] = 'required_with_language';
        //     if ($required) {
        //         $rules[sprintf('%s.narrative.%s.narrative', $formBase, $narrativeIndex)][] = 'required';
        //     }
        // }

        return $rules;
    }

    /**
     * returns messages for narrative form.
     * @param $formFields
     * @param $formBase
     * @return array
     */
    public function getMessagesForNarrative($formFields, $formBase)
    {
        $messages = [];
        $messages[sprintf('%s.narrative.unique_lang', $formBase)] = trans('validation.unique', ['attribute' => trans('elementForm.languages')]);
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
     * @param $formFields
     * @param $formBase
     * @return array
     */
    public function getRulesForValue($formFields, $formBase)
    {
        $rules = [];
        foreach ($formFields as $valueKey => $valueVal) {
            $valueForm = $formBase . '.value.' . $valueKey;
            // $rules[$valueForm . '.amount'] = sprintf('required|numeric');
            // $rules[$valueForm . '.value_date'] = sprintf('required|date');
            $rules[$valueForm . '.amount'] = sprintf('nullable|numeric');
            $rules[$valueForm . '.value_date'] = sprintf('nullable|date');
        }

        return $rules;
    }

    /**
     * returns messages for value form.
     * @param $formFields
     * @param $formBase
     * @return array
     */
    public function getMessagesForValue($formFields, $formBase)
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
     * @param $formFields
     * @param $formBase
     * @return array
     */
    public function getRulesForBudgetLine($formFields, $formBase)
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
     * @param $formFields
     * @param $formBase
     * @return array
     */
    public function getMessagesBudgetLine($formFields, $formBase)
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
     * @param $formFields
     * @param $formBase
     * @return array
     */
    public function getRulesForPeriodStart($formFields, $formBase, $diff, $time_period = null)
    {
        $rules = [];
        foreach ($formFields as $periodStartKey => $periodStartVal) {
            $rules[$formBase . '.period_start.' . $periodStartKey . '.date'] = 'nullable|date|period_start_end:' . $diff . ',' . $time_period;
            // $rules[$formBase . '.period_start.' . $periodStartKey . '.date'] = 'required|date';
        }

        return $rules;
    }

    /**
     * returns messages for period start form.
     * @param $formFields
     * @param $formBase
     * @return array
     */
    public function getMessagesForPeriodStart($formFields, $formBase)
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
     * @param $formFields
     * @param $formBase
     * @return array
     */
    public function getRulesForPeriodEnd($formFields, $formBase, $diff, $time_period = null)
    {
        $rules = [];
        foreach ($formFields as $periodEndKey => $periodEndVal) {
            // $rules[$formBase . '.period_end.' . $periodEndKey . '.date'] = sprintf('required|date|after:%s', $formBase . '.period_start.' . $periodEndKey . '.date');
            $rules[$formBase . '.period_end.' . $periodEndKey . '.date'] = sprintf('nullable|date|after:%s', $formBase . '.period_start.' . $periodEndKey . '.date|period_start_end:' . $diff . ',' . $time_period);
        }

        return $rules;
    }

    /**
     * returns messages for period end form.
     * @param $formFields
     * @param $formBase
     * @return array
     */
    public function getMessagesForPeriodEnd($formFields, $formBase)
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
     * @param $formField
     * @param $formBase
     * @return mixed
     */
    public function getRulesForBudgetOrExpenseLineValue($formField, $formBase)
    {
        $rules = [];

        // foreach ($formField as $budgetLineIndex => $budgetLine) {
        // $rules[$formBase . '.value.' . $budgetLineIndex . '.amount'] = sprintf(
        //     'required_with:%s,%s,%s|nullable|numeric',
        //     $formBase . '.value.' . $budgetLineIndex . '.value_date',
        //     $formBase . '.reference',
        //     $formBase . '.narrative.0.narrative'
        // );
        // $rules[$formBase . '.value.' . $budgetLineIndex . '.value_date'] = sprintf(
        //     'required_with:%s,%s,%s|nullable|date',
        //     $formBase . '.value.' . $budgetLineIndex . '.amount',
        //     $formBase . '.reference',
        //     $formBase . '.narrative.0.narrative'
        // );
        // }
        foreach ($formField as $budgetLineIndex => $budgetLine) {
            $rules[$formBase . '.value.' . $budgetLineIndex . '.amount'] = 'nullable|numeric';
            $rules[$formBase . '.value.' . $budgetLineIndex . '.value_date'] = 'nullable|date';
        }

        return $rules;
    }

    /** returns messages for budget line value or expense line value .
     * @param        $formField
     * @param        $formBase
     * @param string $type
     * @return mixed
     */
    public function getMessagesForBudgetOrExpenseLineValue($formField, $formBase, $type = 'Budget line')
    {
        foreach ($formField as $budgetLineIndex => $budgetLine) {
            $messages[$formBase . '.value.' . $budgetLineIndex . '.amount' . '.required_with'] = 'The amount field is required with value.';
            $messages[$formBase . '.value.' . $budgetLineIndex . '.amount' . '.numeric'] = 'The amount field must be a number.';
            $messages[$formBase . '.value.' . $budgetLineIndex . '.value_date' . '.date'] = 'The @value-date must be a date.';
            $messages[$formBase . '.value.' . $budgetLineIndex . '.value_date' . '.required_with'] = 'The @value-date is required with value,.';
        }

        return $messages;
    }

    /** returns rules for narrative form.
     * @param $formFields
     * @param $formBase
     * @return array
     */
    public function getRulesForBudgetOrExpenseLineNarrative($formFields, $formBase)
    {
        $rules = [];
        $rules[sprintf('%s.narrative', $formBase)] = 'unique_lang';
        // foreach ($formFields as $narrativeIndex => $narrative) {
        //     $rules[sprintf('%s.narrative.%s.narrative', $formBase, $narrativeIndex)] = sprintf(
        //         'required_with:%s,%s,%s',
        //         $formBase . '.value.0' . '.amount',
        //         $formBase . '.value.0' . '.value_date',
        //         $formBase . '.reference'
        //     );
        // }

        return $rules;
    }

    /**
     * returns messages for narrative form.
     * @param        $formFields
     * @param        $formBase
     * @param string $type
     * @return array
     */
    public function getMessagesForBudgetOrExpenseLineNarrative($formFields, $formBase, $type = 'Budget line')
    {
        $messages = [];
        $messages[sprintf('%s.narrative.unique_lang', $formBase)] = trans('validation.unique', ['attribute' => trans('elementForm.languages')]);

        foreach ($formFields as $narrativeIndex => $narrative) {
            $messages[sprintf('%s.narrative.%s.narrative.required_with', $formBase, $narrativeIndex)] = trans('validation.required', ['attribute' => trans('elementForm.narrative')]);
        }

        return $messages;
    }
}
