<?php

declare(strict_types=1);

namespace App\Http\Requests\Activity\Description;

use App\Http\Requests\Activity\ActivityBaseRequest;

class DescriptionRequest extends ActivityBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return $this->getRulesForDescription($this->get('description'));
    }

    /**
     * Get the error message as required.
     *
     * @return array
     */
    public function messages(): array
    {
        return $this->getMessagesForDescription($this->get('description'));
    }

    /**
     * Returns rules for related activity.
     * @param array $formFields
     * @return array
     */
    protected function getRulesForDescription(array $formFields): array
    {
        $rules = [];

        return $rules;
    }

    /**
     * Returns messages for related activity validations.
     * @param array $formFields
     * @return array
     */
    protected function getMessagesForDescription(array $formFields): array
    {
        $messages = [];

        return $messages;
    }
}
