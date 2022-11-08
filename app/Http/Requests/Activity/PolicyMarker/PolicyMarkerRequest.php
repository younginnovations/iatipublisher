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
     *
     * @param array $formFields
     *
     * @return array
     */
    protected function getRulesForPolicyMarker(array $formFields): array
    {
        $rules = [];

        foreach ($formFields as $policyMarkerIndex => $policyMarker) {
            $policyMarkerForm = sprintf('policy_marker.%s', $policyMarkerIndex);
            $rules[sprintf('%s.vocabulary_uri', $policyMarkerForm)] = 'nullable|url';

            if (Arr::get($policyMarker, 'policy_marker_vocabulary') === '99') {
                foreach ($policyMarker['narrative'] as $narrativeIndex => $narrative) {
                    $rules[sprintf('%s.narrative.%s.narrative', $policyMarkerForm, $narrativeIndex)] = 'required';
                }
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
    protected function getMessagesForPolicyMarker(array $formFields): array
    {
        $messages = [];

        foreach ($formFields as $policyMarkerIndex => $policyMarker) {
            $policyMarkerForm = sprintf('policy_marker.%s', $policyMarkerIndex);
            $messages[sprintf('%s.vocabulary_uri.url', $policyMarkerForm)]
                = 'The @vocabulary-uri field must be a valid url.';

            if (Arr::get($policyMarker, 'policy_marker_vocabulary') === '99') {
                foreach ($policyMarker['narrative'] as $narrativeIndex => $narrative) {
                    $messages[sprintf('%s.narrative.%s.narrative.required', $policyMarkerForm, $narrativeIndex)] = 'The narrative field is required when vocabulary is reporting organisation.';
                }
            }

            $messages = array_merge(
                $messages,
                $this->getMessagesForNarrative($policyMarker['narrative'], $policyMarkerForm)
            );
        }

        return $messages;
    }
}
