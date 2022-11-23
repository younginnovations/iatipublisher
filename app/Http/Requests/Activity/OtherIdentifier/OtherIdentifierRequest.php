<?php

declare(strict_types=1);

namespace App\Http\Requests\Activity\OtherIdentifier;

use App\Http\Requests\Activity\ActivityBaseRequest;

/**
 * Class OtherIdentifierRequest.
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
        return $this->getRulesForOtherIdentifier($this->get('other_identifier'));
    }

    /**
     * Get validation messages.
     *
     * @return array
     */
    public function messages(): array
    {
        return $this->getMessagesForOtherIdentifier($this->get('other_identifier'));
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

        foreach ($formFields as $otherIdentifierIndex => $otherIdentifier) {
            $otherIdentifierForm = sprintf('other_identifier.%s', $otherIdentifierIndex);
            $rules[sprintf('%s.reference', $otherIdentifierForm)] = ['nullable', 'not_regex:/(&|!|\/|\||\?)/'];
            $rules = array_merge(
                $rules,
                $this->getRulesForOwnerOrg($otherIdentifier['owner_org'], $otherIdentifierForm)
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

        foreach ($formFields as $otherIdentifierIndex => $otherIdentifier) {
            $otherIdentifierForm = sprintf('other_identifier.%s', $otherIdentifierIndex);
            $messages[sprintf('%s.reference.not_regex', $otherIdentifierForm)] = 'The @ref field shouldn\'t contain the symbols /, &, | or ?.';
            $messages = array_merge(
                $messages,
                $this->getMessagesForOwnerOrg($otherIdentifier['owner_org'], $otherIdentifierForm)
            );
        }

        return $messages;
    }

    /**
     * Return rules for owner org.
     *
     * @param $formFields
     * @param $formBase
     *
     * @return array
     */
    public function getRulesForOwnerOrg($formFields, $formBase): array
    {
        $rules = [];

        foreach ($formFields as $ownerOrgIndex => $ownerOrg) {
            $ownerOrgForm = sprintf('%s.owner_org.%s', $formBase, $ownerOrgIndex);
            $rules[sprintf('%s.owner_org.%s.ref', $formBase, $ownerOrgIndex)] = ['nullable', 'not_regex:/(&|!|\/|\||\?)/'];
            $rules = array_merge(
                $rules,
                $this->getRulesForNarrative($ownerOrg['narrative'], $ownerOrgForm)
            );
        }

        return $rules;
    }

    /**
     * Returns messages for owner org.
     *
     * @param $formFields
     * @param $formBase
     *
     * @return array
     */
    public function getMessagesForOwnerOrg($formFields, $formBase)
    {
        $messages = [];

        foreach ($formFields as $ownerOrgIndex => $ownerOrg) {
            $ownerOrgForm = sprintf('%s.owner_org.%s', $formBase, $ownerOrgIndex);
            $messages[sprintf('%s.owner_org.%s.ref.not_regex', $formBase, $ownerOrgIndex)] = 'The @ref field shouldn\'t contain the symbols /, &, | or ?.';
            $messages = array_merge(
                $messages,
                $this->getMessagesForNarrative($ownerOrg['narrative'], $ownerOrgForm)
            );
        }

        return $messages;
    }
}
