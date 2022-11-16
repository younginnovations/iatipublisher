<?php

declare(strict_types=1);

namespace App\Http\Requests\Activity\Transaction;

use App\Http\Requests\Activity\ActivityBaseRequest;
use App\IATI\Services\Activity\ActivityService;
use App\IATI\Services\Activity\TransactionService;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

/**
 * Class TransactionRequest.
 */
class TransactionRequest extends ActivityBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * @throws BindingResolutionException
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
     * @throws BindingResolutionException
     */
    protected function getRulesForTransaction(array $formFields): array
    {
        $rules = [];
        $transactionId = $this->segment(4);
        $activityId = $this->segment(2);
        $references = ($transactionId) ? app()->make(TransactionService::class)->getTransactionReferencesExcept($activityId, $transactionId) : app()
            ->make(TransactionService::class)
            ->getTransactionReferences($activityId);

        $transactionReference = implode(',', array_filter(array_keys($references)));

        if ($transactionReference !== '') {
            $rules['reference'] = 'not_in:' . $transactionReference;
        }

        return array_merge(
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

        return array_merge(
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
    }

    /**
     * get transaction date rules.
     *
     * @param array $formFields
     *
     * @return array
     */
    protected function getTransactionDateRules(array $formFields): array
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
     * @param array $formFields
     *
     * @return array
     */
    protected function getTransactionDateMessages(array $formFields): array
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
     * @param array $formFields
     *
     * @return array
     */
    protected function getValueRules(array $formFields): array
    {
        $rules = [];

        foreach ($formFields as $valueIndex => $value) {
            $valueForm = sprintf('value.%s', $valueIndex);
            $rules[sprintf('%s.amount', $valueForm)] = 'nullable|numeric|min:0';
            $rules[sprintf('%s.date', $valueForm)] = 'nullable|before:tomorrow|date';
        }

        return $rules;
    }

    /**
     * get value error message.
     *
     * @param array $formFields
     *
     * @return array$transactionForm
     */
    protected function getValueMessages(array $formFields): array
    {
        $messages = [];

        foreach ($formFields as $valueIndex => $value) {
            $valueForm = sprintf('value.%s', $valueIndex);
            $messages[sprintf('%s.amount.numeric', $valueForm)] = 'The @amount field must be a number.';
            $messages[sprintf('%s.amount.min', $valueForm)] = 'The @amount field must not be in negative.';
            $messages[sprintf('%s.date.before', $valueForm)] = 'The @value-date must not be in future.';
            $messages[sprintf('%s.date.date', $valueForm)] = 'The @value-date field must be a valid date.';
        }

        return $messages;
    }

    /**
     * get description rules.
     *
     * @param array $formFields
     *
     * @return array
     */
    protected function getDescriptionRules(array $formFields): array
    {
        $rules = [];

        foreach ($formFields as $descriptionIndex => $description) {
            $narrativeForm = sprintf('description.%s', $descriptionIndex);
            $narrativeRules = $this->getRulesForNarrative($description['narrative'], $narrativeForm);

            foreach ($narrativeRules as $key => $item) {
                $rules[$key] = $item;
            }
        }

        return $rules;
    }

    /**
     * get description error message.
     *
     * @param array $formFields
     *
     * @return array
     */
    protected function getDescriptionMessages(array $formFields): array
    {
        $messages = [];

        foreach ($formFields as $descriptionIndex => $description) {
            $narrativeForm = sprintf('description.%s', $descriptionIndex);
            $narrativeMessages = $this->getMessagesForNarrative($description['narrative'], $narrativeForm);

            foreach ($narrativeMessages as $key => $item) {
                $messages[$key] = $item;
            }
        }

        return $messages;
    }

    /**
     * returns rules for sector.
     *
     * @param array $formFields
     *
     * @return array
     * @throws BindingResolutionException
     */
    public function getSectorsRules(array $formFields): array
    {
        if (empty($formFields)) {
            return [];
        }

        $rules = [];
        $params = $this->route()->parameters();
        $activityService = app()->make(ActivityService::class);

        if ($activityService->hasSectorDefinedInActivity($params['id'])) {
            Validator::extend('already_in_activity', function () {
                return false;
            });

            return ['sector' => 'already_in_activity'];
        }

        foreach ($formFields as $sectorIndex => $sector) {
            $sectorForm = sprintf('sector.%s', $sectorIndex);

            if (isset($sector['sector_vocabulary']) && $sector['sector_vocabulary'] === '99') {
                $rules[sprintf('%s.vocabulary_uri', $sectorForm)] = 'nullable|url';
            }

            $narrativeRules = $this->getRulesForNarrative($sector['narrative'], $sectorForm);

            foreach ($narrativeRules as $key => $item) {
                $rules[$key] = $item;
            }
        }

        return $rules;
    }

    /**
     * returns messages for sector.
     *
     * @param array $formFields
     *
     * @return array
     */
    public function getSectorsMessages(array $formFields): array
    {
        $messages = ['sector.already_in_activity' => 'Sector already defined in Activity'];

        if (empty($formFields)) {
            return $messages;
        }

        foreach ($formFields as $sectorIndex => $sector) {
            $sectorForm = sprintf('sector.%s', $sectorIndex);

            if (isset($sector['sector_vocabulary']) && $sector['sector_vocabulary'] === '99') {
                $messages[sprintf('%s.vocabulary_uri.url', $sectorForm)]
                    = 'The @vocabulary-uri field must be a valid url.';
            }

            $narrativeMessages = $this->getMessagesForNarrative($sector['narrative'], $sectorForm);

            foreach ($narrativeMessages as $key => $item) {
                $messages[$key] = $item;
            }
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
            $narrativeRules = $this->getRulesForNarrative($providerOrg['narrative'], $providerOrgForm);

            foreach ($narrativeRules as $key => $item) {
                $rules[$key] = $item;
            }
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
        $messages = [];

        foreach ($formFields as $providerOrgIndex => $providerOrg) {
            $providerOrgForm = sprintf('provider_organization.%s', $providerOrgIndex);
            $message[sprintf('%s.%s.exclude_operators', $providerOrgForm, 'provider_activity_id')] = 'The @provider-activity-id field is not valid.';
            $narrativeMessages = $this->getMessagesForNarrative($providerOrg['narrative'], $providerOrgForm);

            foreach ($narrativeMessages as $key => $item) {
                $messages[$key] = $item;
            }
        }

        return $messages;
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
            $narrativeRules = $this->getRulesForNarrative($receiverOrg['narrative'], $receiverOrgForm);

            foreach ($narrativeRules as $key => $item) {
                $rules[$key] = $item;
            }
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
        $messages = [];

        foreach ($formFields as $receiverOrgIndex => $receiverOrg) {
            $receiverOrgForm = sprintf('receiver_organization.%s', $receiverOrgIndex);
            $message[sprintf('%s.%s.exclude_operators', $receiverOrgForm, 'receiver_activity_id')] = 'The @receiver-activity-id field is not valid.';
            $narrativeMessages = $this->getMessagesForNarrative($receiverOrg['narrative'], $receiverOrgForm);

            foreach ($narrativeMessages as $key => $item) {
                $messages[$key] = $item;
            }
        }

        return $messages;
    }

    /**
     * returns rules for recipient region.
     *
     * @param array $formFields
     *
     * @return array
     * @throws BindingResolutionException
     */
    public function getRulesForRecipientRegion(array $formFields): array
    {
        if (empty($formFields)) {
            return [];
        }

        $rules = [];
        $params = $this->route()->parameters();
        $activityService = app()->make(ActivityService::class);

        if ($activityService->hasRecipientRegionDefinedInActivity($params['id'])) {
            Validator::extend('already_in_activity', function () {
                return false;
            });

            return ['recipient_region' => 'already_in_activity'];
        }

        foreach ($formFields as $recipientRegionIndex => $recipientRegion) {
            $recipientRegionForm = sprintf('recipient_region.%s', $recipientRegionIndex);

            if (Arr::get($recipientRegion, 'region_vocabulary', 1) === '99') {
                $rules[sprintf('%s.vocabulary_uri', $recipientRegionForm)] = 'nullable|url';
            }
            $narrativeRules = $this->getRulesForNarrative($recipientRegion['narrative'], $recipientRegionForm);

            foreach ($narrativeRules as $key => $item) {
                $rules[$key] = $item;
            }
        }

        return $rules;
    }

    /**
     * returns messaged for recipient region.
     *
     * @param array $formFields
     *
     * @return array
     */
    public function getMessagesForRecipientRegion(array $formFields): array
    {
        $messages = ['recipient_region.already_in_activity' => 'Recipient Region already defined in Activity'];

        if (!$formFields) {
            return $messages;
        }

        foreach ($formFields as $recipientRegionIndex => $recipientRegion) {
            $recipientRegionForm = sprintf('recipient_region.%s', $recipientRegionIndex);

            if (Arr::get($recipientRegion, 'region_vocabulary', 1) === '99') {
                $messages[sprintf('%s.vocabulary_uri.url', $recipientRegionForm)]
                    = 'The @vocabulary-uri field must be a valid url.';
            }

            $narrativeMessages = $this->getMessagesForNarrative($recipientRegion['narrative'], $recipientRegionForm);

            foreach ($narrativeMessages as $key => $item) {
                $messages[$key] = $item;
            }
        }

        return $messages;
    }

    /**
     * returns rules for recipient country.
     *
     * @param array $formFields
     *
     * @return array
     * @throws BindingResolutionException
     */
    public function getRulesForRecipientCountry(array $formFields): array
    {
        if (empty($formFields)) {
            return [];
        }

        $rules = [];
        $params = $this->route()->parameters();
        $activityService = app()->make(ActivityService::class);

        if ($activityService->hasRecipientCountryDefinedInActivity($params['id'])) {
            Validator::extend('already_in_activity', function () {
                return false;
            });

            return ['recipient_country' => 'already_in_activity'];
        }

        foreach ($formFields as $recipientCountryIndex => $recipientCountry) {
            $recipientCountryForm = sprintf('recipient_country.%s', $recipientCountryIndex);
            $narrativeRules = $this->getRulesForNarrative($recipientCountry['narrative'], $recipientCountryForm);

            foreach ($narrativeRules as $key => $item) {
                $rules[$key] = $item;
            }
        }

        return $rules;
    }

    /**
     * returns messages for recipient country.
     *
     * @param array $formFields
     *
     * @return array
     */
    public function getMessagesForRecipientCountry(array $formFields): array
    {
        $messages = ['recipient_country.already_in_activity' => 'Recipient Country already defined in Activity'];

        if (!$formFields) {
            return $messages;
        }

        foreach ($formFields as $recipientCountryIndex => $recipientCountry) {
            $recipientCountryForm = sprintf('recipient_country.%s', $recipientCountryIndex);
            $narrativeMessages = $this->getMessagesForNarrative($recipientCountry['narrative'], $recipientCountryForm);

            foreach ($narrativeMessages as $key => $item) {
                $messages[$key] = $item;
            }
        }

        return $messages;
    }
}
