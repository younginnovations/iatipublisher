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
    protected function getRulesForRelatedActivity(array $formFields): array
    {
        $rules = [];

        return $rules;
    }

    /**
     * Returns messages for related activity validations.
     *
     * @param array $formFields
     *
     * @return array
     */
    protected function getMessagesForRelatedActivity(array $formFields): array
    {
        $messages = [];

        return $messages;
    }
}
