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
    public function rules($description = []): array
    {
        return $this->getRulesForDescription($this->get('description') ?? $description);
    }

    /**
     * Get the error message as required.
     *
     * @return array
     */
    public function messages($description = []): array
    {
        return $this->getMessagesForDescription($this->get('description') ?? $description);
    }

    /**
     * Returns rules for related activity.
     *
     * @param array $formFields
     *
     * @return array
     */
    public function getRulesForDescription(array $formFields): array
    {
        $rules = [];

        foreach ($formFields as $descriptionIndex => $description) {
            $descriptionForm = sprintf('description.%s', $descriptionIndex);

            $rules = array_merge(
                $rules,
                $this->getRulesForNarrative($description['narrative'], $descriptionForm)
            );
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
    public function getMessagesForDescription(array $formFields): array
    {
        $messages = [];

        foreach ($formFields as $descriptionIndex => $description) {
            $descriptionForm = sprintf('description.%s', $descriptionIndex);
            $messages = array_merge(
                $messages,
                $this->getMessagesForRequiredNarrative($description['narrative'], $descriptionForm)
            );
        }

        return $messages;
    }
}
