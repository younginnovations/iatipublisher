<?php

declare(strict_types=1);

namespace App\Http\Requests\Activity\ParticipatingOrganization;

use App\Http\Requests\Activity\ActivityBaseRequest;
use JsonException;

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
     *
     * @throws JsonException
     */
    public function rules(array $participating_org = []): array
    {
        $data = $this->get('participating_org') ?? [];
        $totalRules = [$this->getWarningForParticipatingOrg($data), $this->getErrorsForParticipatingOrg($data)];

        return mergeRules($totalRules);
    }

    /**
     * prepare the error message.
     *
     * @param array $participating_org
     *
     * @return array
     */
    public function messages(array $participating_org = []): array
    {
        return $this->getMessagesForParticipatingOrg($this->get('participating_org') ?? $participating_org);
    }

    /**
     * returns rules for participating organization.
     *
     * @param $formFields
     *
     * @return array
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
     *
     * @throws JsonException
     */
    public function getErrorsForParticipatingOrg($formFields): array
    {
        $rules = [];

        foreach ($formFields as $participatingOrgIndex => $participatingOrg) {
            $participatingOrgForm = 'participating_org.' . $participatingOrgIndex;
            $identifier = $participatingOrgForm . '.identifier';
            $rules[sprintf('%s.organization_role', $participatingOrgForm)] = 'nullable|in:' . implode(',', array_keys(getCodeList('OrganisationRole', 'Organization', false)));
            $rules[sprintf('%s.type', $participatingOrgForm)] = 'nullable|in:' . implode(',', array_keys(getCodeList('OrganizationType', 'Organization', false)));
            $rules[sprintf('%s.crs_channel_code', $participatingOrgForm)] = 'nullable|in:' . implode(',', array_keys(getCodeList('CRSChannelCode', 'Activity', false)));

            foreach ($this->getErrorsForNarrative($participatingOrg['narrative'], $participatingOrgForm) as $participatingNarrativeIndex => $narrativeRules) {
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
     * @return array
     */
    public function getMessagesForParticipatingOrg($formFields): array
    {
        $messages = [];

        foreach ($formFields as $participatingOrgIndex => $participatingOrg) {
            $participatingOrgForm = 'participating_org.' . $participatingOrgIndex;
            $messages[$participatingOrgForm . '.organization_role.required'] = trans('validation.required', ['attribute' => trans('elementForm.organisation_role')]);
            $identifier = $participatingOrgForm . '.identifier';
            $messages[$identifier . '.exclude_operators'] = translateCommonError('identifier_must_not_contain_symbols_or_blank_spaces');

            $messages[sprintf('%s.organization_role.in', $participatingOrgForm)] = translateRequestMessage('participating_org', 'role_is_invalid');
            $messages[sprintf('%s.type.in', $participatingOrgForm)] = translateRequestMessage('participating_org', 'type_is_invalid');
            $messages[sprintf('%s.crs_channel_code.in', $participatingOrgForm)] = translateMidfixSuffix('common.crs_channel_code', 'requests.suffix.is_invalid');

            foreach ($this->getMessagesForNarrative($participatingOrg['narrative'], $participatingOrgForm) as $participatingNarrativeIndex => $narrativeMessages) {
                $messages[$participatingNarrativeIndex] = $narrativeMessages;
            }
        }

        return $messages;
    }
}
