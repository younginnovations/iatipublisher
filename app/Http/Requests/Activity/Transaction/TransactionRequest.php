<?php

declare(strict_types=1);

namespace App\Http\Requests\Activity\Transaction;

use App\Http\Requests\Activity\ActivityBaseRequest;
use App\IATI\Services\Activity\TransactionService;
use Illuminate\Support\Arr;

/**
 * Class TransactionRequest.
 */
class TransactionRequest extends ActivityBaseRequest
{
    /**
     * @var TransactionService
     */
    protected TransactionService $transactionService;

    /**
     * Transaction constructor.
     * @param TransactionService $transactionService
     */
    public function __construct(TransactionService $transactionService)
    {
        parent::__construct();

        $this->transactionService = $transactionService;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return $this->getRulesForTransaction(request()->except('_token'));
    }

    /**
     * Get the error message as required.
     *
     * @return array
     */
    public function messages(): array
    {
        return $this->getMessagesForTransaction(request()->except('_token'));
    }

    /**
     * Returns rules for transaction.
     *
     * @param array $formFields
     *
     * @return array
     */
    protected function getRulesForTransaction(array $formFields): array
    {
        $rules = [];

        $transactionId = $this->segment(4);
        $activityId = $this->segment(2);
        $references = ($transactionId) ? $this->transactionService->getTransactionReferencesExcept(
            $activityId,
            $transactionId
        ) : $this->transactionService->getTransactionReferences($activityId);

        $transactionReference = implode(',', array_filter(array_keys($references)));

        if ($transactionReference !== '') {
            $rules['reference'] = 'not_in:' . $transactionReference;
        }

        $rules = array_merge(
            $rules,
            $this->getTransactionDateRules($formFields['transaction_date']),
            $this->getValueRules($formFields['value']),
            $this->getDescriptionRules($formFields['description']),
            $this->getSectorsRules($formFields['sector']),
            $this->getRulesForProviderOrg($formFields['provider_organization']),
            $this->getRulesForReceiverOrg($formFields['receiver_organization']),
            $this->getRulesForRecipientRegion($formFields['recipient_region']),
            $this->getRulesForRecipientCountry($formFields['recipient_country'])
        );

        return $rules;
    }

    /**
     * Returns messages for transaction validations.
     *
     * @param array $formFields
     *
     * @return array
     */
    protected function getMessagesForTransaction(array $formFields): array
    {
        $messages = [];

        $messages['reference.not_in']
                = 'The @ref field must be unique for an activity.';

        $messages = array_merge(
            $messages,
            $this->getTransactionDateMessages($formFields['transaction_date']),
            $this->getValueMessages($formFields['value']),
            $this->getDescriptionMessages($formFields['description']),
            $this->getSectorsMessages($formFields['sector']),
            $this->getMessagesForProviderOrg($formFields['provider_organization']),
            $this->getMessagesForReceiverOrg($formFields['receiver_organization']),
            $this->getMessagesForRecipientRegion($formFields['recipient_region']),
            $this->getMessagesForRecipientCountry($formFields['recipient_country'])
        );

        return $messages;
    }

    /**
     * get transaction date rules.
     *
     * @param $formFields
     *
     * @return array
     */
    protected function getTransactionDateRules($formFields): array
    {
        $rules = [];

        foreach ($formFields as $dateIndex => $date) {
            $dateForm = sprintf('transaction_date.%s', $dateIndex);
            $rules[sprintf('%s.date', $dateForm)] = 'nullable|before:tomorrow|date';
        }

        return $rules;
    }

    /**
     * get transaction date error message.
     *
     * @param $formFields
     *
     * @return array
     */
    protected function getTransactionDateMessages($formFields): array
    {
        $messages = [];

        foreach ($formFields as $dateIndex => $date) {
            $dateForm = sprintf('transaction_date.%s', $dateIndex);
            $messages[sprintf('%s.date.before', $dateForm)] = 'The @iso-date must not be in future.';
            $messages[sprintf('%s.date.date', $dateForm)] = 'The @iso-date field mus be a valid date.';
        }

        return $messages;
    }

    /**
     * get values rules.
     *
     * @param $formFields
     *
     * @return array
     */
    protected function getValueRules($formFields): array
    {
        $rules = [];

        foreach ($formFields as $valueIndex => $value) {
            $valueForm = sprintf('value.%s', $valueIndex);
            $rules[sprintf('%s.amount', $valueForm)] = 'nullable|numeric';
            $rules[sprintf('%s.date', $valueForm)] = 'nullable|before:tomorrow|date';
        }

        return $rules;
    }

    /**
     * get value error message.
     *
     * @param $formFields
     *
     * @return array$transactionForm
     */
    protected function getValueMessages($formFields): array
    {
        $messages = [];

        foreach ($formFields as $valueIndex => $value) {
            $valueForm = sprintf('value.%s', $valueIndex);
            $messages[sprintf('%s.amount.numeric', $valueForm)] = 'The @amount field must be a number.';
            $messages[sprintf('%s.date.before', $valueForm)] = 'The @value-date must not be in future.';
            $messages[sprintf('%s.date.date', $valueForm)] = 'The @value-date field must be a valid date.';
        }

        return $messages;
    }

    /**
     * get description rules.
     *
     * @param $formFields
     *
     * @return array
     */
    protected function getDescriptionRules($formFields): array
    {
        $rules = [];

        foreach ($formFields as $descriptionIndex => $description) {
            $narrativeForm = sprintf('description.%s', $descriptionIndex);
            $rules = array_merge(
                $rules,
                $this->getRulesForNarrative($description['narrative'], $narrativeForm)
            );
        }

        return $rules;
    }

    /**
     * get description error message.
     *
     * @param $formFields
     *
     * @return array
     */
    protected function getDescriptionMessages($formFields): array
    {
        $messages = [];

        foreach ($formFields as $descriptionIndex => $description) {
            $narrativeForm = sprintf('description.%s', $descriptionIndex);
            $messages = array_merge(
                $messages,
                $this->getMessagesForNarrative($description['narrative'], $narrativeForm)
            );
        }

        return $messages;
    }

    /**
     * returns rules for sector.
     *
     * @param $formFields
     *
     * @return array
     */
    public function getSectorsRules($formFields): array
    {
        $rules = [];

        if (!$formFields) {
            return $rules;
        }

        foreach ($formFields as $sectorIndex => $sector) {
            $sectorForm = sprintf('sector.%s', $sectorIndex);

            if (isset($sector['sector_vocabulary']) && $sector['sector_vocabulary'] === '99') {
                $rules[sprintf('%s.vocabulary_uri', $sectorForm)] = 'nullable|url';
            }

            $rules = array_merge($this->getRulesForNarrative($sector['narrative'], $sectorForm), $rules);
        }

        return $rules;
    }

    /**
     * returns messages for sector.
     *
     * @param $formFields
     *
     * @return array
     */
    public function getSectorsMessages($formFields): array
    {
        $messages = [];

        if (!$formFields) {
            return $messages;
        }

        foreach ($formFields as $sectorIndex => $sector) {
            $sectorForm = sprintf('sector.%s', $sectorIndex);

            if (isset($sector['sector_vocabulary']) && $sector['sector_vocabulary'] === '99') {
                $messages[sprintf('%s.vocabulary_uri.url', $sectorForm)]
                    = 'The @vocabulary-uri field must be a valid url.';
            }

            $messages = array_merge($this->getMessagesForNarrative($sector['narrative'], $sectorForm), $messages);
        }

        return $messages;
    }

    /**
     * get rules for transaction provider organization.
     *
     * @param array $formFields
     *
     * @return array
     */
    protected function getRulesForProviderOrg(array $formFields): array
    {
        $rules = [];

        foreach ($formFields as $providerOrgIndex => $providerOrg) {
            $providerOrgForm = sprintf('provider_organization.%s', $providerOrgIndex);

            $rules[sprintf('%s.%s', $providerOrgForm, 'provider_activity_id')] = 'exclude_operators';

            $rules = array_merge(
                $rules,
                $this->getRulesForNarrative($providerOrg['narrative'], $providerOrgForm)
            );
        }

        return $rules;
    }

    /**
     * get error messages for transaction provider organization.
     *
     * @param array $formFields
     *
     * @return array
     */
    protected function getMessagesForProviderOrg(array $formFields): array
    {
        $message = [];

        foreach ($formFields as $providerOrgIndex => $providerOrg) {
            $providerOrgForm = sprintf('provider_organization.%s', $providerOrgIndex);
            $message[sprintf('%s.%s.exclude_operators', $providerOrgForm, 'provider_activity_id')] = 'The @provider-activity-id field is not valid.';

            $message = array_merge(
                $message,
                $this->getMessagesForNarrative($providerOrg['narrative'], $providerOrgForm)
            );
        }

        return $message;
    }

    /**
     * get rules for transaction receiver organization.
     *
     * @param array $formFields
     *
     * @return array
     */
    protected function getRulesForReceiverOrg(array $formFields): array
    {
        $rules = [];

        foreach ($formFields as $receiverOrgIndex => $receiverOrg) {
            $receiverOrgForm = sprintf('receiver_organization.%s', $receiverOrgIndex);

            $rules[sprintf('%s.%s', $receiverOrgForm, 'receiver_activity_id')] = 'exclude_operators';

            $rules = array_merge(
                $rules,
                $this->getRulesForNarrative($receiverOrg['narrative'], $receiverOrgForm)
            );
        }

        return $rules;
    }

    /**
     * get error messages for transaction receiver organization.
     *
     * @param array $formFields
     *
     * @return array
     */
    protected function getMessagesForReceiverOrg(array $formFields): array
    {
        $message = [];

        foreach ($formFields as $receiverOrgIndex => $receiverOrg) {
            $receiverOrgForm = sprintf('receiver_organization.%s', $receiverOrgIndex);
            $message[sprintf('%s.%s.exclude_operators', $receiverOrgForm, 'receiver_activity_id')] = 'The @receiver-activity-id field is not valid.';

            $message = array_merge(
                $message,
                $this->getMessagesForNarrative($receiverOrg['narrative'], $receiverOrgForm)
            );
        }

        return $message;
    }

    /**
     * returns rules for recipient region.
     *
     * @param $formFields
     *
     * @return array
     */
    public function getRulesForRecipientRegion($formFields): array
    {
        $rules = [];

        if (!$formFields) {
            return $rules;
        }

        foreach ($formFields as $recipientRegionIndex => $recipientRegion) {
            $recipientRegionForm = sprintf('recipient_region.%s', $recipientRegionIndex);

            if (Arr::get($recipientRegion, 'region_vocabulary', 1) === '99') {
                $rules[sprintf('%s.vocabulary_uri', $recipientRegionForm)]
                    = 'nullable|url';
            }

            $rules = array_merge(
                $this->getRulesForNarrative($recipientRegion['narrative'], $recipientRegionForm),
                $rules
            );
        }

        return $rules;
    }

    /**
     * returns messaged for recipient region.
     *
     * @param $formFields
     *
     * @return array
     */
    public function getMessagesForRecipientRegion($formFields): array
    {
        $messages = [];

        if (!$formFields) {
            return $messages;
        }

        foreach ($formFields as $recipientRegionIndex => $recipientRegion) {
            $recipientRegionForm = sprintf('recipient_region.%s', $recipientRegionIndex);

            if (Arr::get($recipientRegion, 'region_vocabulary', 1) === '99') {
                $messages[sprintf('%s.vocabulary_uri.url', $recipientRegionForm)]
                    = 'The @vocabulary-uri field must be a valid url.';
            }

            $messages = array_merge(
                $this->getMessagesForNarrative($recipientRegion['narrative'], $recipientRegionForm),
                $messages
            );
        }

        return $messages;
    }

    /**
     * returns rules for recipient country.
     *
     * @param $formFields
     *
     * @return array
     */
    public function getRulesForRecipientCountry($formFields): array
    {
        $rules = [];

        if (!$formFields) {
            return $rules;
        }

        foreach ($formFields as $recipientCountryIndex => $recipientCountry) {
            $recipientCountryForm = sprintf('recipient_country.%s', $recipientCountryIndex);
            $rules = array_merge(
                $this->getRulesForNarrative($recipientCountry['narrative'], $recipientCountryForm),
                $rules
            );
        }

        return $rules;
    }

    /**
     * returns messages for recipient country.
     *
     * @param $formFields
     *
     * @return array
     */
    public function getMessagesForRecipientCountry($formFields): array
    {
        $messages = [];

        if (!$formFields) {
            return $messages;
        }

        foreach ($formFields as $recipientCountryIndex => $recipientCountry) {
            $recipientCountryForm = sprintf('recipient_country.%s', $recipientCountryIndex);
            $messages = array_merge($this->getMessagesForNarrative(
                $recipientCountry['narrative'],
                $recipientCountryForm
            ), $messages);
        }

        return $messages;
    }
}
