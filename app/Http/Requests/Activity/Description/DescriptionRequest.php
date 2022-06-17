<?php

declare(strict_types=1);

namespace App\Http\Requests\Activity\Description;

use App\Http\Requests\Activity\ActivityBaseRequest;

/**
 * Class DescriptionRequest.
 */
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

        foreach ($formFields as $descriptionIndex => $description) {
            $descriptionForm = sprintf('description.%s', $descriptionIndex);
//            $rules[sprintf('%s.type', $descriptionForm)] = 'required';
            $rules = array_merge(
                $rules,
                $this->getRulesForNarrative($description['narrative'], $descriptionForm)
            );
        }

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

        foreach ($formFields as $descriptionIndex => $description) {
            $descriptionForm = sprintf('description.%s', $descriptionIndex);
//            $messages[sprintf('%s.type.required', $descriptionForm)] = 'The @type field is required.';
            $messages = array_merge(
                $messages,
                $this->getMessagesForRequiredNarrative($description['narrative'], $descriptionForm)
            );
        }

        return $messages;
    }
}
