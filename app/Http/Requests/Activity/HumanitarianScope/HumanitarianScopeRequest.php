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
        return $this->getRulesForHumanitarianScope($this->get('humanitarian_scope'));
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
    public function getRulesForHumanitarianScope(array $formFields): array
    {
        $rules = [];

        foreach ($formFields as $humanitarianScopeIndex => $humanitarianScope) {
            $humanitarianScopeForm = 'humanitarian_scope.' . $humanitarianScopeIndex;
            $rules[sprintf('%s.type', $humanitarianScopeForm)] = 'nullable|in:' . implode(',', array_keys(getCodeList('HumanitarianScopeType', 'Activity', false)));
            $rules[sprintf('%s.vocabulary', $humanitarianScopeForm)] = 'nullable|in:' . implode(',', array_keys(getCodeList('HumanitarianScopeVocabulary', 'Activity', false)));
            $rules[sprintf('%s.vocabulary_uri', $humanitarianScopeForm)] = 'nullable|url';
            $rules[sprintf('%s.code', $humanitarianScopeForm)] = 'nullable|string';

            foreach ($this->getRulesForNarrative($humanitarianScope['narrative'], $humanitarianScopeForm) as $humanitarianIndex => $narrativeRules) {
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
            $messages[sprintf('%s.type.in', $humanitarianScopeForm)] = 'The humanitarian scope type is invalid.';
            $messages[sprintf('%s.vocabulary.in', $humanitarianScopeForm)] = 'The humanitarian scope vocabulary is invalid.';
            $messages[sprintf('%s.code.string', $humanitarianScopeForm)] = 'The humanitarian scope code must be a string.';
            $messages[sprintf('%s.vocabulary_uri.url', $humanitarianScopeForm)] = 'The humanitarian scope vocabulary-uri must be a proper url.';

            foreach ($this->getMessagesForNarrative($humanitarianScope['narrative'], $humanitarianScopeForm) as $humanitarianIndex => $narrativeMessages) {
                $messages[$humanitarianIndex] = $narrativeMessages;
            }
        }

        return $messages;
    }
}
