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
    public function rules(): array
    {
        return $this->getRulesForOtherIdentifier($this->get('owner_org'));
    }

    /**
     * Get validation messages.
     *
     * @return array
     */
    public function messages(): array
    {
        return $this->getMessagesForOtherIdentifier($this->get('owner_org'));
    }

    /**
     * Returns rules for other identifier.
     *
     * @param array $formFields
     *
     * @return array
     */
    public function getRulesForOtherIdentifier(array $formFields): array
    {
        $rules = [];

        $rules['reference'] = ['nullable', 'not_regex:/(&|!|\/|\||\?)/'];

        foreach ($formFields as $ownerOrgIndex => $ownerOrg) {
            $ownerOrgForm = sprintf('owner_org.%s', $ownerOrgIndex);
            $rules[sprintf('owner_org.%s.ref', $ownerOrgIndex)] = ['nullable', 'not_regex:/(&|!|\/|\||\?)/'];
            $rules = array_merge(
                $rules,
                $this->getRulesForNarrative($ownerOrg['narrative'], $ownerOrgForm)
            );
        }

        return $rules;
    }

    /**
     * Returns messages for other identifier.
     *
     * @param array $formFields
     *
     * @return array
     */
    public function getMessagesForOtherIdentifier(array $formFields): array
    {
        $messages = [];

        foreach ($formFields as $ownerOrgIndex => $ownerOrg) {
            $ownerOrgForm = sprintf('owner_org.%s', $ownerOrgIndex);
            $messages[sprintf('%s.ref.not_regex', $ownerOrgForm)] = 'The @ref field shouldn\'t contain the symbols /, &, | or ?.';
            $messages = array_merge(
                $messages,
                $this->getMessagesForNarrative($ownerOrg['narrative'], $ownerOrgForm)
            );
        }

        return $messages;
    }
}
