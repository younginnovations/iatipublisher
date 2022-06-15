<?php

declare(strict_types=1);

namespace App\Http\Requests\Activity\PolicyMarker;

use App\Http\Requests\Activity\ActivityBaseRequest;
use Illuminate\Support\Arr;

/**
 * Class PolicyMarkerRequest.
 */
class PolicyMarkerRequest extends ActivityBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return $this->getRulesForPolicyMarker($this->get('policy_marker'));
    }

    /**
     * Get the error message as required.
     *
     * @return array
     */
    public function messages(): array
    {
        return $this->getMessagesForPolicyMarker($this->get('policy_marker'));
    }

    /**
     * Returns rules for related activity.
     * @param array $formFields
     * @return array
     */
    protected function getRulesForPolicyMarker(array $formFields): array
    {
        $rules = [];

        foreach ($formFields as $policyMarkerIndex => $policyMarker) {
            $policyMarkerForm = sprintf('policy_marker.%s', $policyMarkerIndex);
            $rules[sprintf('%s.vocabulary_uri', $policyMarkerForm)] = 'nullable|url';

            if (Arr::get($policyMarker, 'vocabulary') == '99') {
                $rules[sprintf('%s.policy_marker_text', $policyMarkerForm)] = 'required';
                $rules[sprintf('%s.vocabulary_uri', $policyMarkerForm)] = 'url|required';
            } else {
                $rules[sprintf('%s.policy_marker', $policyMarkerForm)] = 'required';
            }

            $rules = array_merge(
                $rules,
                $this->getRulesForNarrative($policyMarker['narrative'], $policyMarkerForm)
            );
        }

        return $rules;
    }

    /**
     * Returns messages for related activity validations.
     * @param array $formFields
     * @return array
     */
    protected function getMessagesForPolicyMarker(array $formFields): array
    {
        $messages = [];

        foreach ($formFields as $policyMarkerIndex => $policyMarker) {
            $policyMarkerForm = sprintf('policy_marker.%s', $policyMarkerIndex);
            $messages[sprintf('%s.vocabulary_uri.url', $policyMarkerForm)]
                = 'The @vocabulary-uri field must be a valid url.';

            if (Arr::get($policyMarker, 'vocabulary') == '99') {
                $messages[sprintf('%s.policy_marker_text.required', $policyMarkerForm)]
                    = 'The @code field is required.';
                $messages[sprintf('%s.vocabulary_uri.required', $policyMarkerForm)]
                    = 'The @vocabulary-uri field is required when @vocabulary is 99.';
            } else {
                $messages[sprintf('%s.policy_marker.required', $policyMarkerForm)] = 'The @code field is required.';
            }

            $messages = array_merge(
                $messages,
                $this->getMessagesForNarrative($policyMarker['narrative'], $policyMarkerForm)
            );
        }

        return $messages;
    }
}
