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
     * @return array
     */
    public function rules($participating_org = []): array
    {
        $data = $this->get('participating_org') ?? [];
        $totalRules = [$this->getRulesForParticipatingOrg($data), $this->getCriticalRulesForParticipatingOrg($data)];

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
    public function getRulesForParticipatingOrg($formFields): array
    {
        $rules = [];

        foreach ($formFields as $participatingOrgIndex => $participatingOrg) {
            $participatingOrgForm = 'participating_org.' . $participatingOrgIndex;
            $identifier = $participatingOrgForm . '.identifier';
            $rules[$identifier] = 'nullable|exclude_operators';

            foreach ($this->getRulesForNarrative($participatingOrg['narrative'], $participatingOrgForm) as $participatingNarrativeIndex => $narrativeRules) {
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
     * @return array|mixed
     */
    public function getCriticalRulesForParticipatingOrg($formFields): array
    {
        $rules = [];

        foreach ($formFields as $participatingOrgIndex => $participatingOrg) {
            $participatingOrgForm = 'participating_org.' . $participatingOrgIndex;
            $identifier = $participatingOrgForm . '.identifier';
            $rules[sprintf('%s.organization_role', $participatingOrgForm)] = 'nullable|in:' . implode(',', array_keys(getCodeList('OrganisationRole', 'Organization', false)));
            $rules[sprintf('%s.type', $participatingOrgForm)] = 'nullable|in:' . implode(',', array_keys(getCodeList('OrganizationType', 'Organization', false)));
            $rules[sprintf('%s.crs_channel_code', $participatingOrgForm)] = 'nullable|in:' . implode(',', array_keys(getCodeList('CRSChannelCode', 'Activity', false)));

            foreach ($this->getCriticalRulesForNarrative($participatingOrg['narrative'], $participatingOrgForm) as $participatingNarrativeIndex => $narrativeRules) {
                $rules[$participatingNarrativeIndex] = $narrativeRules;
            }
        }

        return $rules;
    }

    /**
     * returns messages for participating organization.
     *
     * @param $formFields
     *
     * @return array|mixed
     */
    public function getMessagesForParticipatingOrg($formFields): array
    {
        $messages = [];

        foreach ($formFields as $participatingOrgIndex => $participatingOrg) {
            $participatingOrgForm = 'participating_org.' . $participatingOrgIndex;
            $messages[$participatingOrgForm . '.organization_role.required'] = trans('validation.required', ['attribute' => trans('elementForm.organisation_role')]);
            $identifier = $participatingOrgForm . '.identifier';
            $narrative = sprintf('%s.narrative.0.narrative', $participatingOrgForm);
            $messages[$identifier . '.exclude_operators'] = trans(
                'validation.exclude_operators',
                ['attribute' => trans('elementForm.identifier'), 'values' => trans('elementForm.identifier')]
            );

            $messages[sprintf('%s.organization_role.in', $participatingOrgForm)] = 'The participating organisation role is invalid.';
            $messages[sprintf('%s.type.in', $participatingOrgForm)] = 'The participating organisation type is invalid.';

            foreach ($this->getMessagesForNarrative($participatingOrg['narrative'], $participatingOrgForm) as $participatingNarrativeIndex => $narrativeMessages) {
                $messages[$participatingNarrativeIndex] = $narrativeMessages;
            }
        }

        return $messages;
    }
}
