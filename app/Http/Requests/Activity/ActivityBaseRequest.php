<?php

declare(strict_types=1);

namespace App\Http\Requests\Activity;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

/**
 * Class ActivityBaseRequest.
 */
class ActivityBaseRequest extends FormRequest
{
    /**
     * ActivityBaseRequest constructor.
     */
    public function __construct()
    {
        Validator::extendImplicit(
            'unique_lang',
            function ($attribute, $value) {
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
        );

        Validator::extendImplicit(
            'sum',
            function ($attribute, $value, $parameters, $validator) {
                return false;
            }
        );

        Validator::extend(
            'total',
            function ($attribute, $value, $parameters, $validator) {
                ($value != 100) ? $check = false : $check = true;

                return $check;
            }
        );
    }

    /**
     * returns rules for narrative if narrative is required.
     *
     * @param      $formFields
     * @param      $formBase
     *
     * @return array
     */
    public function getRulesForRequiredNarrative($formFields, $formBase): array
    {
        $rules = [];
        $rules[sprintf('%s.narrative', $formBase)][] = 'unique_lang';
        $rules[sprintf('%s.narrative', $formBase)][] = 'unique_default_lang';

        foreach ($formFields as $narrativeIndex => $narrative) {
            if (boolval($narrative['language'])) {
                $rules[sprintf('%s.narrative.%s.narrative', $formBase, $narrativeIndex)] = 'required_with:' . sprintf(
                    '%s.narrative.%s.language',
                    $formBase,
                    $narrativeIndex
                );
            } else {
                $rules[sprintf('%s.narrative.%s.narrative', $formBase, $narrativeIndex)] = 'required';
            }
        }

        return $rules;
    }

    /**
     * get message for narrative.
     *
     * @param $formFields
     * @param $formBase
     *
     * @return array
     */
    public function getMessagesForRequiredNarrative($formFields, $formBase): array
    {
        $messages = [];
        $messages[sprintf('%s.narrative.unique_lang', $formBase)] = 'The @xml:lang field must be unique.';

        foreach ($formFields as $narrativeIndex => $narrative) {
            if (boolval($narrative['language'])) {
                $messages[sprintf(
                    '%s.narrative.%s.narrative.required_with',
                    $formBase,
                    $narrativeIndex
                )] = 'The text field is required with @xml:lang field.';
            } else {
                $messages[sprintf(
                    '%s.narrative.%s.narrative.required',
                    $formBase,
                    $narrativeIndex
                )] = 'The text field is required.';
            }
        }

        return $messages;
    }

    /**
     * returns rules for narrative.
     *
     * @param      $formFields
     * @param      $formBase
     *
     * @return array
     */
    public function getRulesForNarrative($formFields, $formBase): array
    {
        $rules = [];
        $rules[sprintf('%s.narrative', $formBase)][] = 'unique_lang';
        $rules[sprintf('%s.narrative', $formBase)][] = 'unique_default_lang';

        foreach ($formFields as $narrativeIndex => $narrative) {
            $rules[sprintf('%s.narrative.%s.narrative', $formBase, $narrativeIndex)][] = 'required_with:' . sprintf(
                '%s.narrative.%s.language',
                $formBase,
                $narrativeIndex
            );
        }

        return $rules;
    }

    /**
     * returns messages for narrative.
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
            $messages[sprintf(
                '%s.narrative.%s.narrative.required_with',
                $formBase,
                $narrativeIndex
            )] = 'The text field is required with @xml:lang field.';
        }

        return $messages;
    }
}
