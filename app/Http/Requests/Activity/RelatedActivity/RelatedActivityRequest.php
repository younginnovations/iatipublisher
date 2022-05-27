<?php

declare(strict_types=1);

namespace App\Http\Requests\Activity\RelatedActivity;

use App\Http\Requests\Activity\ActivityBaseRequest;

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
     * @param array $formFields
     * @return array
     */
    protected function getRulesForRelatedActivity(array $formFields): array
    {
        $rules = [];

        foreach ($formFields as $relatedActivityIndex => $relatedActivity) {
            $relatedActivityForm = sprintf('related_activity.%s', $relatedActivityIndex);
            $rules[sprintf('%s.relationship_type', $relatedActivityForm)] = 'required';
            $rules[sprintf('%s.activity_identifier', $relatedActivityForm)] = 'required';
        }

        return $rules;
    }

    /**
     * Returns messages for related activity validations.
     * @param array $formFields
     * @return array
     */
    protected function getMessagesForRelatedActivity(array $formFields): array
    {
        $messages = [];

        foreach ($formFields as $relatedActivityIndex => $relatedActivity) {
            $relatedActivityForm = sprintf('related_activity.%s', $relatedActivityIndex);
            $messages[sprintf('%s.relationship_type.required', $relatedActivityForm)] = 'Relationship type is required.';
            $messages[sprintf('%s.activity_identifier.required', $relatedActivityForm)] = 'Activity Identifier is required.';
        }

        return $messages;
    }
}
