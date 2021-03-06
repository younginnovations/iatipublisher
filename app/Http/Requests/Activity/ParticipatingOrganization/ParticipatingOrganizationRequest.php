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
    public function rules(): array
    {
        return $this->getRulesForParticipatingOrg($this->get('participating_org'));
    }

    /**
     * prepare the error message.
     * @return array
     */
    public function messages(): array
    {
        return $this->getMessagesForParticipatingOrg($this->get('participating_org'));
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
            $narrative = sprintf('%s.narrative.0.narrative', $participatingOrgForm);
            $rules[$identifier] = 'exclude|required_without:' . $narrative;
            $rules[$participatingOrgForm . '.organization_id'] = 'nullable|organization_exists';
            $rules[$identifier] = 'exclude|required_without:' . $narrative;
            $rules = array_merge_recursive(
                $rules,
                $this->getRulesForNarrative($participatingOrg['narrative'], $participatingOrgForm)
            );
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
            $messages[$identifier . '.required_without'] = trans(
                'validation.required_without',
                ['attribute' => trans('elementForm.identifier'), 'values' => trans('elementForm.narrative')]
            );
            $messages[$narrative . '.required_without'] = trans(
                'validation.required_without',
                ['attribute' => trans('elementForm.narrative'), 'values' => trans('elementForm.identifier')]
            );
            $messages[$identifier . '.exclude_operators'] = trans(
                'validation.exclude_operators',
                ['attribute' => trans('elementForm.identifier'), 'values' => trans('elementForm.identifier')]
            );
            $messages = array_merge(
                $messages,
                $this->getMessagesForNarrative($participatingOrg['narrative'], $participatingOrgForm)
            );
        }

        return $messages;
    }
}
