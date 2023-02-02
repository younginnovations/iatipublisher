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
        $data = $this->get('policy_marker');

        $totalRules = [
            $this->getRulesForPolicyMarker($data),
            $this->getCriticalRulesForPolicyMarker($data),
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
        return $this->getMessagesForPolicyMarker($this->get('policy_marker'));
    }

    /**
     * Returns rules for related activity.
     *
     * @param array $formFields
     *
     * @return array
     */
    public function getRulesForPolicyMarker(array $formFields): array
    {
        $rules = [];

        foreach ($formFields as $policyMarkerIndex => $policyMarker) {
            $policyMarkerForm = sprintf('policy_marker.%s', $policyMarkerIndex);

            foreach ($this->getRulesForNarrative($policyMarker['narrative'], $policyMarkerForm) as $policyMarkerNarrativeIndex => $narrativeRules) {
                $rules[$policyMarkerNarrativeIndex] = $narrativeRules;
            }

            if (Arr::get($policyMarker, 'policy_marker_vocabulary') === '99') {
                foreach (array_keys($policyMarker['narrative']) as $narrativeIndex) {
                    $rules[sprintf('%s.narrative.%s.narrative', $policyMarkerForm, $narrativeIndex)] = 'required';
                }
            }
        }

        return $rules;
    }

    /**
     * Returns criticalrules for related activity.
     *
     * @param array $formFields
     *
     * @return array
     */
    public function getCriticalRulesForPolicyMarker(array $formFields): array
    {
        $rules = [];

        foreach ($formFields as $policyMarkerIndex => $policyMarker) {
            $policyMarkerForm = sprintf('policy_marker.%s', $policyMarkerIndex);
            $rules[sprintf('%s.policy_marker_vocabulary', $policyMarkerForm)] = 'nullable|in:' . implode(',', array_keys(getCodeList('PolicyMarkerVocabulary', 'Activity', false)));
            $rules[sprintf('%s.significance', $policyMarkerForm)] = 'nullable|in:' . implode(',', array_keys(getCodeList('PolicySignificance', 'Activity', false)));
            $rules[sprintf('%s.policy_marker', $policyMarkerForm)] = 'nullable|in:' . implode(',', array_keys(getCodeList('PolicyMarker', 'Activity', false)));
            $rules[sprintf('%s.vocabulary_uri', $policyMarkerForm)] = 'nullable|url';

            foreach ($this->getCriticalRulesForNarrative($policyMarker['narrative'], $policyMarkerForm) as $policyMarkerNarrativeIndex => $narrativeRules) {
                $rules[$policyMarkerNarrativeIndex] = $narrativeRules;
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
    public function getMessagesForPolicyMarker(array $formFields): array
    {
        $messages = [];

        foreach ($formFields as $policyMarkerIndex => $policyMarker) {
            $policyMarkerForm = sprintf('policy_marker.%s', $policyMarkerIndex);
            $messages[sprintf('%s.policy_marker_vocabulary.in', $policyMarkerForm)] = 'The policy marker vocabulary is invalid.';
            $messages[sprintf('%s.significance.in', $policyMarkerForm)] = 'The policy marker significance is invalid.';
            $messages[sprintf('%s.policy_marker.in', $policyMarkerForm)] = 'The policy marker code is invalid.';
            $messages[sprintf('%s.vocabulary_uri.url', $policyMarkerForm)]
                = 'The @vocabulary-uri field must be a valid url.';

            if (Arr::get($policyMarker, 'policy_marker_vocabulary') === '99') {
                foreach (array_keys($policyMarker['narrative']) as $narrativeIndex) {
                    $messages[sprintf('%s.narrative.%s.narrative.required', $policyMarkerForm, $narrativeIndex)] = 'The narrative field is required when vocabulary is reporting organisation.';
                }
            }

            foreach ($this->getMessagesForNarrative($policyMarker['narrative'], $policyMarkerForm) as $policyMarkerNarrativeIndex => $narrativeMessages) {
                $messages[$policyMarkerNarrativeIndex] = $narrativeMessages;
            }
        }

        return $messages;
    }
}
