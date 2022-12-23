<?php

declare(strict_types=1);

namespace App\IATI\Traits;

use Illuminate\Support\Arr;

/**
 * Class DownloadTransactionTrait.
 */
trait DownloadTransactionTrait
{
    /**
     * Get transaction internal reference.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getTransactionInternalReference($activityArray, $rowIndex): ?string
    {
        return (string) (Arr::get($activityArray, 'transactions.' . $rowIndex . '.transaction.reference', ''));
    }

    /**
     * Get transaction type.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getTransactionType($activityArray, $rowIndex): ?string
    {
        return (string) (Arr::get($activityArray, 'transactions.' . $rowIndex . '.transaction.transaction_type.0.transaction_type_code', ''));
    }

    /**
     * Get transaction date.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getTransactionDate($activityArray, $rowIndex): ?string
    {
        return Arr::get($activityArray, 'transactions.' . $rowIndex . '.transaction.transaction_date.0.date', '');
    }

    /**
     * Get transaction value.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getTransactionValue($activityArray, $rowIndex): ?string
    {
        return (string) (Arr::get($activityArray, 'transactions.' . $rowIndex . '.transaction.value.0.amount', ''));
    }

    /**
     * Get transaction value date.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getTransactionValueDate($activityArray, $rowIndex): ?string
    {
        return Arr::get($activityArray, 'transactions.' . $rowIndex . '.transaction.value.0.date', '');
    }

    /**
     * Get transaction description.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getTransactionDescription($activityArray, $rowIndex): ?string
    {
        return $this->getNarrativeText(Arr::get($activityArray, 'transactions.' . $rowIndex . '.transaction.description.0.narrative', []), Arr::get($activityArray, 'default_field_values.default_language', ''));
    }

    /**
     * Get transaction provider organisation identifier.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getTransactionProviderOrganisationIdentifier($activityArray, $rowIndex): ?string
    {
        return (string) (Arr::get($activityArray, 'transactions.' . $rowIndex . '.transaction.provider_organization.0.organization_identifier_code', ''));
    }

    /**
     * Get transaction provider organisation type.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getTransactionProviderOrganisationType($activityArray, $rowIndex): ?string
    {
        return (string) (Arr::get($activityArray, 'transactions.' . $rowIndex . '.transaction.provider_organization.0.type', ''));
    }

    /**
     * Get transaction provider organisation activity identifier.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getTransactionProviderOrganisationActivityIdentifier($activityArray, $rowIndex): ?string
    {
        return (string) (Arr::get($activityArray, 'transactions.' . $rowIndex . '.transaction.provider_organization.0.provider_activity_id', ''));
    }

    /**
     * Get transaction provider organisation description.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getTransactionProviderOrganisationDescription($activityArray, $rowIndex): ?string
    {
        return $this->getNarrativeText(Arr::get($activityArray, 'transactions.' . $rowIndex . '.transaction.provider_organization.0.narrative', []), Arr::get($activityArray, 'default_field_values.default_language', ''));
    }

    /**
     * Get transaction receiver organisation identifier.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getTransactionReceiverOrganisationIdentifier($activityArray, $rowIndex): ?string
    {
        return (string) (Arr::get($activityArray, 'transactions.' . $rowIndex . '.transaction.receiver_organization.0.organization_identifier_code', ''));
    }

    /**
     * Get transaction receiver organisation type.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getTransactionReceiverOrganisationType($activityArray, $rowIndex): ?string
    {
        return (string) (Arr::get($activityArray, 'transactions.' . $rowIndex . '.transaction.receiver_organization.0.type', ''));
    }

    /**
     * Get transaction receiver organisation activity identifier.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getTransactionReceiverOrganisationActivityIdentifier($activityArray, $rowIndex): ?string
    {
        return (string) (Arr::get($activityArray, 'transactions.' . $rowIndex . '.transaction.receiver_organization.0.receiver_activity_id', ''));
    }

    /**
     * Get transaction receiver organisation description.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getTransactionReceiverOrganisationDescription($activityArray, $rowIndex): ?string
    {
        return $this->getNarrativeText(Arr::get($activityArray, 'transactions.' . $rowIndex . '.transaction.receiver_organization.0.narrative', []), Arr::get($activityArray, 'default_field_values.default_language', ''));
    }

    /**
     * Get transaction sector vocabulary.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getTransactionSectorVocabulary($activityArray, $rowIndex): ?string
    {
        return (string) (Arr::get($activityArray, 'transactions.' . $rowIndex . '.transaction.sector.0.sector_vocabulary', ''));
    }

    /**
     * Get transaction sector vocabulary uri.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getTransactionSectorVocabularyURI($activityArray, $rowIndex): ?string
    {
        return Arr::get($activityArray, 'transactions.' . $rowIndex . '.transaction.sector.0.vocabulary_uri', '');
    }

    /**
     * Get transaction sector code.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getTransactionSectorCode($activityArray, $rowIndex): ?string
    {
        return (string) ($this->getSectorCodeFromVocabulary(Arr::get($activityArray, 'transactions.' . $rowIndex . '.transaction.sector.0.sector_vocabulary', ''), Arr::get($activityArray, 'transactions.' . $rowIndex . '.transaction.sector.0', [])));
    }

    /**
     * Get transaction sector narrative.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getTransactionSectorNarrative($activityArray, $rowIndex): ?string
    {
        return $this->getNarrativeText(Arr::get($activityArray, 'transactions.' . $rowIndex . '.transaction.sector.0.narrative', []), Arr::get($activityArray, 'default_field_values.default_language', ''));
    }

    /**
     * Get transaction recipient country code.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getTransactionRecipientCountryCode($activityArray, $rowIndex): ?string
    {
        return (string) (Arr::get($activityArray, 'transactions.' . $rowIndex . '.transaction.recipient_country.0.country_code', ''));
    }

    /**
     * Get transaction recipient region code.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getTransactionRecipientRegionCode($activityArray, $rowIndex): ?string
    {
        return (string) ($this->getRecipientRegionCodeFromVocabulary(Arr::get($activityArray, 'transactions.' . $rowIndex . '.transaction.recipient_region.0.region_vocabulary', ''), Arr::get($activityArray, 'transactions.' . $rowIndex . '.transaction.recipient_region.0', [])));
    }

    /**
     * Get transaction recipient region vocabulary uri.
     *
     * @param $activityArray
     * @param $rowIndex
     *
     * @return string|null
     */
    public function getTransactionRecipientRegionVocabularyUri($activityArray, $rowIndex): ?string
    {
        return Arr::get($activityArray, 'transactions.' . $rowIndex . '.transaction.recipient_region.0.vocabulary_uri', '');
    }
}
