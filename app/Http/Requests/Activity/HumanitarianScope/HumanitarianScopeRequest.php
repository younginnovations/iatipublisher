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
            $rules[$humanitarianScopeForm . '.vocabulary_uri'] = 'nullable|url';
            $rules[$humanitarianScopeForm . '.code'] = 'nullable|string';

            $rules = array_merge($rules, $this->getRulesForNarrative($humanitarianScope['narrative'], $humanitarianScopeForm));
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
            $messages[$humanitarianScopeForm . '.code.string'] = 'The @code must be a string.';
            $messages[$humanitarianScopeForm . '.vocabulary_uri.url'] = 'The @vocabulary-uri must be a proper url.';
            $messages = array_merge($messages, $this->getMessagesForNarrative($humanitarianScope['narrative'], $humanitarianScopeForm));
        }

        return $messages;
    }
}
