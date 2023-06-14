<?php

declare(strict_types=1);

namespace App\Http\Requests\Activity\HumanitarianScope;

use App\Http\Requests\Activity\ActivityBaseRequest;

/**
 * Class HumanitarianScopeRequest.
 */
class HumanitarianScopeRequest extends ActivityBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $data = $this->get('humanitarian_scope');
        $totalRules = [
            $this->getWarningForHumanitarianScope($data),
            $this->getErrorsForHumanitarianScope($data),
        ];

        return mergeRules($totalRules);
    }

    /**
     * Get the error message as required.
     *
     * @return array
     */
    public function messages(): array
    {
        return $this->getMessagesForHumanitarianScope($this->get('humanitarian_scope'));
    }

    /**
     * Returns rules for related activity.
     *
     * @param array $formFields
     *
     * @return array
     */
    public function getWarningForHumanitarianScope(array $formFields): array
    {
        $rules = [];

        foreach ($formFields as $humanitarianScopeIndex => $humanitarianScope) {
            $humanitarianScopeForm = 'humanitarian_scope.' . $humanitarianScopeIndex;

            foreach ($this->getWarningForNarrative($humanitarianScope['narrative'], $humanitarianScopeForm) as $humanitarianIndex => $narrativeRules) {
                $rules[$humanitarianIndex] = $narrativeRules;
            }
        }

        return $rules;
    }

    /**
     * Returns rules for related activity.
     *
     * @param array $formFields
     *
     * @return array
     */
    public function getErrorsForHumanitarianScope(array $formFields): array
    {
        $rules = [];

        foreach ($formFields as $humanitarianScopeIndex => $humanitarianScope) {
            $humanitarianScopeForm = 'humanitarian_scope.' . $humanitarianScopeIndex;
            $rules[sprintf('%s.type', $humanitarianScopeForm)] = 'nullable|in:' . implode(',', array_keys(getCodeList('HumanitarianScopeType', 'Activity', false)));
            $rules[sprintf('%s.vocabulary', $humanitarianScopeForm)] = 'nullable|in:' . implode(',', array_keys(getCodeList('HumanitarianScopeVocabulary', 'Activity', false)));
            $rules[sprintf('%s.vocabulary_uri', $humanitarianScopeForm)] = 'nullable|url';
            $rules[sprintf('%s.code', $humanitarianScopeForm)] = 'nullable|string';

            foreach ($this->getErrorsForNarrative($humanitarianScope['narrative'], $humanitarianScopeForm) as $humanitarianIndex => $narrativeRules) {
                $rules[$humanitarianIndex] = $narrativeRules;
            }
        }

        return $rules;
    }

    /**
     * Returns messages for related activity validations.
     *
     * @param array $formFields
     *
     * @return array
     */
    public function getMessagesForHumanitarianScope(array $formFields): array
    {
        $messages = [];

        foreach ($formFields as $humanitarianScopeIndex => $humanitarianScope) {
            $humanitarianScopeForm = 'humanitarian_scope.' . $humanitarianScopeIndex;
            $messages[sprintf('%s.type.in', $humanitarianScopeForm)] = trans('requests.humanitarian', ['suffix'=>trans('requests.suffix.type_is_invalid')]);
            $messages[sprintf('%s.vocabulary.in', $humanitarianScopeForm)] = trans('requests.humanitarian', ['suffix'=>trans('requests.suffix.vocabulary_is_invalid')]);
            $messages[sprintf('%s.code.string', $humanitarianScopeForm)] = trans('requests.humanitarian_code', ['suffix'=>trans('requests.suffix.must_be_a_string')]);
            $messages[sprintf('%s.vocabulary_uri.url', $humanitarianScopeForm)] = trans('requests.humanitarian', ['suffix'=>trans('requests.suffix.must_be_valid_vocal_url')]);

            foreach ($this->getMessagesForNarrative($humanitarianScope['narrative'], $humanitarianScopeForm) as $humanitarianIndex => $narrativeMessages) {
                $messages[$humanitarianIndex] = $narrativeMessages;
            }
        }

        return $messages;
    }
}
