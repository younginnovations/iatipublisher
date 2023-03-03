<?php

declare(strict_types=1);

namespace App\Http\Requests\Activity\ReportingOrg;

use App\Http\Requests\Activity\ActivityBaseRequest;

/**
 * Class ReportingOrgRequest.
 */
class ReportingOrgRequest extends ActivityBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $totalRules = [$this->getErrorsForReportingOrganization($this->get('reporting_org')), $this->getWarningForReportingOrganization($this->get('reporting_org'))];

        return mergeRules($totalRules);
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
     * Critical rules for reporting organization form.
     *
     * @param array $formFields
     *
     * @return array
     */
    public function getErrorsForReportingOrganization(array $formFields): array
    {
        $rules = [];
        $reportingOrganizationTypes = implode(',', array_keys(getCodeList('OrganizationType', 'Organization', false)));

        $rules['reporting_org'] = 'size:1';

        foreach ($formFields as $reportingOrganizationIndex => $reportingOrganization) {
            $reportingOrganizationForm = sprintf('reporting_org.%s', $reportingOrganizationIndex);
            $rules[$reportingOrganizationForm . '.type'] = sprintf('nullable|in:%s', $reportingOrganizationTypes);
            $rules[$reportingOrganizationForm . '.secondary_reporter'] = ['nullable', 'in:0,1'];
        }

        return $rules;
    }

    /**
     * Rules for reporting organization form.
     *
     * @param array $formFields
     *
     * @return array
     */
    public function getWarningForReportingOrganization(array $formFields): array
    {
        $rules = [];

        foreach ($formFields as $reportingOrganizationIndex => $reportingOrganization) {
            $reportingOrganizationForm = sprintf('reporting_org.%s', $reportingOrganizationIndex);
            $rules[$reportingOrganizationForm . '.ref'] = ['nullable', 'not_regex:/(&|!|\/|\||\?)/'];

            $narrativeRules = $this->getWarningForNarrative($reportingOrganization['narrative'], $reportingOrganizationForm);

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

        $messages['reporting_org.size'] = 'The reporting organisation should not have multiple values or narratives.';

        foreach ($formFields as $reportingOrganizationIndex => $reportingOrganization) {
            $reportingOrganizationForm = sprintf('reporting_org.%s', $reportingOrganizationIndex);

            $messages[$reportingOrganizationForm . '.ref.not_regex'] = 'The reference format for reporting organisation is invalid.';
            $messages[$reportingOrganizationForm . '.type.in'] = 'The type for reporting organisation is invalid.';

            $narrativeMessages = $this->getMessagesForNarrative($reportingOrganization['narrative'], $reportingOrganizationForm);

            foreach ($narrativeMessages as $key => $item) {
                $messages[$key] = $item;
            }
        }

        return $messages;
    }
<<<<<<< HEAD
=======

/**
 * Sets reporting org values in property $reportingOrganisationInOrganisation.
 *
 * @param $reportingOrganisationInOrganisation
 *
 * @return $this
 */
public function reportingOrganisationInOrganisation($reportingOrganisationInOrganisation):static
{
    $this->reportingOrganisationInOrganisation = $reportingOrganisationInOrganisation;

    return $this;
}

    /**
     * Returns organization level reporting orgs narratives and languages in respective arrays.
     *
     * @param $reportingOrg
     *
     * @return array
     */
    private function getNarrativesAndLanguages($reportingOrg): array
    {
        $narrativeFields = $reportingOrg[0]['narrative'] ?? '';

        if ($narrativeFields) {
            $narratives = [];
            $languages = [];

            foreach ($narrativeFields as $index=>$item) {
                $narratives[] = $item['narrative'];
                $languages[] = $item['language'];
            }

            return [$narratives, $languages];
        }

        return [false, false];
    }

    /**
     * Rules for reporting organization form.
     *
     * @param array $formFields
     *
     * @return array
     */
    public function getWarningForReportingOrganization(array $formFields): array
    {
        $rules = [];

        foreach ($formFields as $reportingOrganizationIndex => $reportingOrganization) {
            $reportingOrganizationForm = sprintf('reporting_org.%s', $reportingOrganizationIndex);
            $rules[$reportingOrganizationForm . '.ref'] = ['nullable', 'not_regex:/(&|!|\/|\||\?)/'];

            $narrativeRules = $this->getWarningForNarrative($reportingOrganization['narrative'], $reportingOrganizationForm);

            foreach ($narrativeRules as $key => $item) {
                $rules[$key] = $item;
            }
        }

        return $rules;
    }
>>>>>>> df0129cd (	-[x] test|refactor: modified reporting org and transaction csv unit test files)
}
