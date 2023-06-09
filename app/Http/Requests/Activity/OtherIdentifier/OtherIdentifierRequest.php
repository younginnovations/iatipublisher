<?php

declare(strict_types=1);

namespace App\Http\Requests\Activity\OtherIdentifier;

use App\Http\Requests\Activity\ActivityBaseRequest;
use JsonException;

/**
 * Class OtherIdentifierRequest.
 */
class OtherIdentifierRequest extends ActivityBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     *
     * @throws JsonException
     */
    public function rules(): array
    {
        $data = $this->get('other_identifier');
        $totalRules = [
            $this->getWarningForOtherIdentifier($data),
            $this->getErrorsForOtherIdentifier($data),
        ];

        return mergeRules($totalRules);
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
     * Get critical rule for other identifier request.
     *
     * @param array $formFields
     *
     * @return array
     *
     * @throws JsonException
     */
    public function getErrorsForOtherIdentifier(array $formFields): array
    {
        $rules = [];

        foreach ($formFields as $otherIdentifierIndex => $otherIdentifier) {
            $otherIdentifierForm = sprintf('other_identifier.%s', $otherIdentifierIndex);
            $rules[sprintf('%s.reference_type', $otherIdentifierForm)] = 'nullable|in:' . implode(',', array_keys(getCodeList('OtherIdentifierType', 'Activity', false)));

            foreach ($this->getErrorsForOwnerOrg($otherIdentifier['owner_org'], $otherIdentifierForm) as $ownerOrgIndex => $ownerOrgRules) {
                $rules[$ownerOrgIndex] = $ownerOrgRules;
            }
        }

        return $rules;
    }

    /**
     * Returns rules for other identifier.
     *
     * @param array $formFields
     *
     * @return array
     */
    public function getWarningForOtherIdentifier(array $formFields): array
    {
        $rules = [];

        foreach ($formFields as $otherIdentifierIndex => $otherIdentifier) {
            $otherIdentifierForm = sprintf('other_identifier.%s', $otherIdentifierIndex);
            $rules[sprintf('%s.reference', $otherIdentifierForm)] = ['nullable', 'not_regex:/(&|!|\/|\||\?)/'];

            foreach ($this->getWarningForOwnerOrg($otherIdentifier['owner_org'], $otherIdentifierForm) as $ownerOrgIndex => $ownerOrgRules) {
                $rules[$ownerOrgIndex] = $ownerOrgRules;
            }
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
            $messages[sprintf('%s.reference.not_regex', $otherIdentifierForm)] = translateRequestMessage('other_identifier_ref', 'shouldnt_contain_symbol');
            $messages[sprintf('%s.reference_type.in', $otherIdentifierForm)] = translateRequestMessage('other_identifier', 'type_is_not_valid');

            foreach ($this->getMessagesForOwnerOrg($otherIdentifier['owner_org'], $otherIdentifierForm) as $ownerOrgIndex => $ownerOrgMessages) {
                $messages[$ownerOrgIndex] = $ownerOrgMessages;
            }
        }

        return $messages;
    }

    /**
     * Return warning rules for owner org.
     *
     * @param $formFields
     * @param $formBase
     *
     * @return array
     */
    public function getWarningForOwnerOrg($formFields, $formBase): array
    {
        $rules = [];

        foreach ($formFields as $ownerOrgIndex => $ownerOrg) {
            $ownerOrgForm = sprintf('%s.owner_org.%s', $formBase, $ownerOrgIndex);
            $rules[sprintf('%s.owner_org.%s.ref', $formBase, $ownerOrgIndex)] = ['nullable', 'not_regex:/(&|!|\/|\||\?)/'];

            foreach ($this->getWarningForNarrative($ownerOrg['narrative'], $ownerOrgForm) as $ownerOrgNarrativeIndex => $ownerOrgNarrativeRules) {
                $rules[$ownerOrgNarrativeIndex] = $ownerOrgNarrativeRules;
            }
        }

        return $rules;
    }

    /**
     * Return error rules for owner org.
     *
     * @param $formFields
     * @param $formBase
     *
     * @return array
     */
    public function getErrorsForOwnerOrg($formFields, $formBase) : array
    {
        $rules = [];

        foreach ($formFields as $ownerOrgIndex => $ownerOrg) {
            $ownerOrgForm = sprintf('%s.owner_org.%s', $formBase, $ownerOrgIndex);

            foreach ($this->getErrorsForNarrative($ownerOrg['narrative'], $ownerOrgForm) as $ownerOrgNarrativeIndex => $ownerOrgNarrativeRules) {
                $rules[$ownerOrgNarrativeIndex] = $ownerOrgNarrativeRules;
            }
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
    public function getMessagesForOwnerOrg($formFields, $formBase): array
    {
        $messages = [];

        foreach ($formFields as $ownerOrgIndex => $ownerOrg) {
            $ownerOrgForm = sprintf('%s.owner_org.%s', $formBase, $ownerOrgIndex);
            $messages[sprintf('%s.owner_org.%s.ref.not_regex', $formBase, $ownerOrgIndex)] = translateRequestMessage('org_reference', 'shouldnt_contain_symbol');

            foreach ($this->getMessagesForNarrative($ownerOrg['narrative'], $ownerOrgForm) as $ownerOrgNarrativeIndex => $ownerOrgNarrativeMessages) {
                $messages[$ownerOrgNarrativeIndex] = $ownerOrgNarrativeMessages;
            }
        }

        return $messages;
    }
}
