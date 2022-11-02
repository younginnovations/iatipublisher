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
    public function rules(): array
    {
        return $this->getRulesForReportingOrganization($this->get('reporting_org'));
    }

    /**
     * Get the Validation Error message.
     *
     * @return array
     */
    public function messages(): array
    {
        return $this->getMessagesForReportingOrganization($this->get('reporting_org'));
    }

    /**
     * Rules for reporting organization form.
     *
     * @param array $formFields
     *
     * @return array
     */
    public function getRulesForReportingOrganization(array $formFields): array
    {
        $rules = [];

        foreach ($formFields as $reportingOrganizationIndex => $reportingOrganization) {
            $reportingOrganizationForm = sprintf('reporting_org.%s', $reportingOrganizationIndex);
            $rules[$reportingOrganizationForm . '.ref'] = ['nullable', 'not_regex:/(&|!|\/|\||\?)/'];

            $narrativeRules = $this->getRulesForNarrative($reportingOrganization['narrative'], $reportingOrganizationForm);

            foreach ($narrativeRules as $key => $item) {
                $rules[$key] = $item;
            }
        }

        return $rules;
    }

    /**
     * Custom message for reporting organization form.
     *
     * @param array $formFields
     *
     * @return array
     */
    public function getMessagesForReportingOrganization(array $formFields): array
    {
        $messages = [];

        foreach ($formFields as $reportingOrganizationIndex => $reportingOrganization) {
            $reportingOrganizationForm = sprintf('reporting_org.%s', $reportingOrganizationIndex);

            $messages[$reportingOrganizationForm . '.ref.not_regex'] = 'The @ref format is invalid.';

            $narrativeMessages = $this->getMessagesForNarrative($reportingOrganization['narrative'], $reportingOrganizationForm);

            foreach ($narrativeMessages as $key => $item) {
                $messages[$key] = $item;
            }
        }

        return $messages;
    }
}
