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
     * Holds organization level reporting org values
     * Only set during import.
     *
     * @var mixed
     */
    protected mixed $reportingOrganisationInOrganisation = '';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * @throws \JsonException
     */
    public function rules(): array
    {
        $totalRules = [
            $this->getErrorsForReportingOrganization($this->get('reporting_org')),
            $this->getWarningForReportingOrganization($this->get('reporting_org')),
            $this->getCriticalErrorsForReportingOrganization(($this->get('reporting_org'))),
        ];

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
     * Critical rules for reporting organization.
     *
     * @param array $formFields
     *
     * @return array
     */
    public function getCriticalErrorsForReportingOrganization(array $formFields):array
    {
        $rules = [];
        $rules['reporting_org'] = 'size:1';

        $reportingOrganizationTypes = implode(',', array_keys(getCodeList('OrganizationType', 'Organization', false)));
        $organizationReportingOrg = is_array($this->reportingOrganisationInOrganisation) ? $this->reportingOrganisationInOrganisation : auth()->user()->organization->reporting_org;

        $reportingOrganization = $formFields[0];
        $reportingOrganizationIndex = 0;

        $reportingOrganizationForm = sprintf('reporting_org.%s', $reportingOrganizationIndex);

        $rules[$reportingOrganizationForm . '.type'] = [
            'nullable',
            sprintf('in:%s', $reportingOrganizationTypes),
            $organizationReportingOrg[0]['type'] ? "must_match:{$organizationReportingOrg[0]['type']}" : '',
        ];
        $rules[$reportingOrganizationForm . '.secondary_reporter'] = [
            'nullable',
            'in:0,1',
        ];
        $rules[$reportingOrganizationForm . '.ref'] = [
            'nullable',
            'not_regex:/(&|!|\/|\||\?)/',
            $organizationReportingOrg[0]['ref'] ? "must_match:{$organizationReportingOrg[0]['ref']}" : '',
        ];

        if (is_array($this->reportingOrganisationInOrganisation)) {
            $narrativeRules = $this->getMessagesForNarrative($reportingOrganization['narrative'], $reportingOrganizationForm);

            list($orgNarratives, $orgLanguages) = $this->getNarrativesAndLanguages($organizationReportingOrg);

            foreach ($narrativeRules as $key => $item) {
                $rules[$key] = $item;
            }
            foreach ($reportingOrganization['narrative'] as $index => $narrative) {
                $rules["$reportingOrganizationForm.narrative.$index.narrative"][] = "must_match:$orgNarratives[$index]";
                $rules["$reportingOrganizationForm.narrative.$index.language"][] = "must_match:$orgLanguages[$index]";
            }
        }

        return $rules;
    }

    /**
     * Error rules for reporting organization form.
     *
     * @param array $formFields
     *
     * @return array
     * @throws \JsonException
     */
    public function getErrorsForReportingOrganization(array $formFields): array
    {
        return [];
    }

    /**
     * Warning rules for reporting organization form.
     *
     * @param array $formFields
     *
     * @return array
     */
    public function getWarningForReportingOrganization(array $formFields): array
    {
        return [];
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

        $reportingOrganization = $formFields[0];
        $reportingOrganizationIndex = 0;

        $reportingOrganizationForm = sprintf('reporting_org.%s', $reportingOrganizationIndex);

        $messages[$reportingOrganizationForm . '.ref.must_match'] = 'The reference of reporting-org must match reference of reporting-org in organisation';
        $messages[$reportingOrganizationForm . '.ref.not_regex'] = 'The reference format for reporting organisation is invalid.';

        $messages[$reportingOrganizationForm . '.type.must_match'] = 'The type of reporting-org must match type of reporting-org in organisation';
        $messages[$reportingOrganizationForm . '.type.in:0,1'] = 'The type for reporting organisation is invalid.';

        if (is_array($this->reportingOrganisationInOrganisation)) {
            $narrativeMessages = $this->getMessagesForNarrative($reportingOrganization['narrative'], $reportingOrganizationForm);

            foreach ($reportingOrganization['narrative'] as $index => $narrative) {
                $narrativeMessages["$reportingOrganizationForm.narrative.$index.narrative.must_match"] = 'Narrative must match Narrative in organisations reporting-org';
                $narrativeMessages["$reportingOrganizationForm.narrative.$index.language.must_match"] = 'Language must match Language in organisations reporting-org';
            }

            foreach ($narrativeMessages as $key => $item) {
                $messages[$key] = $item;
            }
        }

        return $messages;
    }

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
}
