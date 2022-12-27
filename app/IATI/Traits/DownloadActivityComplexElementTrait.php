<?php

declare(strict_types=1);

namespace App\IATI\Traits;

use Illuminate\Support\Arr;

/**
 * Class DownloadActivityComplexElementTrait.
 */
trait DownloadActivityComplexElementTrait
{
    /**
     * Get activity contact type.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getContactType($activityArray, $rowIndex): ?string
    {
        return (string) (Arr::get($activityArray, 'contact_info.' . $rowIndex . '.type', ''));
    }

    /**
     * Get activity contact organization.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getContactOrganization($activityArray, $rowIndex): ?string
    {
        return $this->getNarrativeText(Arr::get($activityArray, 'contact_info.' . $rowIndex . '.organisation.0.narrative', []), Arr::get($activityArray, 'default_field_values.default_language', ''));
    }

    /**
     * Get activity contact department.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getContactDepartment($activityArray, $rowIndex): ?string
    {
        return $this->getNarrativeText(Arr::get($activityArray, 'contact_info.' . $rowIndex . '.department.0.narrative', []), Arr::get($activityArray, 'default_field_values.default_language', ''));
    }

    /**
     * Get activity contact person name.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getContactPersonName($activityArray, $rowIndex): ?string
    {
        return $this->getNarrativeText(Arr::get($activityArray, 'contact_info.' . $rowIndex . '.person_name.0.narrative', []), Arr::get($activityArray, 'default_field_values.default_language', ''));
    }

    /**
     * Get activity contact job title.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getContactJobTitle($activityArray, $rowIndex): ?string
    {
        return $this->getNarrativeText(Arr::get($activityArray, 'contact_info.' . $rowIndex . '.job_title.0.narrative', []), Arr::get($activityArray, 'default_field_values.default_language', ''));
    }

    /**
     * Get activity contact telephone.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getContactTelephone($activityArray, $rowIndex): ?string
    {
        return (string) (Arr::get($activityArray, 'contact_info.' . $rowIndex . '.telephone.0.telephone', ''));
    }

    /**
     * Get activity contact email.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getContactEmail($activityArray, $rowIndex): ?string
    {
        return Arr::get($activityArray, 'contact_info.' . $rowIndex . '.email.0.email', '');
    }

    /**
     * Get activity contact website.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getContactWebsite($activityArray, $rowIndex): ?string
    {
        return Arr::get($activityArray, 'contact_info.' . $rowIndex . '.website.0.website', '');
    }

    /**
     * Get activity contact mailing address.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getContactMailingAddress($activityArray, $rowIndex): ?string
    {
        return $this->getMailingAddressText(Arr::get($activityArray, 'contact_info.' . $rowIndex . '.mailing_address', []), Arr::get($activityArray, 'default_field_values.default_language', ''));
    }

    /**
     * Get activity other identifier reference.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getOtherIdentifierReference($activityArray, $rowIndex): ?string
    {
        return (string) (Arr::get($activityArray, 'other_identifier.' . $rowIndex . '.reference', ''));
    }

    /**
     * Get activity other identifier type.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getOtherIdentifierType($activityArray, $rowIndex): ?string
    {
        return (string) (Arr::get($activityArray, 'other_identifier.' . $rowIndex . '.reference_type', ''));
    }

    /**
     * Get activity owner org reference.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getOwnerOrgReference($activityArray, $rowIndex): ?string
    {
        return (string) (Arr::get($activityArray, 'other_identifier.' . $rowIndex . '.owner_org.0.ref', ''));
    }

    /**
     * Get activity owner org narrative.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getOwnerOrgNarrative($activityArray, $rowIndex): ?string
    {
        return $this->getNarrativeText(Arr::get($activityArray, 'other_identifier.' . $rowIndex . '.owner_org.0.narrative', []), Arr::get($activityArray, 'default_field_values.default_language', ''));
    }

    /**
     * Get activity tag vocabulary.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getTagVocabulary($activityArray, $rowIndex): ?string
    {
        return (string) (Arr::get($activityArray, 'tag.' . $rowIndex . '.tag_vocabulary', ''));
    }

    /**
     * Get activity tag code.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getTagCode($activityArray, $rowIndex): ?string
    {
        return (string) ($this->getTagCodeFromVocabulary(Arr::get($activityArray, 'tag.' . $rowIndex . '.tag_vocabulary', ''), Arr::get($activityArray, 'tag.' . $rowIndex, [])));
    }

    /**
     * Get activity tag vocabulary uri.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getTagVocabularyUri($activityArray, $rowIndex): ?string
    {
        return Arr::get($activityArray, 'tag.' . $rowIndex . '.vocabulary_uri', '');
    }

    /**
     * Get activity tag narrative.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getTagNarrative($activityArray, $rowIndex): ?string
    {
        return $this->getNarrativeText(Arr::get($activityArray, 'tag.' . $rowIndex . '.narrative', []), Arr::get($activityArray, 'default_field_values.default_language', ''));
    }

    /**
     * Get activity default aid type vocabulary.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getDefaultAidTypeVocabulary($activityArray, $rowIndex): ?string
    {
        return (string) (Arr::get($activityArray, 'default_aid_type.' . $rowIndex . '.default_aid_type_vocabulary', ''));
    }

    /**
     * Get activity country budget item vocabulary.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getCountryBudgetItemVocabulary($activityArray, $rowIndex): ?string
    {
        return (string) (($rowIndex === 0) ? Arr::get($activityArray, 'country_budget_items.country_budget_vocabulary', '') : '');
    }

    /**
     * Get activity budget item code.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getBudgetItemCode($activityArray, $rowIndex): ?string
    {
        return (string) (Arr::get($activityArray, 'country_budget_items.budget_item.' . $rowIndex . '.code', ''));
    }

    /**
     * Get activity budget item percentage.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getBudgetItemPercentage($activityArray, $rowIndex): ?string
    {
        return (string) (Arr::get($activityArray, 'country_budget_items.budget_item.' . $rowIndex . '.percentage', ''));
    }

    /**
     * Get activity budget item description.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getBudgetItemDescription($activityArray, $rowIndex): ?string
    {
        return $this->getNarrativeText(Arr::get($activityArray, 'country_budget_items.budget_item.' . $rowIndex . '.description.0.narrative', []), Arr::get($activityArray, 'default_field_values.default_language', ''));
    }

    /**
     * Get activity humanitarian scope type.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getHumanitarianScopeType($activityArray, $rowIndex): ?string
    {
        return (string) (Arr::get($activityArray, 'humanitarian_scope.' . $rowIndex . '.type', ''));
    }

    /**
     * Get activity humanitarian scope vocabulary.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getHumanitarianScopeVocabulary($activityArray, $rowIndex): ?string
    {
        return (string) (Arr::get($activityArray, 'humanitarian_scope.' . $rowIndex . '.vocabulary', ''));
    }

    /**
     * Get activity humanitarian scope vocabulary uri.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getHumanitarianScopeVocabularyUri($activityArray, $rowIndex): ?string
    {
        return Arr::get($activityArray, 'humanitarian_scope.' . $rowIndex . '.vocabulary_uri', '');
    }

    /**
     * Get activity humanitarian scope code.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getHumanitarianScopeCode($activityArray, $rowIndex): ?string
    {
        return (string) (Arr::get($activityArray, 'humanitarian_scope.' . $rowIndex . '.code', ''));
    }

    /**
     * Get activity humanitarian scope narrative.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getHumanitarianScopeNarrative($activityArray, $rowIndex): ?string
    {
        return $this->getNarrativeText(Arr::get($activityArray, 'humanitarian_scope.' . $rowIndex . '.narrative', []), Arr::get($activityArray, 'default_field_values.default_language', ''));
    }

    /**
     * Get activity conditions attached.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getConditionsAttached($activityArray, $rowIndex): ?string
    {
        return (string) (($rowIndex === 0) ? Arr::get($activityArray, 'conditions.condition_attached', '') : '');
    }

    /**
     * Get activity condition type.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getConditionType($activityArray, $rowIndex): ?string
    {
        return (string) (Arr::get($activityArray, 'conditions.condition.' . $rowIndex . '.condition_type', ''));
    }

    /**
     * Get activity condition narrative.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getConditionNarrative($activityArray, $rowIndex): ?string
    {
        return $this->getNarrativeText(Arr::get($activityArray, 'conditions.condition.' . $rowIndex . '.narrative', []), Arr::get($activityArray, 'default_field_values.default_language', ''));
    }

    /**
     * Get activity legacy data name.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getLegacyDataName($activityArray, $rowIndex): ?string
    {
        return (string) (Arr::get($activityArray, 'legacy_data.' . $rowIndex . '.legacy_name', ''));
    }

    /**
     * Get activity legacy data value.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getLegacyDataValue($activityArray, $rowIndex): ?string
    {
        return (string) (Arr::get($activityArray, 'legacy_data.' . $rowIndex . '.value', ''));
    }

    /**
     * Get activity legacy data IATI equivalent.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getLegacyDataIATIEquivalent($activityArray, $rowIndex): ?string
    {
        return (string) (Arr::get($activityArray, 'legacy_data.' . $rowIndex . '.iati_equivalent', ''));
    }

    /**
     * Get activity document link url.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getDocumentLinkUrl($activityArray, $rowIndex): ?string
    {
        return Arr::get($activityArray, 'document_link.' . $rowIndex . '.url', '');
    }

    /**
     * Get activity document link format.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getDocumentLinkFormat($activityArray, $rowIndex): ?string
    {
        return Arr::get($activityArray, 'document_link.' . $rowIndex . '.format', '');
    }

    /**
     * Get activity document link title.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getDocumentLinkTitle($activityArray, $rowIndex): ?string
    {
        return $this->getNarrativeText(Arr::get($activityArray, 'document_link.' . $rowIndex . '.title.0.narrative', []), Arr::get($activityArray, 'default_field_values.default_language', ''));
    }

    /**
     * Get activity document link description.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getDocumentLinkDescription($activityArray, $rowIndex): ?string
    {
        return $this->getNarrativeText(Arr::get($activityArray, 'document_link.' . $rowIndex . '.description.0.narrative', []), Arr::get($activityArray, 'default_field_values.default_language', ''));
    }

    /**
     * Get activity document link category.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getDocumentLinkCategory($activityArray, $rowIndex): ?string
    {
        return (string) (Arr::get($activityArray, 'document_link.' . $rowIndex . '.category.0.code', ''));
    }

    /**
     * Get activity document link language.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getDocumentLinkLanguage($activityArray, $rowIndex): ?string
    {
        return (string) (Arr::get($activityArray, 'document_link.' . $rowIndex . '.language.0.code', ''));
    }

    /**
     * Get activity document date.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getDocumentDate($activityArray, $rowIndex): ?string
    {
        return Arr::get($activityArray, 'document_link.' . $rowIndex . '.document_date.0.date', '');
    }

    /**
     * Get activity location reference.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getLocationReference($activityArray, $rowIndex): ?string
    {
        return (string) (Arr::get($activityArray, 'location.' . $rowIndex . '.ref', ''));
    }

    /**
     * Get activity location reach code.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getLocationReachCode($activityArray, $rowIndex): ?string
    {
        return (string) (Arr::get($activityArray, 'location.' . $rowIndex . '.location_reach.0.code', ''));
    }

    /**
     * Get activity location id vocabulary.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getLocationIdVocabulary($activityArray, $rowIndex): ?string
    {
        return (string) (Arr::get($activityArray, 'location.' . $rowIndex . '.location_id.0.vocabulary', ''));
    }

    /**
     * Get activity location id code.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getLocationIdCode($activityArray, $rowIndex): ?string
    {
        return (string) (Arr::get($activityArray, 'location.' . $rowIndex . '.location_id.0.code', ''));
    }

    /**
     * Get activity location name.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getLocationName($activityArray, $rowIndex): ?string
    {
        return $this->getNarrativeText(Arr::get($activityArray, 'location.' . $rowIndex . '.name.0.narrative', []), Arr::get($activityArray, 'default_field_values.default_language', ''));
    }

    /**
     * Get activity location description.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getLocationDescription($activityArray, $rowIndex): ?string
    {
        return $this->getNarrativeText(Arr::get($activityArray, 'location.' . $rowIndex . '.description.0.narrative', []), Arr::get($activityArray, 'default_field_values.default_language', ''));
    }

    /**
     * Get activity location activity description.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getLocationActivityDescription($activityArray, $rowIndex): ?string
    {
        return $this->getNarrativeText(Arr::get($activityArray, 'location.' . $rowIndex . '.activity_description.0.narrative', []), Arr::get($activityArray, 'default_field_values.default_language', ''));
    }

    /**
     * Get activity location administrative vocabulary.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getLocationAdministrativeVocabulary($activityArray, $rowIndex): ?string
    {
        return (string) (Arr::get($activityArray, 'location.' . $rowIndex . '.administrative.0.vocabulary', ''));
    }

    /**
     * Get activity location administrative code.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getLocationAdministrativeCode($activityArray, $rowIndex): ?string
    {
        return (string) (Arr::get($activityArray, 'location.' . $rowIndex . '.administrative.0.code', ''));
    }

    /**
     * Get activity location administrative level.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getLocationAdministrativeLevel($activityArray, $rowIndex): ?string
    {
        return (string) (Arr::get($activityArray, 'location.' . $rowIndex . '.administrative.0.level', ''));
    }

    /**
     * Get activity location point srsName.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getLocationPointsrsName($activityArray, $rowIndex): ?string
    {
        return Arr::get($activityArray, 'location.' . $rowIndex . '.point.0.srs_name', '');
    }

    /**
     * Get activity pos latitude.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getPosLatitude($activityArray, $rowIndex): ?string
    {
        return (string) (Arr::get($activityArray, 'location.' . $rowIndex . '.point.0.pos.0.latitude', ''));
    }

    /**
     * Get activity pos longitude.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getPosLongitude($activityArray, $rowIndex): ?string
    {
        return (string) (Arr::get($activityArray, 'location.' . $rowIndex . '.point.0.pos.0.longitude', ''));
    }

    /**
     * Get activity location exactness.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getLocationExactness($activityArray, $rowIndex): ?string
    {
        return (string) (Arr::get($activityArray, 'location.' . $rowIndex . '.exactness.0.code', ''));
    }

    /**
     * Get activity location class.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getLocationClass($activityArray, $rowIndex): ?string
    {
        return (string) (Arr::get($activityArray, 'location.' . $rowIndex . '.location_class.0.code', ''));
    }

    /**
     * Get activity feature designation.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getFeatureDesignation($activityArray, $rowIndex): ?string
    {
        return (string) (Arr::get($activityArray, 'location.' . $rowIndex . '.feature_designation.0.code', ''));
    }

    /**
     * Get activity planned disbursement type.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getPlannedDisbursementType($activityArray, $rowIndex): ?string
    {
        return (string) (Arr::get($activityArray, 'planned_disbursement.' . $rowIndex . '.planned_disbursement_type', ''));
    }

    /**
     * Get activity planned disbursement period start.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getPlannedDisbursementPeriodStart($activityArray, $rowIndex): ?string
    {
        return Arr::get($activityArray, 'planned_disbursement.' . $rowIndex . '.period_start.0.date', '');
    }

    /**
     * Get activity planned disbursement period end.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getPlannedDisbursementPeriodEnd($activityArray, $rowIndex): ?string
    {
        return Arr::get($activityArray, 'planned_disbursement.' . $rowIndex . '.period_end.0.date', '');
    }

    /**
     * Get activity planned disbursement value.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getPlannedDisbursementValue($activityArray, $rowIndex): ?string
    {
        return (string) (Arr::get($activityArray, 'planned_disbursement.' . $rowIndex . '.value.0.amount', ''));
    }

    /**
     * Get activity planned disbursement value currency.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getPlannedDisbursementValueCurrency($activityArray, $rowIndex): ?string
    {
        return (string) (Arr::get($activityArray, 'planned_disbursement.' . $rowIndex . '.value.0.currency', ''));
    }

    /**
     * Get activity planned disbursement value date.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getPlannedDisbursementValueDate($activityArray, $rowIndex): ?string
    {
        return Arr::get($activityArray, 'planned_disbursement.' . $rowIndex . '.value.0.value_date', '');
    }

    /**
     * Get activity planned disbursement provider org reference.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getPlannedDisbursementProviderOrgReference($activityArray, $rowIndex): ?string
    {
        return (string) (Arr::get($activityArray, 'planned_disbursement.' . $rowIndex . '.provider_org.0.ref', ''));
    }

    /**
     * Get activity planned disbursement provider org activity id.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getPlannedDisbursementProviderOrgActivityId($activityArray, $rowIndex): ?string
    {
        return (string) (Arr::get($activityArray, 'planned_disbursement.' . $rowIndex . '.provider_org.0.provider_activity_id', ''));
    }

    /**
     * Get activity planned disbursement provider org type.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getPlannedDisbursementProviderOrgType($activityArray, $rowIndex): ?string
    {
        return (string) (Arr::get($activityArray, 'planned_disbursement.' . $rowIndex . '.provider_org.0.type', ''));
    }

    /**
     * Get activity planned disbursement provider org narrative.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getPlannedDisbursementProviderOrgNarrative($activityArray, $rowIndex): ?string
    {
        return $this->getNarrativeText(Arr::get($activityArray, 'planned_disbursement.' . $rowIndex . '.provider_org.0.narrative', []), Arr::get($activityArray, 'default_field_values.default_language', ''));
    }

    /**
     * Get activity planned disbursement receiver org reference.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getPlannedDisbursementReceiverOrgReference($activityArray, $rowIndex): ?string
    {
        return (string) (Arr::get($activityArray, 'planned_disbursement.' . $rowIndex . '.receiver_org.0.ref', ''));
    }

    /**
     * Get activity planned disbursement receiver org activity id.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getPlannedDisbursementReceiverOrgActivityId($activityArray, $rowIndex): ?string
    {
        return (string) (Arr::get($activityArray, 'planned_disbursement.' . $rowIndex . '.receiver_org.0.receiver_activity_id', ''));
    }

    /**
     * Get activity planned disbursement receiver org type.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getPlannedDisbursementReceiverOrgType($activityArray, $rowIndex): ?string
    {
        return (string) (Arr::get($activityArray, 'planned_disbursement.' . $rowIndex . '.receiver_org.0.type', ''));
    }

    /**
     * Get activity planned disbursement receiver org narrative.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getPlannedDisbursementReceiverOrgNarrative($activityArray, $rowIndex): ?string
    {
        return $this->getNarrativeText(Arr::get($activityArray, 'planned_disbursement.' . $rowIndex . '.receiver_org.0.narrative', []), Arr::get($activityArray, 'default_field_values.default_language', ''));
    }
}
