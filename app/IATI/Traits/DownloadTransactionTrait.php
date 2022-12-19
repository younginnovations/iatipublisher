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
     * @param $i
     *
     * @return string|null
     */
    public function getTransactionInternalReference($activityArray, $i): ?string
    {
        return (string) (Arr::get($activityArray, 'transactions.' . $i . '.transaction.reference', ''));
    }

    /**
     * Get transaction type.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null
     */
    public function getTransactionType($activityArray, $i): ?string
    {
        return (string) (Arr::get($activityArray, 'transactions.' . $i . '.transaction.transaction_type.0.transaction_type_code', ''));
    }

    /**
     * Get transaction date.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null
     */
    public function getTransactionDate($activityArray, $i): ?string
    {
        return Arr::get($activityArray, 'transactions.' . $i . '.transaction.transaction_date.0.date', '');
    }

    /**
     * Get transaction value.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null
     */
    public function getTransactionValue($activityArray, $i): ?string
    {
        return (string) (Arr::get($activityArray, 'transactions.' . $i . '.transaction.value.0.amount', ''));
    }

    /**
     * Get transaction value date.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null
     */
    public function getTransactionValueDate($activityArray, $i): ?string
    {
        return Arr::get($activityArray, 'transactions.' . $i . '.transaction.value.0.date', '');
    }

    /**
     * Get transaction description.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null
     */
    public function getTransactionDescription($activityArray, $i): ?string
    {
        return $this->getNarrativeText(Arr::get($activityArray, 'transactions.' . $i . '.transaction.description.0.narrative', []), Arr::get($activityArray, 'default_field_values.default_language', ''));
    }

    /**
     * Get transaction provider organisation identifier.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null
     */
    public function getTransactionProviderOrganisationIdentifier($activityArray, $i): ?string
    {
        return (string) (Arr::get($activityArray, 'transactions.' . $i . '.transaction.provider_organization.0.organization_identifier_code', ''));
    }

    /**
     * Get transaction provider organisation type.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null
     */
    public function getTransactionProviderOrganisationType($activityArray, $i): ?string
    {
        return (string) (Arr::get($activityArray, 'transactions.' . $i . '.transaction.provider_organization.0.type', ''));
    }

    /**
     * Get transaction provider organisation activity identifier.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null
     */
    public function getTransactionProviderOrganisationActivityIdentifier($activityArray, $i): ?string
    {
        return (string) (Arr::get($activityArray, 'transactions.' . $i . '.transaction.provider_organization.0.provider_activity_id', ''));
    }

    /**
     * Get transaction provider organisation description.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null
     */
    public function getTransactionProviderOrganisationDescription($activityArray, $i): ?string
    {
        return $this->getNarrativeText(Arr::get($activityArray, 'transactions.' . $i . '.transaction.provider_organization.0.narrative', []), Arr::get($activityArray, 'default_field_values.default_language', ''));
    }

    /**
     * Get transaction receiver organisation identifier.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null
     */
    public function getTransactionReceiverOrganisationIdentifier($activityArray, $i): ?string
    {
        return (string) (Arr::get($activityArray, 'transactions.' . $i . '.transaction.receiver_organization.0.organization_identifier_code', ''));
    }

    /**
     * Get transaction receiver organisation type.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null
     */
    public function getTransactionReceiverOrganisationType($activityArray, $i): ?string
    {
        return (string) (Arr::get($activityArray, 'transactions.' . $i . '.transaction.receiver_organization.0.type', ''));
    }

    /**
     * Get transaction receiver organisation activity identifier.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null
     */
    public function getTransactionReceiverOrganisationActivityIdentifier($activityArray, $i): ?string
    {
        return (string) (Arr::get($activityArray, 'transactions.' . $i . '.transaction.receiver_organization.0.receiver_activity_id', ''));
    }

    /**
     * Get transaction receiver organisation description.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null
     */
    public function getTransactionReceiverOrganisationDescription($activityArray, $i): ?string
    {
        return $this->getNarrativeText(Arr::get($activityArray, 'transactions.' . $i . '.transaction.receiver_organization.0.narrative', []), Arr::get($activityArray, 'default_field_values.default_language', ''));
    }

    /**
     * Get transaction sector vocabulary.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null
     */
    public function getTransactionSectorVocabulary($activityArray, $i): ?string
    {
        return (string) (Arr::get($activityArray, 'transactions.' . $i . '.transaction.sector.0.sector_vocabulary', ''));
    }

    /**
     * Get transaction sector vocabulary uri.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null
     */
    public function getTransactionSectorVocabularyURI($activityArray, $i): ?string
    {
        return Arr::get($activityArray, 'transactions.' . $i . '.transaction.sector.0.vocabulary_uri', '');
    }

    /**
     * Get transaction sector code.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null
     */
    public function getTransactionSectorCode($activityArray, $i): ?string
    {
        return (string) ($this->getSectorCodeFromVocabulary(Arr::get($activityArray, 'transactions.' . $i . '.transaction.sector.0.sector_vocabulary', ''), Arr::get($activityArray, 'transactions.' . $i . '.transaction.sector.0', [])));
    }

    /**
     * Get transaction sector narrative.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null
     */
    public function getTransactionSectorNarrative($activityArray, $i): ?string
    {
        return $this->getNarrativeText(Arr::get($activityArray, 'transactions.' . $i . '.transaction.sector.0.narrative', []), Arr::get($activityArray, 'default_field_values.default_language', ''));
    }

    /**
     * Get transaction recipient country code.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null
     */
    public function getTransactionRecipientCountryCode($activityArray, $i): ?string
    {
        return (string) (Arr::get($activityArray, 'transactions.' . $i . '.transaction.recipient_country.0.country_code', ''));
    }

    /**
     * Get transaction recipient region code.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null
     */
    public function getTransactionRecipientRegionCode($activityArray, $i): ?string
    {
        return (string) ($this->getRecipientRegionCodeFromVocabulary(Arr::get($activityArray, 'transactions.' . $i . '.transaction.recipient_region.0.region_vocabulary', ''), Arr::get($activityArray, 'transactions.' . $i . '.transaction.recipient_region.0', [])));
    }

    /**
     * Get transaction recipient region vocabulary uri.
     *
     * @param $activityArray
     * @param $i
     *
     * @return string|null
     */
    public function getTransactionRecipientRegionVocabularyUri($activityArray, $i): ?string
    {
        return Arr::get($activityArray, 'transactions.' . $i . '.transaction.recipient_region.0.vocabulary_uri', '');
    }
}
