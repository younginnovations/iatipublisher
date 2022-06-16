<?php

declare(strict_types=1);

namespace App\Http\Requests\Activity\Otheridentifier;

use App\Http\Requests\Activity\ActivityBaseRequest;
use Illuminate\Http\Request;

/**
 * Class OtheridentifierRequest.
 */
class OtherIdentifierRequest extends ActivityBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $this->getRulesForOtherIdentifier($this->get('owner_org'));
    }

    /**
     * @return array
     */
    public function messages()
    {
        return $this->getMessagesForOtherIdentifier($this->get('owner_org'));
    }

    /**
     * @param array $formFields
     * @return array
     */
    public function getRulesForOtherIdentifier(array $formFields)
    {
        $rules = [];
        $rules['reference'] = 'required';
        $rules['reference_type'] = 'required';

        foreach ($formFields as $otherIdentifierIndex => $otherIdentifier) {
            $otherIdentifierForm = sprintf('owner_org.%s', $otherIdentifierIndex);

            $rules[sprintf('owner_org.%s.reference', $otherIdentifierIndex)] = 'required';

            foreach ($otherIdentifier['narrative'] as $narrativeIndex => $narrative) {
                $rules[sprintf('%s.narrative.%s.narrative', $otherIdentifierForm, $narrativeIndex)][] = 'required_if:condition_attached,1';
            }
        }

        return $rules;
    }

    /**
     * @param array $formFields
     * @return array
     */
    public function getMessagesForOtherIdentifier(array $formFields)
    {
        $messages = [];

        foreach ($formFields as $otherIdentifierIndex => $otherIdentifier) {
            $otherIdentifierForm = sprintf('other_identifier.%s', $otherIdentifierIndex);
            $messages['reference.required'] = 'The reference field is required.';

            foreach ($otherIdentifier['narrative'] as $narrativeIndex => $narrative) {
                $messages[sprintf('%s.narrative.%s.narrative.required_if', $otherIdentifierForm, $narrativeIndex)] = 'Narrative is required';
            }
        }

        return $messages;
    }
}
