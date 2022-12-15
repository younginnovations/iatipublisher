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
     * @param $i
     *
     * @return string|null
     */
    public function getActivityIdentifier($activityArray, $i): ?string
    {
        return ($i === 0) ? Arr::get($activityArray, 'iati_identifier.activity_identifier', 'Not Available') : '';
    }

    /**
     * Get activity default currency.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null
     */
    public function getActivityDefaultCurrency($activityArray, $i): ?string
    {
        return ($i === 0) ? Arr::get($activityArray, 'default_field_values.default_language', '') : '';
    }

    /**
     * Get activity default language.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null
     */
    public function getActivityDefaultLanguage($activityArray, $i): ?string
    {
        return ($i === 0) ? Arr::get($activityArray, 'default_field_values.default_language', '') : '';
    }

    /**
     * Get activity humanitarian.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null
     */
    public function getHumanitarian($activityArray, $i): ?string
    {
        return ($i === 0) ? Arr::get($activityArray, 'default_field_values.humanitarian', '') : '';
    }

    /**
     * Get reporting org reference.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null
     */
    public function getReportingOrgReference($activityArray, $i): ?string
    {
        return Arr::get($activityArray, 'reporting_org.' . $i . '.ref', '');
    }

    /**
     * Get reporting org type.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null
     */
    public function getReportingOrgType($activityArray, $i): ?string
    {
        return Arr::get($activityArray, 'reporting_org.' . $i . '.type', '');
    }

    /**
     * Get reporting org secondary reporter.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null
     */
    public function getReportingOrgSecondaryReporter($activityArray, $i): ?string
    {
        return Arr::get($activityArray, 'reporting_org.' . $i . '.secondary_reporter', '');
    }

    /**
     * Get reporting org narrative.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null
     */
    public function getReportingOrgNarrative($activityArray, $i): ?string
    {
        return $this->getNarrativeText(Arr::get($activityArray, 'reporting_org.' . $i . '.narrative', []), Arr::get($activityArray, 'default_field_values.default_language', ''));
    }

    /**
     * Get activity title.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null
     */
    public function getActivityTitle($activityArray, $i): ?string
    {
        return ($i === 0) ? $this->getNarrativeText(Arr::get($activityArray, 'title', []), Arr::get($activityArray, 'default_field_values.default_language', '')) : '';
    }

    /**
     * Get activity general description.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null
     */
    public function getActivityDescriptionGeneral($activityArray, $i): ?string
    {
        return ($i === 0) ? $this->getDescriptionText(Arr::get($activityArray, 'description', []), Arr::get($activityArray, 'default_field_values.default_language', ''), '1') : '';
    }

    /**
     * Get activity objectives description.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null
     */
    public function getActivityDescriptionObjectives($activityArray, $i): ?string
    {
        return ($i === 0) ? $this->getDescriptionText(Arr::get($activityArray, 'description', []), Arr::get($activityArray, 'default_field_values.default_language', ''), '2') : '';
    }

    /**
     * Get activity target groups description.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null
     */
    public function getActivityDescriptionTargetGroups($activityArray, $i): ?string
    {
        return ($i === 0) ? $this->getDescriptionText(Arr::get($activityArray, 'description', []), Arr::get($activityArray, 'default_field_values.default_language', ''), '3') : '';
    }

    /**
     * Get activity others description.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null
     */
    public function getActivityDescriptionOthers($activityArray, $i): ?string
    {
        return ($i === 0) ? $this->getDescriptionText(Arr::get($activityArray, 'description', []), Arr::get($activityArray, 'default_field_values.default_language', ''), '4') : '';
    }

    /**
     * Get activity status.
     *
     * @param $activityArray
     * @param $i
     *
     * @return int|null
     */
    public function getActivityStatus($activityArray, $i): ?int
    {
        return ($i === 0) ? Arr::get($activityArray, 'activity_status', null) : null;
    }

    /**
     * Get activity actual start date.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null
     */
    public function getActualStartDate($activityArray, $i): ?string
    {
        return $this->getActivityDate(Arr::get($activityArray, 'activity_date', []), '2');
    }

    /**
     * Get activity actual end date.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null
     */
    public function getActualEndDate($activityArray, $i): ?string
    {
        return $this->getActivityDate(Arr::get($activityArray, 'activity_date', []), '4');
    }

    /**
     * Get activity planned start date.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null
     */
    public function getPlannedStartDate($activityArray, $i): ?string
    {
        return $this->getActivityDate(Arr::get($activityArray, 'activity_date', []), '1');
    }

    /**
     * Get activity actual end date.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null
     */
    public function getPlannedEndDate($activityArray, $i): ?string
    {
        return $this->getActivityDate(Arr::get($activityArray, 'activity_date', []), '3');
    }

    /**
     * Get activity participating organisation role.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null
     */
    public function getParticipatingOrganisationRole($activityArray, $i): ?string
    {
        return Arr::get($activityArray, 'participating_org.' . $i . '.organization_role', '');
    }

    /**
     * Get activity participating organisation reference.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null
     */
    public function getParticipatingOrganisationReference($activityArray, $i): ?string
    {
        return Arr::get($activityArray, 'participating_org.' . $i . '.ref', '');
    }

    /**
     * Get activity participating organisation type.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null
     */
    public function getParticipatingOrganisationType($activityArray, $i): ?string
    {
        return Arr::get($activityArray, 'participating_org.' . $i . '.type', '');
    }

    /**
     * Get activity participating organisation name.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null
     */
    public function getParticipatingOrganisationName($activityArray, $i): ?string
    {
        return $this->getNarrativeText(Arr::get($activityArray, 'participating_org.' . $i . '.narrative', []), Arr::get($activityArray, 'default_field_values.default_language', ''));
    }

    /**
     * Get activity participating organisation identifier.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null
     */
    public function getParticipatingOrganisationIdentifier($activityArray, $i): ?string
    {
        return Arr::get($activityArray, 'participating_org.' . $i . '.identifier', '');
    }

    /**
     * Get activity participating organisation crs channel code.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null
     */
    public function getParticipatingOrganisationCrsChannelCode($activityArray, $i): ?string
    {
        return Arr::get($activityArray, 'participating_org.' . $i . '.crs_channel_code', '');
    }

    /**
     * Get activity recipient country code.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null
     */
    public function getRecipientCountryCode($activityArray, $i): ?string
    {
        return Arr::get($activityArray, 'recipient_country.' . $i . '.country_code', '');
    }

    /**
     * Get activity recipient country percentage.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null
     */
    public function getRecipientCountryPercentage($activityArray, $i): ?string
    {
        return Arr::get($activityArray, 'recipient_country.' . $i . '.percentage', '');
    }

    /**
     * Get activity recipient country narrative.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null
     */
    public function getRecipientCountryNarrative($activityArray, $i): ?string
    {
        return $this->getNarrativeText(Arr::get($activityArray, 'recipient_country.' . $i . '.narrative', []), Arr::get($activityArray, 'default_field_values.default_language', ''));
    }

    /**
     * Get activity recipient region code.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null
     */
    public function getRecipientRegionCode($activityArray, $i): ?string
    {
        return $this->getRecipientRegionCodeFromVocabulary(Arr::get($activityArray, 'recipient_region.' . $i . '.region_vocabulary', ''), Arr::get($activityArray, 'recipient_region.' . $i, []));
    }

    /**
     * Get activity recipient region percentage.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null
     */
    public function getRecipientRegionPercentage($activityArray, $i): ?string
    {
        return Arr::get($activityArray, 'recipient_region.' . $i . '.percentage', '');
    }

    /**
     * Get activity recipient region vocabulary uri.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null
     */
    public function getRecipientRegionVocabularyUri($activityArray, $i): ?string
    {
        return Arr::get($activityArray, 'recipient_region.' . $i . '.vocabulary_uri', '');
    }

    /**
     * Get activity recipient region narrative.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null
     */
    public function getRecipientRegionNarrative($activityArray, $i): ?string
    {
        return $this->getNarrativeText(Arr::get($activityArray, 'recipient_region.' . $i . '.narrative', []), Arr::get($activityArray, 'default_field_values.default_language', ''));
    }

    /**
     * Get activity sector vocabulary.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null
     */
    public function getSectorVocabulary($activityArray, $i): ?string
    {
        return Arr::get($activityArray, 'sector.' . $i . '.sector_vocabulary', '');
    }

    /**
     * Get activity sector vocabulary uri.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null
     */
    public function getSectorVocabularyURI($activityArray, $i): ?string
    {
        return Arr::get($activityArray, 'sector.' . $i . '.vocabulary_uri', '');
    }

    /**
     * Get activity sector code.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null
     */
    public function getSectorCode($activityArray, $i): ?string
    {
        return $this->getSectorCodeFromVocabulary(Arr::get($activityArray, 'sector.' . $i . '.sector_vocabulary', ''), Arr::get($activityArray, 'sector.' . $i, []));
    }

    /**
     * Get activity sector percentage.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null
     */
    public function getSectorPercentage($activityArray, $i): ?string
    {
        return Arr::get($activityArray, 'sector.' . $i . '.percentage', '');
    }

    /**
     * Get activity sector narrative.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null
     */
    public function getSectorNarrative($activityArray, $i): ?string
    {
        return $this->getNarrativeText(Arr::get($activityArray, 'sector.' . $i . '.narrative', []), Arr::get($activityArray, 'default_field_values.default_language', ''));
    }

    /**
     * Get activity policy marker vocabulary.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null
     */
    public function getPolicyMarkerVocabulary($activityArray, $i): ?string
    {
        return Arr::get($activityArray, 'policy_marker.' . $i . '.policy_marker_vocabulary', '');
    }

    /**
     * Get activity policy marker code.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null
     */
    public function getPolicyMarkerCode($activityArray, $i): ?string
    {
        return $this->getPolicyMarkerCodeFromVocabulary(Arr::get($activityArray, 'policy_marker.' . $i . '.policy_marker_vocabulary', ''), Arr::get($activityArray, 'policy_marker.' . $i, []));
    }

    /**
     * Get activity policy marker significance.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null
     */
    public function getPolicyMarkerSignificance($activityArray, $i): ?string
    {
        return Arr::get($activityArray, 'policy_marker.' . $i . '.significance', '');
    }

    /**
     * Get activity policy marker vocabulary uri.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null
     */
    public function getPolicyMarkerVocabularyUri($activityArray, $i): ?string
    {
        return Arr::get($activityArray, 'policy_marker.' . $i . '.vocabulary_uri', '');
    }

    /**
     * Get activity policy marker narrative.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null
     */
    public function getPolicyMarkerNarrative($activityArray, $i): ?string
    {
        return $this->getNarrativeText(Arr::get($activityArray, 'policy_marker.' . $i . '.narrative', []), Arr::get($activityArray, 'default_field_values.default_language', ''));
    }

    /**
     * Get activity scope.
     *
     * @param $activityArray
     * @param $i
     *
     * @return int|null
     */
    public function getActivityScope($activityArray, $i): ?int
    {
        return ($i === 0) ? Arr::get($activityArray, 'activity_scope', null) : null;
    }

    /**
     * Get activity budget type.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null
     */
    public function getBudgetType($activityArray, $i): ?string
    {
        return Arr::get($activityArray, 'budget.' . $i . '.budget_type', '');
    }

    /**
     * Get activity budget status.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null
     */
    public function getBudgetStatus($activityArray, $i): ?string
    {
        return Arr::get($activityArray, 'budget.' . $i . '.budget_status', '');
    }

    /**
     * Get activity budget period start.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null
     */
    public function getBudgetPeriodStart($activityArray, $i): ?string
    {
        return Arr::get($activityArray, 'budget.' . $i . '.period_start.0.date', '');
    }

    /**
     * Get activity budget period end.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null
     */
    public function getBudgetPeriodEnd($activityArray, $i): ?string
    {
        return Arr::get($activityArray, 'budget.' . $i . '.period_end.0.date', '');
    }

    /**
     * Get activity budget value.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null
     */
    public function getBudgetValue($activityArray, $i): ?string
    {
        return Arr::get($activityArray, 'budget.' . $i . '.budget_value.0.amount', '');
    }

    /**
     * Get activity budget value date.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null
     */
    public function getBudgetValueDate($activityArray, $i): ?string
    {
        return Arr::get($activityArray, 'budget.' . $i . '.budget_value.0.value_date', '');
    }

    /**
     * Get activity budget currency.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null
     */
    public function getBudgetCurrency($activityArray, $i): ?string
    {
        return Arr::get($activityArray, 'budget.' . $i . '.budget_value.0.currency', '');
    }

    /**
     * Get activity related activity identifier.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null
     */
    public function getRelatedActivityIdentifier($activityArray, $i): ?string
    {
        return Arr::get($activityArray, 'related_activity.' . $i . '.activity_identifier', '');
    }

    /**
     * Get activity related activity type.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null
     */
    public function getRelatedActivityType($activityArray, $i): ?string
    {
        return Arr::get($activityArray, 'related_activity.' . $i . '.relationship_type', '');
    }

    /**
     * Get activity collaboration type.
     *
     * @param $activityArray
     * @param $i
     *
     * @return int|null
     */
    public function getCollaborationType($activityArray, $i): ?int
    {
        return ($i === 0) ? Arr::get($activityArray, 'collaboration_type', null) : null;
    }

    /**
     * Get activity default flow type.
     *
     * @param $activityArray
     * @param $i
     *
     * @return int|null
     */
    public function getDefaultFlowType($activityArray, $i): ?int
    {
        return ($i === 0) ? Arr::get($activityArray, 'default_flow_type', null) : null;
    }

    /**
     * Get activity default finance type.
     *
     * @param $activityArray
     * @param $i
     *
     * @return int|null
     */
    public function getDefaultFinanceType($activityArray, $i): ?int
    {
        return ($i === 0) ? Arr::get($activityArray, 'default_finance_type', null) : null;
    }

    /**
     * Get activity default aid type code.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null
     */
    public function getDefaultAidTypeCode($activityArray, $i): ?string
    {
        return $this->getDefaultAidTypeCodeFromVocabulary(Arr::get($activityArray, 'default_aid_type.' . $i . '.default_aid_type_vocabulary', ''), Arr::get($activityArray, 'default_aid_type.' . $i, []));
    }

    /**
     * Get activity default tied status.
     *
     * @param $activityArray
     * @param $i
     *
     * @return int|null
     */
    public function getDefaultTiedStatus($activityArray, $i): ?int
    {
        return ($i === 0) ? Arr::get($activityArray, 'default_tied_status', null) : null;
    }

    /**
     * Get activity capital spend.
     *
     * @param $activityArray
     * @param $i
     *
     * @return mixed
     */
    public function getCapitalSpend($activityArray, $i): mixed
    {
        return ($i === 0) ? Arr::get($activityArray, 'capital_spend', null) : null;
    }
}
