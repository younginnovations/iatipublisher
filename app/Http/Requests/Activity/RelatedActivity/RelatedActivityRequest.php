<?php

declare(strict_types=1);

namespace App\Http\Requests\Activity\RelatedActivity;

use App\Http\Requests\Activity\ActivityBaseRequest;

/**
 * Class RelatedActivityRequest.
 */
class RelatedActivityRequest extends ActivityBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return $this->getRulesForRelatedActivity($this->get('related_activity'));
    }

    /**
     * Get the error message as required.
     *
     * @return array
     */
    public function messages(): array
    {
        return $this->getMessagesForRelatedActivity($this->get('related_activity'));
    }

    /**
     * Returns rules for related activity.
     *
     * @param array $formFields
     *
     * @return array
     */
    public function getRulesForRelatedActivity(array $formFields): array
    {
        $rules = [];

        foreach ($formFields as $index => $formField) {
            $baseForm = sprintf('related_activity.%s', $index);
            $rules[sprintf('%s.relationship_type', $baseForm)] = 'nullable|in:' . implode(',', array_keys(getCodeList('RelatedActivityType', 'Activity', false)));
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
    public function getMessagesForRelatedActivity(array $formFields): array
    {
        $messages = [];

        foreach ($formFields as $index => $formField) {
            $baseForm = sprintf('related_activity.%s', $index);
            $messages[sprintf('%s.relationship_type.in', $baseForm)] = 'The relationship type in related activity is invalid.';
        }

        return $messages;
    }
}
