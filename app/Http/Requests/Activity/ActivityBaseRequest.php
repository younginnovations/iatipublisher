<?php

declare(strict_types=1);

namespace App\Http\Requests\Activity;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
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

        Validator::extend(
            'exclude_operators',
            function ($attribute, $value, $parameters, $validator) {
                if ($value) {
                    return !preg_match('/[\&\|\?|]+/', $value);
                }

                return true;
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
                // $rules[sprintf('%s.narrative.%s.narrative', $formBase, $narrativeIndex)] = 'required_with:' . sprintf(
                //     '%s.narrative.%s.language',
                //     $formBase,
                //     $narrativeIndex
                // );
            } else {
                // $rules[sprintf('%s.narrative.%s.narrative', $formBase, $narrativeIndex)] = 'required';
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

//        foreach ($formFields as $narrativeIndex => $narrative) {
//            if (boolval($narrative['language'])) {
//                $messages[sprintf(
//                    '%s.narrative.%s.narrative.required_with',
//                    $formBase,
//                    $narrativeIndex
//                )] = 'The text field is required with @xml:lang field.';
//            } else {
//                $messages[sprintf(
//                    '%s.narrative.%s.narrative.required',
//                    $formBase,
//                    $narrativeIndex
//                )] = 'The text field is required.';
//            }
//        }

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

//        foreach ($formFields as $narrativeIndex => $narrative) {
//            $rules[sprintf('%s.narrative.%s.narrative', $formBase, $narrativeIndex)][] = 'required_with:' . sprintf(
//                '%s.narrative.%s.language',
//                $formBase,
//                $narrativeIndex
//            );
//        }

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
            )] = 'The narrative field is required with @xml:lang field.';
        }

        return $messages;
    }

    /**
     * returns rules for period start form.
     * @param $formFields
     * @param $formBase
     * @return array
     */
    public function getRulesForPeriodStart($formFields, $formBase)
    {
        $rules = [];
        foreach ($formFields as $periodStartKey => $periodStartVal) {
            $rules[$formBase . '.period_start.' . $periodStartKey . '.date'] = 'date';
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
            $messages[$formBase . '.period_start.' . $periodStartKey . '.date.required'] = trans('validation.required', ['attribute' => trans('elementForm.period_start')]);
            $messages[$formBase . '.period_end.' . $periodStartKey . '.date.date'] = 'Period end must be a date.';
        }

        return $messages;
    }

    /**
     * returns rules for period end form.
     * @param $formFields
     * @param $formBase
     * @return array
     */
    public function getRulesForPeriodEnd($formFields, $formBase)
    {
        $rules = [];

        foreach ($formFields as $periodEndKey => $periodEndVal) {
            // $rules[$formBase . '.period_end.' . $periodEndKey . '.date'][] = 'required';
            $rules[$formBase . '.period_end.' . $periodEndKey . '.date'][] = 'date';
            $rules[$formBase . '.period_end.' . $periodEndKey . '.date'][] = sprintf(
                'after:%s',
                $formBase . '.period_start.' . $periodEndKey . '.date'
            );
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
            $messages[$formBase . '.period_end.' . $periodEndKey . '.date.required'] = 'Period end is a required field';
            $messages[$formBase . '.period_end.' . $periodEndKey . '.date.date'] = 'Period end must be a date field';
            $messages[$formBase . '.period_end.' . $periodEndKey . '.date.after'] = 'Period end must be a date after period';
        }

        return $messages;
    }

    /**
     * returns rules for Document Link.
     *
     * @param $formFields
     * @param $formBase
     *
     * @return array
     */
    public function getRulesForDocumentLink($formFields, $formBase = null): array
    {
        $rules = [];

        foreach ($formFields as $documentLinkIndex => $documentLink) {
            if ($formBase) {
                $documentLinkForm = sprintf('%s.document_link.%s', $formBase, $documentLinkIndex);
            } else {
                $documentLinkForm = sprintf('document_link.%s', $documentLinkIndex);
            }

            if (Arr::get($documentLink, 'url', null) != '') {
                $rules[sprintf('%s.url', $documentLinkForm)] = 'nullable|url';
            }

            if (Arr::get($documentLink, 'document_date', null) != '') {
                $rules = array_merge(
                    $rules,
                    $this->getRulesForDocumentDate($documentLink['document_date'], $documentLinkForm),
                );
            }

            $rules = array_merge(
                $rules,
                $this->getRulesForNarrative(
                    $documentLink['title'][0]['narrative'],
                    sprintf('%s.title.0', $documentLinkForm)
                ),
                $this->getRulesForNarrative(
                    $documentLink['description'][0]['narrative'],
                    sprintf('%s.description.0', $documentLinkForm)
                ),
            );
        }

        return $rules;
    }

    /**
     * returns rules for document date.
     *
     * @param $formFields
     * @param $formIndex
     *
     * @return array
     */
    protected function getRulesForDocumentDate($formFields, $formIndex): array
    {
        $rules = [];

        foreach ($formFields as $documentCategoryIndex => $documentCategory) {
            $rules[sprintf('%s.document_date.%s.date', $formIndex, $documentCategoryIndex)] = 'nullable|date';
        }

        return $rules;
    }

    /**
     * returns messages for Document Link.
     *
     * @param $formFields
     * @param $formBase
     *
     * @return array
     */
    public function getMessagesForDocumentLink($formFields, $formBase = null): array
    {
        $messages = [];

        foreach ($formFields as $documentLinkIndex => $documentLink) {
            if ($formBase) {
                $documentLinkForm = sprintf('%s.document_link.%s', $formBase, $documentLinkIndex);
            } else {
                $documentLinkForm = sprintf('document_link.%s', $documentLinkIndex);
            }

            if (Arr::get($documentLink, 'url', null) != '') {
                $messages[sprintf('%s.url.url', $documentLinkForm)] = 'The @url field must be a valid url.';
            }

            if (Arr::get($documentLink, 'document_date', null) != '') {
                $messages = array_merge(
                    $messages,
                    $this->getMessagesForDocumentDate($documentLink['document_date'], $documentLinkForm)
                );
            }

            $messages = array_merge(
                $messages,
                $this->getMessagesForNarrative(
                    $documentLink['title'][0]['narrative'],
                    sprintf('%s.title.0', $documentLinkForm)
                ),
                $this->getMessagesForNarrative(
                    $documentLink['description'][0]['narrative'],
                    sprintf('%s.description.0', $documentLinkForm)
                ),
            );
        }

        return $messages;
    }

    /**
     * returns messages for document date.
     *
     * @param $formFields
     * @param $formIndex
     *
     * @return array
     */
    protected function getMessagesForDocumentDate($formFields, $formIndex): array
    {
        $messages = [];

        foreach ($formFields as $documentCategoryIndex => $documentCategory) {
            $messages[sprintf('%s.document_date.%s.date.date', $formIndex, $documentCategoryIndex)]
                = 'The @iso-date field must be a proper date.';
        }

        return $messages;
    }
}
