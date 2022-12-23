<?php

declare(strict_types=1);

namespace App\IATI\Traits;

use Illuminate\Support\Arr;

/**
 * Class DownloadActivitySimpleElementTrait.
 */
trait DownloadActivitySimpleElementTrait
{
    /**
     * Get activity identifier.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getActivityIdentifier($activityArray, $rowIndex): ?string
    {
        return (string) (($rowIndex === 0) ? Arr::get($activityArray, 'iati_identifier.activity_identifier', 'Not Available') : '');
    }

    /**
     * Get activity default currency.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getActivityDefaultCurrency($activityArray, $rowIndex): ?string
    {
        return (string) (($rowIndex === 0) ? Arr::get($activityArray, 'default_field_values.default_currency', '') : '');
    }

    /**
     * Get activity default language.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getActivityDefaultLanguage($activityArray, $rowIndex): ?string
    {
        return (string) (($rowIndex === 0) ? Arr::get($activityArray, 'default_field_values.default_language', '') : '');
    }

    /**
     * Get activity humanitarian.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getHumanitarian($activityArray, $rowIndex): ?string
    {
        return (string) (($rowIndex === 0) ? Arr::get($activityArray, 'default_field_values.humanitarian', '') : '');
    }

    /**
     * Get reporting org reference.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getReportingOrgReference($activityArray, $rowIndex): ?string
    {
        return (string) (Arr::get($activityArray, 'reporting_org.' . $rowIndex . '.ref', ''));
    }

    /**
     * Get reporting org type.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getReportingOrgType($activityArray, $rowIndex): ?string
    {
        return (string) (Arr::get($activityArray, 'reporting_org.' . $rowIndex . '.type', ''));
    }

    /**
     * Get reporting org secondary reporter.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getReportingOrgSecondaryReporter($activityArray, $rowIndex): ?string
    {
        return (string) (Arr::get($activityArray, 'reporting_org.' . $rowIndex . '.secondary_reporter', ''));
    }

    /**
     * Get reporting org narrative.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getReportingOrgNarrative($activityArray, $rowIndex): ?string
    {
        return $this->getNarrativeText(Arr::get($activityArray, 'reporting_org.' . $rowIndex . '.narrative', []), Arr::get($activityArray, 'default_field_values.default_language', ''));
    }

    /**
     * Get activity title.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getActivityTitle($activityArray, $rowIndex): ?string
    {
        return ($rowIndex === 0) ? $this->getNarrativeText(Arr::get($activityArray, 'title', []), Arr::get($activityArray, 'default_field_values.default_language', '')) : '';
    }

    /**
     * Get activity general description.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getActivityDescriptionGeneral($activityArray, $rowIndex): ?string
    {
        return ($rowIndex === 0) ? $this->getDescriptionText(Arr::get($activityArray, 'description', []), Arr::get($activityArray, 'default_field_values.default_language', ''), '1') : '';
    }

    /**
     * Get activity objectives description.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getActivityDescriptionObjectives($activityArray, $rowIndex): ?string
    {
        return ($rowIndex === 0) ? $this->getDescriptionText(Arr::get($activityArray, 'description', []), Arr::get($activityArray, 'default_field_values.default_language', ''), '2') : '';
    }

    /**
     * Get activity target groups description.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getActivityDescriptionTargetGroups($activityArray, $rowIndex): ?string
    {
        return ($rowIndex === 0) ? $this->getDescriptionText(Arr::get($activityArray, 'description', []), Arr::get($activityArray, 'default_field_values.default_language', ''), '3') : '';
    }

    /**
     * Get activity others description.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getActivityDescriptionOthers($activityArray, $rowIndex): ?string
    {
        return ($rowIndex === 0) ? $this->getDescriptionText(Arr::get($activityArray, 'description', []), Arr::get($activityArray, 'default_field_values.default_language', ''), '4') : '';
    }

    /**
     * Get activity status.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return int|null
     */
    public function getActivityStatus($activityArray, $rowIndex): ?int
    {
        return ($rowIndex === 0) ? Arr::get($activityArray, 'activity_status', null) : null;
    }

    /**
     * Get activity actual start date.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getActualStartDate($activityArray, $rowIndex): ?string
    {
        return $this->getActivityDate(Arr::get($activityArray, 'activity_date', []), '2');
    }

    /**
     * Get activity actual end date.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getActualEndDate($activityArray, $rowIndex): ?string
    {
        return $this->getActivityDate(Arr::get($activityArray, 'activity_date', []), '4');
    }

    /**
     * Get activity planned start date.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getPlannedStartDate($activityArray, $rowIndex): ?string
    {
        return $this->getActivityDate(Arr::get($activityArray, 'activity_date', []), '1');
    }

    /**
     * Get activity actual end date.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getPlannedEndDate($activityArray, $rowIndex): ?string
    {
        return $this->getActivityDate(Arr::get($activityArray, 'activity_date', []), '3');
    }

    /**
     * Get activity participating organisation role.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getParticipatingOrganisationRole($activityArray, $rowIndex): ?string
    {
        return (string) (Arr::get($activityArray, 'participating_org.' . $rowIndex . '.organization_role', ''));
    }

    /**
     * Get activity participating organisation reference.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getParticipatingOrganisationReference($activityArray, $rowIndex): ?string
    {
        return (string) (Arr::get($activityArray, 'participating_org.' . $rowIndex . '.ref', ''));
    }

    /**
     * Get activity participating organisation type.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getParticipatingOrganisationType($activityArray, $rowIndex): ?string
    {
        return (string) (Arr::get($activityArray, 'participating_org.' . $rowIndex . '.type', ''));
    }

    /**
     * Get activity participating organisation name.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getParticipatingOrganisationName($activityArray, $rowIndex): ?string
    {
        return $this->getNarrativeText(Arr::get($activityArray, 'participating_org.' . $rowIndex . '.narrative', []), Arr::get($activityArray, 'default_field_values.default_language', ''));
    }

    /**
     * Get activity participating organisation identifier.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getParticipatingOrganisationIdentifier($activityArray, $rowIndex): ?string
    {
        return (string) (Arr::get($activityArray, 'participating_org.' . $rowIndex . '.identifier', ''));
    }

    /**
     * Get activity participating organisation crs channel code.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getParticipatingOrganisationCrsChannelCode($activityArray, $rowIndex): ?string
    {
        return (string) (Arr::get($activityArray, 'participating_org.' . $rowIndex . '.crs_channel_code', ''));
    }

    /**
     * Get activity recipient country code.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getRecipientCountryCode($activityArray, $rowIndex): ?string
    {
        return (string) (Arr::get($activityArray, 'recipient_country.' . $rowIndex . '.country_code', ''));
    }

    /**
     * Get activity recipient country percentage.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getRecipientCountryPercentage($activityArray, $rowIndex): ?string
    {
        return (string) (Arr::get($activityArray, 'recipient_country.' . $rowIndex . '.percentage', ''));
    }

    /**
     * Get activity recipient country narrative.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getRecipientCountryNarrative($activityArray, $rowIndex): ?string
    {
        return $this->getNarrativeText(Arr::get($activityArray, 'recipient_country.' . $rowIndex . '.narrative', []), Arr::get($activityArray, 'default_field_values.default_language', ''));
    }

    /**
     * Get activity recipient region code.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getRecipientRegionCode($activityArray, $rowIndex): ?string
    {
        return (string) ($this->getRecipientRegionCodeFromVocabulary(Arr::get($activityArray, 'recipient_region.' . $rowIndex . '.region_vocabulary', ''), Arr::get($activityArray, 'recipient_region.' . $rowIndex, [])));
    }

    /**
     * Get activity recipient region percentage.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getRecipientRegionPercentage($activityArray, $rowIndex): ?string
    {
        return (string) (Arr::get($activityArray, 'recipient_region.' . $rowIndex . '.percentage', ''));
    }

    /**
     * Get activity recipient region vocabulary uri.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getRecipientRegionVocabularyUri($activityArray, $rowIndex): ?string
    {
        return Arr::get($activityArray, 'recipient_region.' . $rowIndex . '.vocabulary_uri', '');
    }

    /**
     * Get activity recipient region narrative.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getRecipientRegionNarrative($activityArray, $rowIndex): ?string
    {
        return $this->getNarrativeText(Arr::get($activityArray, 'recipient_region.' . $rowIndex . '.narrative', []), Arr::get($activityArray, 'default_field_values.default_language', ''));
    }

    /**
     * Get activity sector vocabulary.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getSectorVocabulary($activityArray, $rowIndex): ?string
    {
        return (string) (Arr::get($activityArray, 'sector.' . $rowIndex . '.sector_vocabulary', ''));
    }

    /**
     * Get activity sector vocabulary uri.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getSectorVocabularyURI($activityArray, $rowIndex): ?string
    {
        return Arr::get($activityArray, 'sector.' . $rowIndex . '.vocabulary_uri', '');
    }

    /**
     * Get activity sector code.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getSectorCode($activityArray, $rowIndex): ?string
    {
        return (string) ($this->getSectorCodeFromVocabulary(Arr::get($activityArray, 'sector.' . $rowIndex . '.sector_vocabulary', ''), Arr::get($activityArray, 'sector.' . $rowIndex, [])));
    }

    /**
     * Get activity sector percentage.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getSectorPercentage($activityArray, $rowIndex): ?string
    {
        return (string) (Arr::get($activityArray, 'sector.' . $rowIndex . '.percentage', ''));
    }

    /**
     * Get activity sector narrative.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getSectorNarrative($activityArray, $rowIndex): ?string
    {
        return $this->getNarrativeText(Arr::get($activityArray, 'sector.' . $rowIndex . '.narrative', []), Arr::get($activityArray, 'default_field_values.default_language', ''));
    }

    /**
     * Get activity policy marker vocabulary.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getPolicyMarkerVocabulary($activityArray, $rowIndex): ?string
    {
        return (string) (Arr::get($activityArray, 'policy_marker.' . $rowIndex . '.policy_marker_vocabulary', ''));
    }

    /**
     * Get activity policy marker code.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getPolicyMarkerCode($activityArray, $rowIndex): ?string
    {
        return (string) ($this->getPolicyMarkerCodeFromVocabulary(Arr::get($activityArray, 'policy_marker.' . $rowIndex . '.policy_marker_vocabulary', ''), Arr::get($activityArray, 'policy_marker.' . $rowIndex, [])));
    }

    /**
     * Get activity policy marker significance.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getPolicyMarkerSignificance($activityArray, $rowIndex): ?string
    {
        return (string) (Arr::get($activityArray, 'policy_marker.' . $rowIndex . '.significance', ''));
    }

    /**
     * Get activity policy marker vocabulary uri.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getPolicyMarkerVocabularyUri($activityArray, $rowIndex): ?string
    {
        return Arr::get($activityArray, 'policy_marker.' . $rowIndex . '.vocabulary_uri', '');
    }

    /**
     * Get activity policy marker narrative.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getPolicyMarkerNarrative($activityArray, $rowIndex): ?string
    {
        return $this->getNarrativeText(Arr::get($activityArray, 'policy_marker.' . $rowIndex . '.narrative', []), Arr::get($activityArray, 'default_field_values.default_language', ''));
    }

    /**
     * Get activity scope.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return int|null
     */
    public function getActivityScope($activityArray, $rowIndex): ?int
    {
        return ($rowIndex === 0) ? Arr::get($activityArray, 'activity_scope', null) : null;
    }

    /**
     * Get activity budget type.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getBudgetType($activityArray, $rowIndex): ?string
    {
        return (string) (Arr::get($activityArray, 'budget.' . $rowIndex . '.budget_type', ''));
    }

    /**
     * Get activity budget status.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getBudgetStatus($activityArray, $rowIndex): ?string
    {
        return (string) (Arr::get($activityArray, 'budget.' . $rowIndex . '.budget_status', ''));
    }

    /**
     * Get activity budget period start.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getBudgetPeriodStart($activityArray, $rowIndex): ?string
    {
        return Arr::get($activityArray, 'budget.' . $rowIndex . '.period_start.0.date', '');
    }

    /**
     * Get activity budget period end.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getBudgetPeriodEnd($activityArray, $rowIndex): ?string
    {
        return Arr::get($activityArray, 'budget.' . $rowIndex . '.period_end.0.date', '');
    }

    /**
     * Get activity budget value.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getBudgetValue($activityArray, $rowIndex): ?string
    {
        return (string) (Arr::get($activityArray, 'budget.' . $rowIndex . '.budget_value.0.amount', ''));
    }

    /**
     * Get activity budget value date.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getBudgetValueDate($activityArray, $rowIndex): ?string
    {
        return Arr::get($activityArray, 'budget.' . $rowIndex . '.budget_value.0.value_date', '');
    }

    /**
     * Get activity budget currency.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getBudgetCurrency($activityArray, $rowIndex): ?string
    {
        return (string) (Arr::get($activityArray, 'budget.' . $rowIndex . '.budget_value.0.currency', ''));
    }

    /**
     * Get activity related activity identifier.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getRelatedActivityIdentifier($activityArray, $rowIndex): ?string
    {
        return (string) (Arr::get($activityArray, 'related_activity.' . $rowIndex . '.activity_identifier', ''));
    }

    /**
     * Get activity related activity type.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getRelatedActivityType($activityArray, $rowIndex): ?string
    {
        return (string) (Arr::get($activityArray, 'related_activity.' . $rowIndex . '.relationship_type', ''));
    }

    /**
     * Get activity collaboration type.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return int|null
     */
    public function getCollaborationType($activityArray, $rowIndex): ?int
    {
        return ($rowIndex === 0) ? Arr::get($activityArray, 'collaboration_type', null) : null;
    }

    /**
     * Get activity default flow type.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return int|null
     */
    public function getDefaultFlowType($activityArray, $rowIndex): ?int
    {
        return ($rowIndex === 0) ? Arr::get($activityArray, 'default_flow_type', null) : null;
    }

    /**
     * Get activity default finance type.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return int|null
     */
    public function getDefaultFinanceType($activityArray, $rowIndex): ?int
    {
        return ($rowIndex === 0) ? Arr::get($activityArray, 'default_finance_type', null) : null;
    }

    /**
     * Get activity default aid type code.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getDefaultAidTypeCode($activityArray, $rowIndex): ?string
    {
        return (string) ($this->getDefaultAidTypeCodeFromVocabulary(Arr::get($activityArray, 'default_aid_type.' . $rowIndex . '.default_aid_type_vocabulary', ''), Arr::get($activityArray, 'default_aid_type.' . $rowIndex, [])));
    }

    /**
     * Get activity default tied status.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return int|null
     */
    public function getDefaultTiedStatus($activityArray, $rowIndex): ?int
    {
        return ($rowIndex === 0) ? Arr::get($activityArray, 'default_tied_status', null) : null;
    }

    /**
     * Get activity capital spend.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getCapitalSpend($activityArray, $rowIndex): ?string
    {
        return (string) (($rowIndex === 0) ? Arr::get($activityArray, 'capital_spend', '') : '');
    }
}
