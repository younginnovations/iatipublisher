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
     * @param $i
     *
     * @return string|null|int
     */
    public function getContactType($activityArray, $i): string|int|null
    {
        return Arr::get($activityArray, 'contact_info.' . $i . '.type', '');
    }

    /**
     * Get activity contact organization.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null|int
     */
    public function getContactOrganization($activityArray, $i): string|int|null
    {
        return $this->getNarrativeText(Arr::get($activityArray, 'contact_info.' . $i . '.organisation.0.narrative', []), Arr::get($activityArray, 'default_field_values.default_language', ''));
    }

    /**
     * Get activity contact department.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null|int
     */
    public function getContactDepartment($activityArray, $i): string|int|null
    {
        return $this->getNarrativeText(Arr::get($activityArray, 'contact_info.' . $i . '.department.0.narrative', []), Arr::get($activityArray, 'default_field_values.default_language', ''));
    }

    /**
     * Get activity contact person name.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null|int
     */
    public function getContactPersonName($activityArray, $i): string|int|null
    {
        return $this->getNarrativeText(Arr::get($activityArray, 'contact_info.' . $i . '.person_name.0.narrative', []), Arr::get($activityArray, 'default_field_values.default_language', ''));
    }

    /**
     * Get activity contact job title.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null|int
     */
    public function getContactJobTitle($activityArray, $i): string|int|null
    {
        return $this->getNarrativeText(Arr::get($activityArray, 'contact_info.' . $i . '.job_title.0.narrative', []), Arr::get($activityArray, 'default_field_values.default_language', ''));
    }

    /**
     * Get activity contact telephone.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null|int
     */
    public function getContactTelephone($activityArray, $i): string|int|null
    {
        return Arr::get($activityArray, 'contact_info.' . $i . '.telephone.0.telephone', '');
    }

    /**
     * Get activity contact email.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null|int
     */
    public function getContactEmail($activityArray, $i): string|int|null
    {
        return Arr::get($activityArray, 'contact_info.' . $i . '.email.0.email', '');
    }

    /**
     * Get activity contact website.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null|int
     */
    public function getContactWebsite($activityArray, $i): string|int|null
    {
        return Arr::get($activityArray, 'contact_info.' . $i . '.website.0.website', '');
    }

    /**
     * Get activity contact mailing address.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null|int
     */
    public function getContactMailingAddress($activityArray, $i): string|int|null
    {
        return $this->getMailingAddressText(Arr::get($activityArray, 'contact_info.' . $i . '.mailing_address', []), Arr::get($activityArray, 'default_field_values.default_language', ''));
    }

    /**
     * Get activity other identifier reference.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null|int
     */
    public function getOtherIdentifierReference($activityArray, $i): string|int|null
    {
        return Arr::get($activityArray, 'other_identifier.' . $i . '.reference', '');
    }

    /**
     * Get activity other identifier type.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null|int
     */
    public function getOtherIdentifierType($activityArray, $i): string|int|null
    {
        return Arr::get($activityArray, 'other_identifier.' . $i . '.reference_type', '');
    }

    /**
     * Get activity owner org reference.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null|int
     */
    public function getOwnerOrgReference($activityArray, $i): string|int|null
    {
        return Arr::get($activityArray, 'other_identifier.' . $i . '.owner_org.0.ref', '');
    }

    /**
     * Get activity owner org narrative.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null|int
     */
    public function getOwnerOrgNarrative($activityArray, $i): string|int|null
    {
        return $this->getNarrativeText(Arr::get($activityArray, 'other_identifier.' . $i . '.owner_org.0.narrative', []), Arr::get($activityArray, 'default_field_values.default_language', ''));
    }

    /**
     * Get activity tag vocabulary.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null|int
     */
    public function getTagVocabulary($activityArray, $i): string|int|null
    {
        return Arr::get($activityArray, 'tag.' . $i . '.tag_vocabulary', '');
    }

    /**
     * Get activity tag code.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null|int
     */
    public function getTagCode($activityArray, $i): string|int|null
    {
        return $this->getTagCodeFromVocabulary(Arr::get($activityArray, 'tag.' . $i . '.tag_vocabulary', ''), Arr::get($activityArray, 'tag.' . $i, []));
    }

    /**
     * Get activity tag vocabulary uri.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null|int
     */
    public function getTagVocabularyUri($activityArray, $i): string|int|null
    {
        return Arr::get($activityArray, 'tag.' . $i . '.vocabulary_uri', '');
    }

    /**
     * Get activity tag narrative.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null|int
     */
    public function getTagNarrative($activityArray, $i): string|int|null
    {
        return $this->getNarrativeText(Arr::get($activityArray, 'tag.' . $i . '.narrative', []), Arr::get($activityArray, 'default_field_values.default_language', ''));
    }

    /**
     * Get activity default aid type vocabulary.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null|int
     */
    public function getDefaultAidTypeVocabulary($activityArray, $i): string|int|null
    {
        return Arr::get($activityArray, 'default_aid_type.' . $i . '.default_aid_type_vocabulary', '');
    }

    /**
     * Get activity country budget item vocabulary.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null|int
     */
    public function getCountryBudgetItemVocabulary($activityArray, $i): string|int|null
    {
        return ($i === 0) ? Arr::get($activityArray, 'country_budget_items.country_budget_vocabulary', '') : '';
    }

    /**
     * Get activity budget item code.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null|int
     */
    public function getBudgetItemCode($activityArray, $i): string|int|null
    {
        return Arr::get($activityArray, 'country_budget_items.budget_item.' . $i . '.code', '');
    }

    /**
     * Get activity budget item percentage.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null|int
     */
    public function getBudgetItemPercentage($activityArray, $i): string|int|null
    {
        return Arr::get($activityArray, 'country_budget_items.budget_item.' . $i . '.percentage', '');
    }

    /**
     * Get activity budget item description.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null|int
     */
    public function getBudgetItemDescription($activityArray, $i): string|int|null
    {
        return $this->getNarrativeText(Arr::get($activityArray, 'country_budget_items.budget_item.' . $i . '.description.0.narrative', []), Arr::get($activityArray, 'default_field_values.default_language', ''));
    }

    /**
     * Get activity humanitarian scope type.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null|int
     */
    public function getHumanitarianScopeType($activityArray, $i): string|int|null
    {
        return Arr::get($activityArray, 'humanitarian_scope.' . $i . '.type', '');
    }

    /**
     * Get activity humanitarian scope vocabulary.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null|int
     */
    public function getHumanitarianScopeVocabulary($activityArray, $i): string|int|null
    {
        return Arr::get($activityArray, 'humanitarian_scope.' . $i . '.vocabulary', '');
    }

    /**
     * Get activity humanitarian scope vocabulary uri.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null|int
     */
    public function getHumanitarianScopeVocabularyUri($activityArray, $i): string|int|null
    {
        return Arr::get($activityArray, 'humanitarian_scope.' . $i . '.vocabulary_uri', '');
    }

    /**
     * Get activity humanitarian scope code.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null|int
     */
    public function getHumanitarianScopeCode($activityArray, $i): string|int|null
    {
        return Arr::get($activityArray, 'humanitarian_scope.' . $i . '.code', '');
    }

    /**
     * Get activity humanitarian scope narrative.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null|int
     */
    public function getHumanitarianScopeNarrative($activityArray, $i): string|int|null
    {
        return $this->getNarrativeText(Arr::get($activityArray, 'humanitarian_scope.' . $i . '.narrative', []), Arr::get($activityArray, 'default_field_values.default_language', ''));
    }

    /**
     * Get activity conditions attached.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null|int
     */
    public function getConditionsAttached($activityArray, $i): string|int|null
    {
        return ($i === 0) ? Arr::get($activityArray, 'conditions.condition_attached', '') : '';
    }

    /**
     * Get activity condition type.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null|int
     */
    public function getConditionType($activityArray, $i): string|int|null
    {
        return Arr::get($activityArray, 'conditions.condition.' . $i . '.condition_type', '');
    }

    /**
     * Get activity condition narrative.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null|int
     */
    public function getConditionNarrative($activityArray, $i): string|int|null
    {
        return $this->getNarrativeText(Arr::get($activityArray, 'conditions.condition.' . $i . '.narrative', []), Arr::get($activityArray, 'default_field_values.default_language', ''));
    }

    /**
     * Get activity legacy data name.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null|int
     */
    public function getLegacyDataName($activityArray, $i): string|int|null
    {
        return Arr::get($activityArray, 'legacy_data.' . $i . '.legacy_name', '');
    }

    /**
     * Get activity legacy data value.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null|int
     */
    public function getLegacyDataValue($activityArray, $i): string|int|null
    {
        return Arr::get($activityArray, 'legacy_data.' . $i . '.value', '');
    }

    /**
     * Get activity legacy data IATI equivalent.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null|int
     */
    public function getLegacyDataIATIEquivalent($activityArray, $i): string|int|null
    {
        return Arr::get($activityArray, 'legacy_data.' . $i . '.iati_equivalent', '');
    }

    /**
     * Get activity document link url.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null|int
     */
    public function getDocumentLinkUrl($activityArray, $i): string|int|null
    {
        return Arr::get($activityArray, 'document_link.' . $i . '.url', '');
    }

    /**
     * Get activity document link format.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null|int
     */
    public function getDocumentLinkFormat($activityArray, $i): string|int|null
    {
        return Arr::get($activityArray, 'document_link.' . $i . '.format', '');
    }

    /**
     * Get activity document link title.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null|int
     */
    public function getDocumentLinkTitle($activityArray, $i): string|int|null
    {
        return $this->getNarrativeText(Arr::get($activityArray, 'document_link.' . $i . '.title.0.narrative', []), Arr::get($activityArray, 'default_field_values.default_language', ''));
    }

    /**
     * Get activity document link description.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null|int
     */
    public function getDocumentLinkDescription($activityArray, $i): string|int|null
    {
        return $this->getNarrativeText(Arr::get($activityArray, 'document_link.' . $i . '.description.0.narrative', []), Arr::get($activityArray, 'default_field_values.default_language', ''));
    }

    /**
     * Get activity document link category.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null|int
     */
    public function getDocumentLinkCategory($activityArray, $i): string|int|null
    {
        return Arr::get($activityArray, 'document_link.' . $i . '.category.0.code', '');
    }

    /**
     * Get activity document link language.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null|int
     */
    public function getDocumentLinkLanguage($activityArray, $i): string|int|null
    {
        return Arr::get($activityArray, 'document_link.' . $i . '.language.0.code', '');
    }

    /**
     * Get activity document date.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null|int
     */
    public function getDocumentDate($activityArray, $i): string|int|null
    {
        return Arr::get($activityArray, 'document_link.' . $i . '.document_date.0.date', '');
    }

    /**
     * Get activity location reference.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null|int
     */
    public function getLocationReference($activityArray, $i): string|int|null
    {
        return Arr::get($activityArray, 'location.' . $i . '.ref', '');
    }

    /**
     * Get activity location reach code.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null|int
     */
    public function getLocationReachCode($activityArray, $i): string|int|null
    {
        return Arr::get($activityArray, 'location.' . $i . '.location_reach.0.code', '');
    }

    /**
     * Get activity location id vocabulary.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null|int
     */
    public function getLocationIdVocabulary($activityArray, $i): string|int|null
    {
        return Arr::get($activityArray, 'location.' . $i . '.location_reach.0.vocabulary', '');
    }

    /**
     * Get activity location id code.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null|int
     */
    public function getLocationIdCode($activityArray, $i): string|int|null
    {
        return Arr::get($activityArray, 'location.' . $i . '.location_reach.0.code', '');
    }

    /**
     * Get activity location name.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null|int
     */
    public function getLocationName($activityArray, $i): string|int|null
    {
        return $this->getNarrativeText(Arr::get($activityArray, 'location.' . $i . '.name.0.narrative', []), Arr::get($activityArray, 'default_field_values.default_language', ''));
    }

    /**
     * Get activity location description.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null|int
     */
    public function getLocationDescription($activityArray, $i): string|int|null
    {
        return $this->getNarrativeText(Arr::get($activityArray, 'location.' . $i . '.description.0.narrative', []), Arr::get($activityArray, 'default_field_values.default_language', ''));
    }

    /**
     * Get activity location activity description.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null|int
     */
    public function getLocationActivityDescription($activityArray, $i): string|int|null
    {
        return $this->getNarrativeText(Arr::get($activityArray, 'location.' . $i . '.activity_description.0.narrative', []), Arr::get($activityArray, 'default_field_values.default_language', ''));
    }

    /**
     * Get activity location administrative vocabulary.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null|int
     */
    public function getLocationAdministrativeVocabulary($activityArray, $i): string|int|null
    {
        return Arr::get($activityArray, 'location.' . $i . '.administrative.0.vocabulary', '');
    }

    /**
     * Get activity location administrative code.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null|int
     */
    public function getLocationAdministrativeCode($activityArray, $i): string|int|null
    {
        return Arr::get($activityArray, 'location.' . $i . '.administrative.0.code', '');
    }

    /**
     * Get activity location administrative level.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null|int
     */
    public function getLocationAdministrativeLevel($activityArray, $i): string|int|null
    {
        return Arr::get($activityArray, 'location.' . $i . '.administrative.0.level', '');
    }

    /**
     * Get activity location point srsName.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null|int
     */
    public function getLocationPointsrsName($activityArray, $i): string|int|null
    {
        return Arr::get($activityArray, 'location.' . $i . '.point.0.srs_name', '');
    }

    /**
     * Get activity pos latitude.
     *
     * @param $activityArray
     * @param $i
     *
     * @return mixed
     */
    public function getPosLatitude($activityArray, $i): mixed
    {
        return Arr::get($activityArray, 'location.' . $i . '.point.0.pos.0.latitude', null);
    }

    /**
     * Get activity pos longitude.
     *
     * @param $activityArray
     * @param $i
     *
     * @return mixed
     */
    public function getPosLongitude($activityArray, $i): mixed
    {
        return Arr::get($activityArray, 'location.' . $i . '.point.0.pos.0.longitude', null);
    }

    /**
     * Get activity location exactness.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null|int
     */
    public function getLocationExactness($activityArray, $i): string|int|null
    {
        return Arr::get($activityArray, 'location.' . $i . '.exactness.0.code', '');
    }

    /**
     * Get activity location class.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null|int
     */
    public function getLocationClass($activityArray, $i): string|int|null
    {
        return Arr::get($activityArray, 'location.' . $i . '.location_class.0.code', '');
    }

    /**
     * Get activity feature designation.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null|int
     */
    public function getFeatureDesignation($activityArray, $i): string|int|null
    {
        return Arr::get($activityArray, 'location.' . $i . '.feature_designation.0.code', '');
    }

    /**
     * Get activity planned disbursement type.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null|int
     */
    public function getPlannedDisbursementType($activityArray, $i): string|int|null
    {
        return Arr::get($activityArray, 'planned_disbursement.' . $i . '.planned_disbursement_type', '');
    }

    /**
     * Get activity planned disbursement period start.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null|int
     */
    public function getPlannedDisbursementPeriodStart($activityArray, $i): string|int|null
    {
        return Arr::get($activityArray, 'planned_disbursement.' . $i . '.period_start.0.date', '');
    }

    /**
     * Get activity planned disbursement period end.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null|int
     */
    public function getPlannedDisbursementPeriodEnd($activityArray, $i): string|int|null
    {
        return Arr::get($activityArray, 'planned_disbursement.' . $i . '.period_end.0.date', '');
    }

    /**
     * Get activity planned disbursement value.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null|int
     */
    public function getPlannedDisbursementValue($activityArray, $i): string|int|null
    {
        return Arr::get($activityArray, 'planned_disbursement.' . $i . '.value.0.amount', '');
    }

    /**
     * Get activity planned disbursement value currency.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null|int
     */
    public function getPlannedDisbursementValueCurrency($activityArray, $i): string|int|null
    {
        return Arr::get($activityArray, 'planned_disbursement.' . $i . '.value.0.currency', '');
    }

    /**
     * Get activity planned disbursement value date.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null|int
     */
    public function getPlannedDisbursementValueDate($activityArray, $i): string|int|null
    {
        return Arr::get($activityArray, 'planned_disbursement.' . $i . '.value.0.value_date', '');
    }

    /**
     * Get activity planned disbursement provider org reference.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null|int
     */
    public function getPlannedDisbursementProviderOrgReference($activityArray, $i): string|int|null
    {
        return Arr::get($activityArray, 'planned_disbursement.' . $i . '.provider_org.0.ref', '');
    }

    /**
     * Get activity planned disbursement provider org activity id.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null|int
     */
    public function getPlannedDisbursementProviderOrgActivityId($activityArray, $i): string|int|null
    {
        return Arr::get($activityArray, 'planned_disbursement.' . $i . '.provider_org.0.provider_activity_id', '');
    }

    /**
     * Get activity planned disbursement provider org type.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null|int
     */
    public function getPlannedDisbursementProviderOrgType($activityArray, $i): string|int|null
    {
        return Arr::get($activityArray, 'planned_disbursement.' . $i . '.provider_org.0.type', '');
    }

    /**
     * Get activity planned disbursement provider org narrative.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null|int
     */
    public function getPlannedDisbursementProviderOrgNarrative($activityArray, $i): string|int|null
    {
        return $this->getNarrativeText(Arr::get($activityArray, 'planned_disbursement.' . $i . '.provider_org.0.narrative', []), Arr::get($activityArray, 'default_field_values.default_language', ''));
    }

    /**
     * Get activity planned disbursement receiver org reference.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null|int
     */
    public function getPlannedDisbursementReceiverOrgReference($activityArray, $i): string|int|null
    {
        return Arr::get($activityArray, 'planned_disbursement.' . $i . '.receiver_org.0.ref', '');
    }

    /**
     * Get activity planned disbursement receiver org activity id.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null|int
     */
    public function getPlannedDisbursementReceiverOrgActivityId($activityArray, $i): string|int|null
    {
        return Arr::get($activityArray, 'planned_disbursement.' . $i . '.receiver_org.0.receiver_activity_id', '');
    }

    /**
     * Get activity planned disbursement receiver org type.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null|int
     */
    public function getPlannedDisbursementReceiverOrgType($activityArray, $i): string|int|null
    {
        return Arr::get($activityArray, 'planned_disbursement.' . $i . '.receiver_org.0.type', '');
    }

    /**
     * Get activity planned disbursement receiver org narrative.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null|int
     */
    public function getPlannedDisbursementReceiverOrgNarrative($activityArray, $i): string|int|null
    {
        return $this->getNarrativeText(Arr::get($activityArray, 'planned_disbursement.' . $i . '.receiver_org.0.narrative', []), Arr::get($activityArray, 'default_field_values.default_language', ''));
    }
}
