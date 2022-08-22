<?php

declare(strict_types=1);

namespace App\Http\Requests\Organization\ReportingOrg;

use App\Http\Requests\Organization\OrganizationBaseRequest;

/**
 * Class ReportingOrgRequest.
 */
class ReportingOrgRequest extends OrganizationBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $this->getRulesForReportingOrganization($this->get('reporting_org'));
    }

    /**
     * @param array $formFields
     * @return array
     */
    public function getRulesForReportingOrganization(array $formFields)
    {
        $rules = [];
        foreach ($formFields as $reportingOrganizationIndex => $reportingOrganization) {
            $reportingOrganizationForm = sprintf('reporting_org.%s', $reportingOrganizationIndex);
            $rules[$reportingOrganizationForm . '.ref'] = ['nullable', 'not_regex:/(&|!|\/|\||\?)/'];

            $rules = array_merge(
                $rules,
                $this->getRulesForNarrative($reportingOrganization['narrative'], $reportingOrganizationForm)
            );
        }

        return $rules;
    }

    /**
     * Get the Validation Error message.
     * @return array
     */
    public function messages()
    {
        return $this->getMessagesForReportingOrganization($this->get('reporting_org'));
    }

    public function getMessagesForReportingOrganization(array $formFields)
    {
        $messages = [];
        foreach ($formFields as $reportingOrganizationIndex => $reportingOrganization) {
            $reportingOrganizationForm = sprintf('reporting_org.%s', $reportingOrganizationIndex);

            $messages[$reportingOrganizationForm . '.ref.not_regex'] = 'The @ref format is invalid.';

            $messages = array_merge(
                $messages,
                $this->getMessagesForNarrative($reportingOrganization['narrative'], $reportingOrganizationForm)
            );
        }

        return $messages;
    }
}
