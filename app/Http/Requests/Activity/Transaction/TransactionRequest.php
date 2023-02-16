<?php

declare(strict_types=1);

namespace App\Http\Requests\Activity\Transaction;

use App\Http\Requests\Activity\ActivityBaseRequest;
use App\IATI\Services\Activity\ActivityService;
use App\IATI\Services\Activity\TransactionService;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

/**
 * Class TransactionRequest.
 */
class TransactionRequest extends ActivityBaseRequest
{
    /**
     * @var array
     */
    protected array $transactionFormField;

    /**
     * @var array
     */
    protected array $activityFormField;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * @throws BindingResolutionException
     * @throws \JsonException
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
     * @param bool $fileUpload
     * @param array $activityData
     *
     * @return array
     * @throws BindingResolutionException|\JsonException
     */
    public function getRulesForTransaction(array $formFields, bool $fileUpload = false, array $activityData = []): array
    {
        $rules = [];
        $this->transactionFormField = $formFields;
        $this->activityFormField = $activityData;

        if (!$fileUpload) {
            $transactionId = $this->segment(4);
            $activityId = $this->segment(2);
            $references = ($transactionId) ? app()->make(TransactionService::class)->getTransactionReferencesExcept($activityId, $transactionId) : app()
                ->make(TransactionService::class)
                ->getTransactionReferences($activityId);

            $transactionReference = implode(',', array_filter(array_keys($references)));

            if ($transactionReference !== '') {
                $rules['reference'] = 'not_in:' . $transactionReference;
            }
        }

        Validator::extend('country_or_region', static function () {
            return false;
        });

        $rules['transaction_type.0.transaction_type_code'] = 'nullable|in:' . implode(',', array_keys(getCodeList('TransactionType', 'Activity', false)));
        $rules['flow_type.0.flow_type'] = 'nullable|in:' . implode(',', array_keys(getCodeList('FlowType', 'Activity', false)));
        $rules['finance_type.0.finance_type'] = 'nullable|in:' . implode(',', array_keys(getCodeList('FinanceType', 'Activity', false)));
        $rules['aid_type.0.aid_type_vocabulary'] = 'nullable|in:' . implode(',', array_keys(getCodeList('AidTypeVocabulary', 'Activity', false)));
        $rules['aid_type.0.aid_type_code'] = 'nullable|in:' . implode(',', array_keys(getCodeList('AidType', 'Activity', false)));
        $rules['aid_type.0.earmarking_category'] = 'nullable|in:' . implode(',', array_keys(getCodeList('EarmarkingCategory', 'Activity', false)));
        $rules['aid_type.0.earmarking_modality'] = 'nullable|in:' . implode(',', array_keys(getCodeList('EarmarkingModality', 'Activity', false)));
        $rules['aid_type.0.cash_and_voucher_modalities'] = 'nullable|in:' . implode(',', array_keys(getCodeList('CashandVoucherModalities', 'Activity', false)));
        $rules['tied_status.0.tied_status_code'] = 'nullable|in:' . implode(',', array_keys(getCodeList('TiedStatus', 'Activity', false)));

        $tempRules = [
            $this->getTransactionDateRules($formFields['transaction_date']),
            $this->getValueRules($formFields['value']),
            $this->getDescriptionRules($formFields['description']),
            $this->getSectorsRules($formFields['sector'], $fileUpload, Arr::get($activityData, 'sector', [])),
            $this->getRulesForProviderOrg($formFields['provider_organization']),
            $this->getRulesForReceiverOrg($formFields['receiver_organization']),
            $this->getRulesForRecipientRegion($formFields['recipient_region'], $fileUpload, Arr::get($activityData, 'recipient_region', [])),
            $this->getRulesForRecipientCountry($formFields['recipient_country'], $fileUpload, Arr::get($activityData, 'recipient_country', [])),
        ];

        foreach ($tempRules as $tempRule) {
            foreach ($tempRule as $idx => $rule) {
                $rules[$idx] = $rule;
            }
        }

        return $rules;
    }

    /**
     * Returns messages for transaction validations.
     *
     * @param array $formFields
     *
     * @return array
     */
    public function getMessagesForTransaction(array $formFields): array
    {
        $messages = [];

        $messages['reference.not_in']
            = 'The transaction reference field must be unique for an activity.';

        $messages['transaction_type.0.transaction_type_code.in'] = 'The transaction type is invalid.';
        $messages['flow_type.0.flow_type.in'] = 'The transaction flow type code is invalid.';
        $messages['finance_type.0.finance_type.in'] = 'The transaction finance type code is invalid.';
        $messages['aid_type.0.aid_type_vocabulary.in'] = 'The transaction aid type vocabulary is invalid.';
        $messages['aid_type.0.aid_type_code.in'] = 'The transaction aid type code is invalid.';
        $messages['aid_type.0.earmarking_category.in'] = 'The transaction aid type code is invalid.';
        $messages['aid_type.0.earmarking_modality.in'] = 'The transaction aid type code is invalid.';
        $messages['aid_type.0.cash_and_voucher_modalities.in'] = 'The transaction aid type code is invalid.';
        $messages['tied_status.0.tied_status_code.in'] = 'The transaction tied status code is invalid.';
        $tempMessages = [
            $this->getTransactionDateMessages($formFields['transaction_date']),
            $this->getValueMessages($formFields['value']),
            $this->getDescriptionMessages($formFields['description']),
            $this->getSectorsMessages($formFields['sector']),
            $this->getMessagesForProviderOrg($formFields['provider_organization']),
            $this->getMessagesForReceiverOrg($formFields['receiver_organization']),
            $this->getMessagesForRecipientRegion($formFields['recipient_region']),
            $this->getMessagesForRecipientCountry($formFields['recipient_country']),
        ];

        foreach ($tempMessages as $tempMessage) {
            foreach ($tempMessage as $idx => $message) {
                $messages[$idx] = $message;
            }
        }

        return $messages;
    }

    /**
     * get transaction date rules.
     *
     * @param array $formFields
     *
     * @return array
     */
    public function getTransactionDateRules(array $formFields): array
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
    public function getTransactionDateMessages(array $formFields): array
    {
        $messages = [];

        foreach ($formFields as $dateIndex => $date) {
            $dateForm = sprintf('transaction_date.%s', $dateIndex);
            $messages[sprintf('%s.date.before', $dateForm)] = 'The @iso-date must not be in future.';
            $messages[sprintf('%s.date.date', $dateForm)] = 'The @iso-date field must be a valid date.';
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
    public function getValueRules(array $formFields): array
    {
        $rules = [];

        foreach ($formFields as $valueIndex => $value) {
            $valueForm = sprintf('value.%s', $valueIndex);
            $rules[sprintf('%s.amount', $valueForm)] = 'nullable|numeric|min:0';
            $rules[sprintf('%s.date', $valueForm)] = 'nullable|before:tomorrow|date';
            $rules[sprintf('%s.currency', $valueForm)] = sprintf('nullable|in:%s', implode(',', array_keys(getCodeList('Currency', 'Activity'))));
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
    public function getValueMessages(array $formFields): array
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
    public function getDescriptionRules(array $formFields): array
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
    public function getDescriptionMessages(array $formFields): array
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
     * @param bool $fileUpload
     * @param array $activitySectors
     * @param array $transactions
     *
     * @return array
     * @throws BindingResolutionException|\JsonException
     */
    public function getSectorsRules(array $formFields, bool $fileUpload, array $activitySectors, array $transactions = []): array
    {
        if (empty($formFields)) {
            return [];
        }

        $rules = [];
        $activityService = app()->make(ActivityService::class);
        $transactionService = app()->make(TransactionService::class);

        Validator::extend('already_in_activity', function () {
            return false;
        });

        Validator::extend('sector_required', function () {
            return false;
        });

        if (!$fileUpload) {
            $params = $this->route()->parameters();
            if (!$activityService->isElementEmpty($formFields, 'sectorFields') && $activityService->hasSectorDefinedInActivity($params['id'])) {
                return ['sector' => 'already_in_activity'];
            }

            if (is_variable_null($formFields) && $transactionService->hasSectorDefinedInTransaction($params['id'])) {
                $rules['sector'] = 'sector_required';
            }
        } else {
            if (!empty($activitySectors) && !$activityService->isElementEmpty($formFields, 'sectorFields')) {
                return ['sector' => 'already_in_activity'];
            }

            if (!empty($transactions)) {
                $hasSector = false;

                foreach ($transactions as $transaction) {
                    if (Arr::get($transaction, 'sector', [])) {
                        $hasSector = true;
                        break;
                    }
                }

                if ($hasSector) {
                    $rules['sector'] = 'sector_required';
                }
            }
        }

        foreach ($formFields as $sectorIndex => $sector) {
            $sectorForm = sprintf('sector.%s', $sectorIndex);
            $rules[sprintf('%s.sector_vocabulary', $sectorForm)] = 'nullable|in:' . implode(',', array_keys(getCodeList('SectorVocabulary', 'Activity', false)));
            $rules[sprintf('%s.code', $sectorForm)] = 'nullable|in:' . implode(',', array_keys(getCodeList('SectorCode', 'Activity', false)));
            $rules[sprintf('%s.category_code', $sectorForm)] = 'nullable|in:' . implode(',', array_keys(getCodeList('SectorCategory', 'Activity', false)));
            $rules[sprintf('%s.sdg_goal', $sectorForm)] = 'nullable|in:' . implode(',', array_keys(getCodeList('UNSDG-Goals', 'Activity', false)));
            $rules[sprintf('%s.sdg_target', $sectorForm)] = 'nullable|in:' . implode(',', array_keys(getCodeList('UNSDG-Targets', 'Activity', false)));

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
        $messages = [
            'sector.already_in_activity' => 'Sector has already been declared at activity level. You can’t declare a sector at the transaction level. To declare at transaction level, you need to remove sector at activity level.',
            'sector.sector_required' => 'You have declared sector at transaction level so you must declare sector for all the transactions.',
        ];

        if (empty($formFields)) {
            return $messages;
        }

        foreach ($formFields as $sectorIndex => $sector) {
            $sectorForm = sprintf('sector.%s', $sectorIndex);
            $messages[sprintf('%s.sector_vocabulary.in', $sectorForm)] = 'The transaction sector vocabulary is invalid.';
            $messages[sprintf('%s.code.in', $sectorForm)] = 'The transaction sector code is invalid.';
            $messages[sprintf('%s.category_code.in', $sectorForm)] = 'The transaction sector code is invalid.';
            $messages[sprintf('%s.sdg_goal.in', $sectorForm)] = 'The transaction sector code is invalid.';
            $messages[sprintf('%s.sdg_target.in', $sectorForm)] = 'The transaction sector code is invalid.';

            if (isset($sector['sector_vocabulary']) && $sector['sector_vocabulary'] === '99') {
                $messages[sprintf('%s.vocabulary_uri.url', $sectorForm)]
                    = 'The transaction sector vocabulary-uri field must be a valid url.';
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
    public function getRulesForProviderOrg(array $formFields): array
    {
        $rules = [];

        foreach ($formFields as $providerOrgIndex => $providerOrg) {
            $providerOrgForm = sprintf('provider_organization.%s', $providerOrgIndex);
            $rules[sprintf('%s.%s', $providerOrgForm, 'provider_activity_id')] = 'exclude_operators';
            $rules[sprintf('%s.%s', $providerOrgForm, 'type')] = 'nullable|in:' . implode(',', array_keys(getCodeList('OrganizationType', 'Organization', false)));
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
    public function getMessagesForProviderOrg(array $formFields): array
    {
        $messages = [];

        foreach ($formFields as $providerOrgIndex => $providerOrg) {
            $providerOrgForm = sprintf('provider_organization.%s', $providerOrgIndex);
            $message[sprintf('%s.%s.exclude_operators', $providerOrgForm, 'provider_activity_id')] = 'The transaction provider-activity-id field is not valid.';
            $messages[sprintf('%s.%s.in', $providerOrgForm, 'type')] = 'The transaction provider org type is invalid.';
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
    public function getRulesForReceiverOrg(array $formFields): array
    {
        $rules = [];

        foreach ($formFields as $receiverOrgIndex => $receiverOrg) {
            $receiverOrgForm = sprintf('receiver_organization.%s', $receiverOrgIndex);
            $rules[sprintf('%s.%s', $receiverOrgForm, 'receiver_activity_id')] = 'exclude_operators';
            $rules[sprintf('%s.%s', $receiverOrgForm, 'type')] = 'nullable|in:' . implode(',', array_keys(getCodeList('OrganizationType', 'Organization', false)));
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
    public function getMessagesForReceiverOrg(array $formFields): array
    {
        $messages = [];

        foreach ($formFields as $receiverOrgIndex => $receiverOrg) {
            $receiverOrgForm = sprintf('receiver_organization.%s', $receiverOrgIndex);
            $message[sprintf('%s.%s.exclude_operators', $receiverOrgForm, 'receiver_activity_id')] = 'The transaction receiver-activity-id field is not valid.';
            $messages[sprintf('%s.%s.in', $receiverOrgForm, 'type')] = 'The transaction receiver org type is invalid.';
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
     * @param bool $fileUpload
     * @param array $activityRecipientRegions
     *
     * @return array
     * @throws BindingResolutionException
     */
    public function getRulesForRecipientRegion(array $formFields, bool $fileUpload, array $activityRecipientRegions, array $transaction = []): array
    {
        if (empty($formFields)) {
            return [];
        }

        $rules = [];
        $activityService = app()->make(ActivityService::class);

        if (!$fileUpload) {
            $params = $this->route()->parameters();

            if (!$activityService->isElementEmpty($formFields, 'recipientRegionFields') && $activityService->hasRecipientRegionDefinedInActivity($params['id'])) {
                Validator::extend('already_in_activity', function () {
                    return false;
                });

                return ['recipient_region' => 'already_in_activity'];
            }
        } else {
            if (!$activityService->isElementEmpty($formFields, 'recipientRegionFields') && !$activityService->isElementEmpty($activityRecipientRegions, 'recipientRegionFields')) {
                return ['recipient_region' => 'already_in_activity'];
            } elseif ($activityService->isElementEmpty($activityRecipientRegions, 'recipientRegionFields')) {
                $this->getRecipientRegionOrCountryRuleFromFileUpload($rules, 'recipient_country');
            }
        }

        foreach ($formFields as $recipientRegionIndex => $recipientRegion) {
            $recipientRegionForm = sprintf('recipient_region.%s', $recipientRegionIndex);
            $rules[sprintf('%s.region_vocabulary', $recipientRegionForm)] = 'nullable|in:' . implode(',', array_keys(getCodeList('RegionVocabulary', 'Activity', false)));
            $rules[sprintf('%s.region_code', $recipientRegionForm)] = 'nullable|in:' . implode(',', array_keys(getCodeList('Region', 'Activity', false)));
            $rules[sprintf('%s.vocabulary_uri', $recipientRegionForm)] = 'nullable|url';

            if (Arr::get($recipientRegion, 'region_vocabulary', 1) === '99') {
                $rules[sprintf('%s.vocabulary_uri', $recipientRegionForm)] = 'nullable|url';
            }

            $narrativeRules = $this->getRulesForNarrative($recipientRegion['narrative'], $recipientRegionForm);

            foreach ($narrativeRules as $key => $item) {
                $rules[$key] = $item;
            }
        }

        if (!$fileUpload) {
            $this->getRecipientRegionOrCountryRule($rules, 'recipient_region');
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
        $messages = [
            'recipient_region.already_in_activity' => 'Recipient Region or Recipient Country is already added at activity level. You can add a Recipient Region and or Recipient Country either at activity level or at transaction level.',
            'recipient_region.country_or_region' => 'You must add either recipient country or recipient region.',
        ];

        if (!$formFields) {
            return $messages;
        }

        foreach ($formFields as $recipientRegionIndex => $recipientRegion) {
            $recipientRegionForm = sprintf('recipient_region.%s', $recipientRegionIndex);
            $messages[sprintf('%s.region_vocabulary.in', $recipientRegionForm)] = 'The transaction recipient region vocabulary is invalid.';
            $messages[sprintf('%s.region_code.in', $recipientRegionForm)] = 'The transaction recipient region code is invalid.';
            $messages[sprintf('%s.vocabulary_uri.url', $recipientRegionForm)] = 'The transaction recipient region vocabulary uri must be a valid url.';

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
     * @param bool $fileUpload
     * @param array $activityRecipientCountries
     *
     * @return array
     * @throws BindingResolutionException
     */
    public function getRulesForRecipientCountry(array $formFields, bool $fileUpload, array $activityRecipientCountries): array
    {
        if (empty($formFields)) {
            return [];
        }

        $rules = [];
        $activityService = app()->make(ActivityService::class);

        if (!$fileUpload) {
            $params = $this->route()->parameters();

            if (!$activityService->isElementEmpty($formFields, 'recipientCountryFields') && $activityService->hasRecipientCountryDefinedInActivity($params['id'])) {
                Validator::extend('already_in_activity', function () {
                    return false;
                });

                return ['recipient_country' => 'already_in_activity'];
            }
        } else {
            if (!$activityService->isElementEmpty($formFields, 'recipientCountryFields') && !$activityService->isElementEmpty($activityRecipientCountries, 'recipientCountryFields')) {
                return ['recipient_country' => 'already_in_activity'];
            } elseif ($activityService->isElementEmpty($activityRecipientCountries, 'recipientCountryFields')) {
                $this->getRecipientRegionOrCountryRuleFromFileUpload($rules, 'recipient_country');
            }
        }

        foreach ($formFields as $recipientCountryIndex => $recipientCountry) {
            $recipientCountryForm = sprintf('recipient_country.%s', $recipientCountryIndex);
            $rules[sprintf('%s.country_code', $recipientCountryForm)] = 'nullable|in:' . implode(',', array_keys(getCodeList('Country', 'Activity', false)));
            $narrativeRules = $this->getRulesForNarrative($recipientCountry['narrative'], $recipientCountryForm);

            foreach ($narrativeRules as $key => $item) {
                $rules[$key] = $item;
            }
        }

        if (!$fileUpload) {
            $this->getRecipientRegionOrCountryRule($rules, 'recipient_country');
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
        $messages = [
            'recipient_country.already_in_activity' => 'Recipient Region or Recipient Country is already added at activity level. You can add a Recipient Region and or Recipient Country either at activity level or at transaction level.',
            'recipient_country.country_or_region' => 'You must add either recipient country or recipient region.',
        ];

        if (!$formFields) {
            return $messages;
        }

        foreach ($formFields as $recipientCountryIndex => $recipientCountry) {
            $recipientCountryForm = sprintf('recipient_country.%s', $recipientCountryIndex);
            $messages[sprintf('%s.country_code.in', $recipientCountryForm)] = 'The transaction recipient country code is invalid.';
            $narrativeMessages = $this->getMessagesForNarrative($recipientCountry['narrative'], $recipientCountryForm);

            foreach ($narrativeMessages as $key => $item) {
                $messages[$key] = $item;
            }
        }

        return $messages;
    }

    /**
     * Checks if recipient region or country is required or not.
     *
     * @param $rules
     * @param $attribute
     * @return array
     * @throws BindingResolutionException
     */
    public function getRecipientRegionOrCountryRule(&$rules, $attribute): array
    {
        $transactionService = app()->make(TransactionService::class);
        $params = $this->route()->parameters();

        if (($transactionService->hasRecipientRegionOrCountryDefinedInTransaction($params['id'])) && (is_variable_null($this->all()['recipient_region']) && is_variable_null($this->all()['recipient_country']))) {
            $rules[$attribute] = 'country_or_region';
        } elseif (!is_variable_null($this->all()['recipient_region']) && !is_variable_null($this->all()['recipient_country'])) {
            $rules[$attribute] = 'country_or_region';
        }

        return $rules;
    }

    /**
     * Checks if country or region rule required or not from file upload.
     *
     * @param $rules
     * @param $attribute
     * @return array
     */
    public function getRecipientRegionOrCountryRuleFromFileUpload(&$rules, $attribute): array
    {
        $hasRegionOrCountryDefinedInTransaction = Session::get('has_region_or_country_defined_in_transaction');
        $recipientRegion = $this->transactionFormField['recipient_region'];
        $recipientCountry = $this->transactionFormField['recipient_country'];

        if (!is_variable_null($recipientRegion) || !is_variable_null($recipientCountry)) {
            Session::put('has_region_or_country_defined_in_transaction', true);
        } elseif ($hasRegionOrCountryDefinedInTransaction && (is_variable_null($recipientRegion) && is_variable_null($recipientCountry))) {
            $rules[$attribute] = 'country_or_region';
        } elseif (!is_variable_null($recipientRegion) && !is_variable_null($recipientCountry)) {
            $rules[$attribute] = 'country_or_region';
        }

        return $rules;
    }
}
