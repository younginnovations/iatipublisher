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
            $narrativeRules = $this->getRulesForNarrative($description['narrative'], $descriptionForm);

            foreach ($narrativeRules as $key => $item) {
                $rules[$key] = $item;
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
    public function getMessagesForDescription(array $formFields): array
    {
        $messages = [];

        foreach ($formFields as $descriptionIndex => $description) {
            $descriptionForm = sprintf('description.%s', $descriptionIndex);
            $narrativeMessages = $this->getMessagesForRequiredNarrative($description['narrative'], $descriptionForm);

            foreach ($narrativeMessages as $key => $item) {
                $messages[$key] = $item;
            }
        }

        return $messages;
    }
}
