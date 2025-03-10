<?php

declare(strict_types=1);

namespace App\Http\Requests\Activity\ParticipatingOrganization;

use App\Http\Requests\Activity\ActivityBaseRequest;

/**
 * Class ParticipatingOrganizationRequest.
 */
class ParticipatingOrganizationRequest extends ActivityBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @param array $participating_org
     *
     * @return array
     * @throws \JsonException
     */
    public function rules($participating_org = []): array
    {
        $data = $this->get('participating_org') ?? [];
        $totalRules = [$this->getWarningForParticipatingOrg($data), $this->getErrorsForParticipatingOrg($data)];

        return mergeRules($totalRules);
    }

    /**
     * prepare the error message.
     * @return array
     */
    public function messages($participating_org = []): array
    {
        return $this->getMessagesForParticipatingOrg($this->get('participating_org') ?? $participating_org);
    }

    /**
     * returns rules for participating organization.
     *
     * @param $formFields
     *
     * @return array|mixed
     */
    public function getWarningForParticipatingOrg($formFields): array
    {
        $rules = [];

        foreach ($formFields as $participatingOrgIndex => $participatingOrg) {
            $participatingOrgForm = 'participating_org.' . $participatingOrgIndex;
            $identifier = $participatingOrgForm . '.identifier';
            $rules[$identifier] = 'nullable|exclude_operators';

            foreach ($this->getWarningForNarrative($participatingOrg['narrative'], $participatingOrgForm) as $participatingNarrativeIndex => $narrativeRules) {
                $rules[$participatingNarrativeIndex] = $narrativeRules;
            }
        }

        return $rules;
    }

    /**
     * returns rules for participating organization.
     *
     * @param $formFields
     *
     * @return array
     * @throws \JsonException
     */
    public function getErrorsForParticipatingOrg($formFields): array
    {
        $rules = [];

        foreach ($formFields as $participatingOrgIndex => $participatingOrg) {
            $participatingOrgForm = 'participating_org.' . $participatingOrgIndex;
            $identifier = $participatingOrgForm . '.identifier';
            $allNarrative = $participatingOrg['narrative'];
            $reference = $participatingOrg['ref'];

            $rules[sprintf('%s.organization_role', $participatingOrgForm)] = 'nullable|in:' . implode(
                ',',
                array_keys(
                    $this->getCodeListForRequestFiles('OrganisationRole', 'Organization', false)
                )
            );

            if ($this->bothReferenceAndNarrativeEmpty($allNarrative, $reference)) {
                $rules[sprintf('%s.ref', $participatingOrgForm)] = 'required_when_narrative_is_empty';
            }

            $rules[sprintf('%s.type', $participatingOrgForm)] = 'nullable|in:' . implode(
                ',',
                array_keys(
                    $this->getCodeListForRequestFiles('OrganizationType', 'Organization', false)
                )
            );
            $rules[sprintf('%s.crs_channel_code', $participatingOrgForm)] = 'nullable|in:' . implode(',', array_keys(
                $this->getCodeListForRequestFiles('CRSChannelCode', 'Activity', false)
            ));

            foreach ($allNarrative as $narrativeIndex => $narrative) {
                $formKey = sprintf('%s.narrative.%s.narrative', $participatingOrgForm, $narrativeIndex);
                if ($this->bothReferenceAndNarrativeEmpty($allNarrative, $reference)) {
                    $rules[$formKey][] = 'required_when_reference_is_empty';
                }
            }

            $narrativeLanguageRules = $this->getErrorsForNarrative($allNarrative, $participatingOrgForm);

            foreach ($narrativeLanguageRules as $languageIndex => $languageRules) {
                $rules[$languageIndex] = $languageRules;
            }
        }

        return $rules;
    }

    /**
     * returns messages for participating organization.
     *
     * @param $formFields
     *
     * @return array
     */
    public function getMessagesForParticipatingOrg($formFields): array
    {
        $messages = [];

        foreach ($formFields as $participatingOrgIndex => $participatingOrg) {
            $participatingOrgForm = 'participating_org.' . $participatingOrgIndex;
            $messages[$participatingOrgForm . '.organization_role.required'] = trans('validation.required', ['attribute' => trans('elementForm.organisation_role')]);
            $identifier = $participatingOrgForm . '.identifier';
            $messages[$identifier . '.exclude_operators'] = 'The identifier must not contain symbols or blank space';

            $messages[sprintf('%s.organization_role.in', $participatingOrgForm)] = 'The participating organisation role is invalid.';
            $messages[sprintf('%s.type.in', $participatingOrgForm)] = 'The participating organisation type is invalid.';
            $messages[sprintf('%s.ref.required_when_narrative_is_empty', $participatingOrgForm)] = 'The reference field is required when name is empty.';
            $messages[sprintf('%s.crs_channel_code.in', $participatingOrgForm)] = 'The Crs Channel Code is invalid.';

            foreach ($this->getMessagesForNarrative($participatingOrg['narrative'], $participatingOrgForm) as $participatingNarrativeIndex => $narrativeMessages) {
                $messages[$participatingNarrativeIndex] = $narrativeMessages;
            }

            $allNarrative = $participatingOrg['narrative'];
            foreach ($allNarrative as $narrativeIndex => $narrative) {
                $messageKey = sprintf('%s.narrative.%s.narrative.required_when_reference_is_empty', $participatingOrgForm, $narrativeIndex);

                if ($this->bothReferenceAndNarrativeEmpty($allNarrative, $participatingOrg['ref'])) {
                    $messages[$messageKey] = 'The name field is required when participating org reference is empty.';
                }
            }
        }

        return $messages;
    }

    private function bothReferenceAndNarrativeEmpty($allNarrative, $reference): bool
    {
        $onlyNarrativeValue = array_map(fn ($narrative) => $narrative['narrative'], $allNarrative);

        return hasOnlyEmptyValues($onlyNarrativeValue) && empty(trim((string) $reference));
    }
}
