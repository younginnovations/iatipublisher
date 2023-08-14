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
use JsonException;

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
     * @var bool
     */
    protected bool $hasCountryOrRegionDefinedInActivity = false;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * @throws BindingResolutionException
     * @throws JsonException
     */
    public function rules(): array
    {
        $data = request()->except('_token');

        $totalRules = [
            $this->getWarningForTransaction($data),
            $this->getErrorsForTransaction($data),
        ];

        return mergeRules($totalRules);
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
     * @param array $multipleTransactions
     *
     * @return array
     *
     * @throws BindingResolutionException
     * @throws JsonException
     */
    public function getWarningForTransaction(array $formFields, bool $fileUpload = false, array $activityData = [], array $multipleTransactions = []): array
    {
        $rules = [];
        $this->transactionFormField = $formFields;
        $this->activityFormField = $activityData;

        Validator::extend('country_or_region', static function () {
            return false;
        });

        $tempRules = [
            $this->getTransactionDateRules($formFields['transaction_date']),
            $this->getValueRules($formFields['value']),
            $this->getDescriptionRules($formFields['description']),
            $this->getSectorsRules($formFields['sector'], $fileUpload, Arr::get($activityData, 'sector', []), $multipleTransactions),
            $this->getWarningForProviderOrg($formFields['provider_organization']),
            $this->getWarningForReceiverOrg($formFields['receiver_organization']),
            $this->getWarningForRecipientRegion($formFields['recipient_region'], $fileUpload, Arr::get($activityData, 'recipient_region', [])),
            $this->getWarningForRecipientCountry($formFields['recipient_country'], $fileUpload, Arr::get($activityData, 'recipient_country', [])),
        ];

        foreach ($tempRules as $tempRule) {
            foreach ($tempRule as $idx => $rule) {
                $rules[$idx] = $rule;
            }
        }

        return $rules;
    }

    /**
     * Returns rules for transaction.
     *
     * @param array $formFields
     * @param bool $fileUpload
     * @param array $activityData
     *
     * @return array
     *
     * @throws BindingResolutionException
     * @throws JsonException
     */
    public function getErrorsForTransaction(array $formFields, bool $fileUpload = false, array $activityData = []): array
    {
        $rules = [];

        $rules['transaction_type.0.transaction_type_code'] = 'nullable|in:' . implode(',', array_keys(getCodeList('TransactionType', 'Activity', false)));
        $rules['flow_type.0.flow_type'] = 'nullable|in:' . implode(',', array_keys(getCodeList('FlowType', 'Activity', false)));
        $rules['finance_type.0.finance_type'] = 'nullable|in:' . implode(',', array_keys(getCodeList('FinanceType', 'Activity', false)));
        $rules['aid_type.0.aid_type_vocabulary'] = 'nullable|in:' . implode(',', array_keys(getCodeList('AidTypeVocabulary', 'Activity', false)));
        $rules['aid_type.0.aid_type_code'] = 'nullable|in:' . implode(',', array_keys(getCodeList('AidType', 'Activity', false)));
        $rules['aid_type.0.earmarking_category'] = 'nullable|in:' . implode(',', array_keys(getCodeList('EarmarkingCategory', 'Activity', false)));
        $rules['aid_type.0.earmarking_modality'] = 'nullable|in:' . implode(',', array_keys(getCodeList('EarmarkingModality', 'Activity', false)));
        $rules['aid_type.0.cash_and_voucher_modalities'] = 'nullable|in:' . implode(',', array_keys(getCodeList('CashandVoucherModalities', 'Activity', false)));
        $rules['tied_status.0.tied_status_code'] = 'nullable|in:' . implode(',', array_keys(getCodeList('TiedStatus', 'Activity', false)));
        $rules['disbursement_channel.0.disbursement_channel_code'] = 'nullable|in:' . implode(',', array_keys(getCodeList('DisbursementChannel', 'Activity', false)));

        $tempRules = [
            $this->getCriticalTransactionDateRules($formFields['transaction_date']),
            $this->getCriticalValueRules($formFields['value']),
            $this->getCriticalDescriptionRules($formFields['description']),
            $this->getCriticalSectorsRules($formFields['sector'], $fileUpload, Arr::get($activityData, 'sector', [])),
            $this->getErrorsForProviderOrg($formFields['provider_organization']),
            $this->getErrorsForReceiverOrg($formFields['receiver_organization']),
            $this->getErrorsForRecipientRegion($formFields['recipient_region'], $fileUpload, Arr::get($activityData, 'recipient_region', [])),
            $this->getErrorsForRecipientCountry($formFields['recipient_country'], $fileUpload, Arr::get($activityData, 'recipient_country', [])),
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
        $messages['reference.not_in'] = translateRequestMessage('transaction_ref_field', 'must_be_unique_for_activity');
        $messages['transaction_type.0.transaction_type_code.in'] = translateRequestMessage('transaction', 'type_is_invalid');
        $messages['flow_type.0.flow_type.in'] = translateRequestMessage('transaction_flow', 'code_in_invalid');
        $messages['finance_type.0.finance_type.in'] = translateRequestMessage('transaction_finance', 'code_in_invalid');
        $messages['aid_type.0.aid_type_vocabulary.in'] = translateRequestMessage('transaction_aid', 'vocabulary_is_invalid');
        $messages['aid_type.0.aid_type_code.in'] = translateRequestMessage('transaction_aid', 'code_in_invalid');
        $messages['aid_type.0.earmarking_category.in'] = translateRequestMessage('transaction_aid', 'code_is_invalid');
        $messages['aid_type.0.earmarking_modality.in'] = translateRequestMessage('transaction_aid', 'code_is_invalid');
        $messages['aid_type.0.cash_and_voucher_modalities.in'] = translateRequestMessage('transaction_aid', 'code_in_invalid');
        $messages['tied_status.0.tied_status_code.in'] = translateRequestMessage('transaction_tied', 'code_in_invalid');

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
            $rules[sprintf('%s.date', $dateForm)] = 'nullable|before:tomorrow';
        }

        return $rules;
    }

    /**
     * get critical rules for transaction date.
     *
     * @param array $formFields
     *
     * @return array
     */
    public function getCriticalTransactionDateRules(array $formFields): array
    {
        $rules = [];

        foreach ($formFields as $dateIndex => $date) {
            $dateForm = sprintf('transaction_date.%s', $dateIndex);
            $rules[sprintf('%s.date', $dateForm)] = 'nullable|date';
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
            $messages[sprintf('%s.date.before', $dateForm)] = translateRequestMessage('iso_date_symbol', 'must_not_be_future');
            $messages[sprintf('%s.date.date', $dateForm)] = translateRequestMessage('iso_date_field_symbol', 'must_be_a_valid_date');
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
            $rules[sprintf('%s.amount', $valueForm)] = 'nullable|numeric';
            $rules[sprintf('%s.date', $valueForm)] = 'nullable|before:tomorrow';
        }

        return $rules;
    }

    /**
     * get values critical rules.
     *
     * @param array $formFields
     *
     * @return array
     *
     * @throws JsonException
     */
    public function getCriticalValueRules(array $formFields): array
    {
        $rules = [];

        foreach ($formFields as $valueIndex => $value) {
            $valueForm = sprintf('value.%s', $valueIndex);
            $rules[sprintf('%s.amount', $valueForm)] = 'nullable|numeric';
            $rules[sprintf('%s.date', $valueForm)] = 'nullable|date';
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
            $messages[sprintf('%s.amount.numeric', $valueForm)] = translateRequestMessage('the_@amount_field', 'must_be_a_number');
            $messages[sprintf('%s.date.before', $valueForm)] = translateRequestMessage('the_@value_date', 'must_not_be_future');
            $messages[sprintf('%s.date.date', $valueForm)] = translateRequestMessage('the_@value_date_field', 'must_be_a_valid_date');
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
            $narrativeRules = $this->getWarningForNarrative($description['narrative'], $narrativeForm);

            foreach ($narrativeRules as $key => $item) {
                $rules[$key] = $item;
            }
        }

        return $rules;
    }

    /**
     * get description critical rules.
     *
     * @param array $formFields
     *
     * @return array
     */
    public function getCriticalDescriptionRules(array $formFields): array
    {
        $rules = [];

        foreach ($formFields as $descriptionIndex => $description) {
            $narrativeForm = sprintf('description.%s', $descriptionIndex);
            $narrativeRules = $this->getErrorsForNarrative($description['narrative'], $narrativeForm);

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
     * @throws BindingResolutionException|JsonException
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

            $transactionId = isset($params['transactionId']) ? (int) $params['transactionId'] : null;

            if (is_variable_null($formFields) && $transactionService->hasSectorDefinedInTransaction($params['id'], $transactionId)) {
                $rules['sector'] = 'sector_required';
            }
        } else {
            if (!empty($activitySectors) && !$activityService->isElementEmpty($formFields, 'sectorFields')) {
                return ['sector' => 'already_in_activity'];
            }

            $hasSector = false;

            if (!empty($transactions) && count($transactions) > 1) {
                $sectors = array_column($transactions, 'sector');
                $notNullCount = 0;
                $nullCount = 0;

                foreach ($sectors as $sector) {
                    if (!is_array_value_empty($sector)) {
                        $notNullCount++;
                    } else {
                        $nullCount++;
                    }
                }

                if ($notNullCount >= 1 && $nullCount >= 1) {
                    $hasSector = true;
                }
            }

            if ($hasSector) {
                $rules['sector'] = 'sector_required';
            }
        }

        foreach ($formFields as $sectorIndex => $sector) {
            $sectorForm = sprintf('sector.%s', $sectorIndex);
            $narrativeRules = $this->getWarningForNarrative($sector['narrative'], $sectorForm);

            foreach ($narrativeRules as $key => $item) {
                $rules[$key] = $item;
            }
        }

        return $rules;
    }

    /**
     * returns critical rules for sector.
     *
     * @param array $formFields
     * @param bool $fileUpload
     * @param array $activitySectors
     *
     * @return array
     *
     * @throws JsonException
     */
    public function getCriticalSectorsRules(array $formFields, bool $fileUpload, array $activitySectors): array
    {
        if (empty($formFields)) {
            return [];
        }

        $rules = [];

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

            $narrativeRules = $this->getErrorsForNarrative($sector['narrative'], $sectorForm);

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
            'sector.already_in_activity' => translateRequestMessage('sector_has_already_been_declared'),
            'sector.sector_required' => translateRequestMessage('you_have_declared_sector'),
        ];

        if (empty($formFields)) {
            return $messages;
        }

        foreach ($formFields as $sectorIndex => $sector) {
            $sectorForm = sprintf('sector.%s', $sectorIndex);
            $messages[sprintf('%s.sector_vocabulary.in', $sectorForm)] = translateRequestMessage('transaction_sector', 'vocabulary_is_invalid');
            $messages[sprintf('%s.code.in', $sectorForm)] = translateRequestMessage('transaction_sector', 'code_is_invalid');
            $messages[sprintf('%s.category_code.in', $sectorForm)] = translateRequestMessage('transaction_sector', 'code_is_invalid');
            $messages[sprintf('%s.sdg_goal.in', $sectorForm)] = translateRequestMessage('transaction_sector', 'code_is_invalid');
            $messages[sprintf('%s.sdg_target.in', $sectorForm)] = translateRequestMessage('transaction_sector', 'code_is_invalid');

            if (isset($sector['sector_vocabulary']) && $sector['sector_vocabulary'] === '99') {
                $messages[sprintf('%s.vocabulary_uri.url', $sectorForm)]
                    = translateRequestMessage('transaction_sector', 'must_be_valid_vocal_url');
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
    public function getWarningForProviderOrg(array $formFields): array
    {
        $rules = [];

        foreach ($formFields as $providerOrgIndex => $providerOrg) {
            $providerOrgForm = sprintf('provider_organization.%s', $providerOrgIndex);
            $rules[sprintf('%s.%s', $providerOrgForm, 'provider_activity_id')] = 'exclude_operators';
            $narrativeRules = $this->getWarningForNarrative($providerOrg['narrative'], $providerOrgForm);

            foreach ($narrativeRules as $key => $item) {
                $rules[$key] = $item;
            }
        }

        return $rules;
    }

    /**
     * get critical rules for transaction provider organization.
     *
     * @param array $formFields
     *
     * @return array
     *
     * @throws JsonException
     */
    public function getErrorsForProviderOrg(array $formFields): array
    {
        $rules = [];

        foreach ($formFields as $providerOrgIndex => $providerOrg) {
            $providerOrgForm = sprintf('provider_organization.%s', $providerOrgIndex);
            $rules[sprintf('%s.%s', $providerOrgForm, 'type')] = 'nullable|in:' . implode(',', array_keys(getCodeList('OrganizationType', 'Organization', false)));
            $narrativeRules = $this->getErrorsForNarrative($providerOrg['narrative'], $providerOrgForm);

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
            $message[sprintf('%s.%s.exclude_operators', $providerOrgForm, 'provider_activity_id')] = translateRequestMessage('transaction_pro_activity', 'is_not_valid');
            $messages[sprintf('%s.%s.in', $providerOrgForm, 'type')] = translateRequestMessage('transaction_pro_org', 'type_is_invalid');
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
    public function getWarningForReceiverOrg(array $formFields): array
    {
        $rules = [];

        foreach ($formFields as $receiverOrgIndex => $receiverOrg) {
            $receiverOrgForm = sprintf('receiver_organization.%s', $receiverOrgIndex);
            $rules[sprintf('%s.%s', $receiverOrgForm, 'receiver_activity_id')] = 'exclude_operators';
            $narrativeRules = $this->getWarningForNarrative($receiverOrg['narrative'], $receiverOrgForm);

            foreach ($narrativeRules as $key => $item) {
                $rules[$key] = $item;
            }
        }

        return $rules;
    }

    /**
     * get critical rules for transaction receiver organization.
     *
     * @param array $formFields
     *
     * @return array
     *
     * @throws JsonException
     */
    public function getErrorsForReceiverOrg(array $formFields): array
    {
        $rules = [];

        foreach ($formFields as $receiverOrgIndex => $receiverOrg) {
            $receiverOrgForm = sprintf('receiver_organization.%s', $receiverOrgIndex);
            $rules[sprintf('%s.%s', $receiverOrgForm, 'type')] = 'nullable|in:' . implode(',', array_keys(getCodeList('OrganizationType', 'Organization', false)));
            $narrativeRules = $this->getErrorsForNarrative($receiverOrg['narrative'], $receiverOrgForm);

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
            $message[sprintf('%s.%s.exclude_operators', $receiverOrgForm, 'receiver_activity_id')] = translateRequestMessage('transaction_rec_activity', 'is_not_valid');
            $messages[sprintf('%s.%s.in', $receiverOrgForm, 'type')] = translateRequestMessage('transaction_rec_org', 'type_is_invalid');
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
    public function getWarningForRecipientRegion(array $formFields, bool $fileUpload, array $activityRecipientRegions): array
    {
        if (empty($formFields)) {
            return [];
        }

        $rules = [];
        $activityService = app()->make(ActivityService::class);

        if (!$fileUpload) {
            $params = $this->route()->parameters();

            if ($activityService->hasRecipientRegionDefinedInActivity($params['id']) || $activityService->hasRecipientCountryDefinedInActivity($params['id'])) {
                $this->hasCountryOrRegionDefinedInActivity = true;
            }

            if (!$activityService->isElementEmpty($formFields, 'recipientRegionFields')
                && ($activityService->hasRecipientRegionDefinedInActivity($params['id']) || $activityService->hasRecipientCountryDefinedInActivity($params['id']))) {
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
            $narrativeRules = $this->getWarningForNarrative($recipientRegion['narrative'], $recipientRegionForm);

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
     * returns critical rules for recipient region.
     *
     * @param array $formFields
     * @param bool $fileUpload
     * @param array $activityRecipientRegions
     *
     * @return array
     *
     * @throws JsonException
     */
    public function getErrorsForRecipientRegion(array $formFields, bool $fileUpload, array $activityRecipientRegions): array
    {
        if (empty($formFields)) {
            return [];
        }

        $rules = [];

        foreach ($formFields as $recipientRegionIndex => $recipientRegion) {
            $recipientRegionForm = sprintf('recipient_region.%s', $recipientRegionIndex);
            $rules[sprintf('%s.region_vocabulary', $recipientRegionForm)] = 'nullable|in:' . implode(',', array_keys(getCodeList('RegionVocabulary', 'Activity', false)));
            $rules[sprintf('%s.region_code', $recipientRegionForm)] = 'nullable|in:' . implode(',', array_keys(getCodeList('Region', 'Activity', false)));
            $rules[sprintf('%s.vocabulary_uri', $recipientRegionForm)] = 'nullable|url';

            if (Arr::get($recipientRegion, 'region_vocabulary', 1) === '99') {
                $rules[sprintf('%s.vocabulary_uri', $recipientRegionForm)] = 'nullable|url';
            }
            $narrativeRules = $this->getErrorsForNarrative($recipientRegion['narrative'], $recipientRegionForm);

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
        $messages = [
            'recipient_region.already_in_activity' => translateRequestMessage('recipient_region_or_recipient_country_already_added'),
            'recipient_region.country_or_region' => translateRequestMessage('you_must_add_either_or'),
        ];

        if (!$formFields) {
            return $messages;
        }

        foreach ($formFields as $recipientRegionIndex => $recipientRegion) {
            $recipientRegionForm = sprintf('recipient_region.%s', $recipientRegionIndex);
            $messages[sprintf('%s.region_vocabulary.in', $recipientRegionForm)] = translateRequestMessage('transaction_recipient_region', 'vocabulary_is_invalid');
            $messages[sprintf('%s.region_code.in', $recipientRegionForm)] = translateRequestMessage('transaction_recipient_region', 'code_is_invalid');
            $messages[sprintf('%s.vocabulary_uri.url', $recipientRegionForm)] = translateRequestMessage('transaction_recipient_region', 'must_be_valid_vocal_url');

            if (Arr::get($recipientRegion, 'region_vocabulary', 1) === '99') {
                $messages[sprintf('%s.vocabulary_uri.url', $recipientRegionForm)]
                    = translateRequestMessage('vocab_url_field_symbol', 'must_be_valid_url');
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
    public function getWarningForRecipientCountry(array $formFields, bool $fileUpload, array $activityRecipientCountries): array
    {
        if (empty($formFields)) {
            return [];
        }

        $rules = [];
        $activityService = app()->make(ActivityService::class);

        if (!$fileUpload) {
            $params = $this->route()->parameters();

            if (!$activityService->isElementEmpty($formFields, 'recipientCountryFields')
                && ($activityService->hasRecipientCountryDefinedInActivity($params['id']) || $activityService->hasRecipientRegionDefinedInActivity($params['id']))) {
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
            $narrativeRules = $this->getWarningForNarrative(Arr::get($recipientCountry, 'narrative', []), $recipientCountryForm);

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
     * returns critical rules for recipient country.
     *
     * @param array $formFields
     * @param bool $fileUpload
     * @param array $activityRecipientCountries
     *
     * @return array
     *
     * @throws JsonException
     */
    public function getErrorsForRecipientCountry(array $formFields, bool $fileUpload, array $activityRecipientCountries): array
    {
        if (empty($formFields)) {
            return [];
        }

        $rules = [];

        foreach ($formFields as $recipientCountryIndex => $recipientCountry) {
            $recipientCountryForm = sprintf('recipient_country.%s', $recipientCountryIndex);
            $rules[sprintf('%s.country_code', $recipientCountryForm)] = 'nullable|in:' . implode(',', array_keys(getCodeList('Country', 'Activity', false)));
            $narrativeRules = $this->getErrorsForNarrative(Arr::get($recipientCountry, 'narrative', []), $recipientCountryForm);

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
        $messages = [
            'recipient_country.already_in_activity' => translateRequestMessage('recipient_region_or_recipient_country_already_added'),
            'recipient_country.country_or_region' => translateRequestMessage('you_must_add_either_or'),
        ];

        if (!$formFields) {
            return $messages;
        }

        foreach ($formFields as $recipientCountryIndex => $recipientCountry) {
            $recipientCountryForm = sprintf('recipient_country.%s', $recipientCountryIndex);
            $messages[sprintf('%s.country_code.in', $recipientCountryForm)] = translateRequestMessage('transaction_recipient_country', 'code_is_invalid');
            $narrativeMessages = $this->getMessagesForNarrative(Arr::get($recipientCountry, 'narrative', []), $recipientCountryForm);

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
        $transactionId = isset($params['transactionId']) ? (int) $params['transactionId'] : null;
        $hasDefinedInTransaction = $transactionService->hasRecipientRegionOrCountryDefinedInTransaction($params['id'], $transactionId);

        if ($hasDefinedInTransaction && (is_variable_null($this->all()['recipient_region']) && is_variable_null($this->all()['recipient_country']))) {
            $rules[$attribute] = 'country_or_region';
        } elseif (!is_variable_null($this->all()['recipient_region']) && !is_variable_null($this->all()['recipient_country'])) {
            $rules[$attribute] = 'country_or_region';
        } elseif ($hasDefinedInTransaction && !$this->hasCountryOrRegionDefinedInActivity && is_variable_null($this->all()['recipient_region']) && is_variable_null($this->all()['recipient_country'])) {
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

        if (!is_array_value_empty($recipientRegion) && !is_array_value_empty($recipientCountry)) {
            $rules[$attribute] = 'country_or_region';
        } elseif (!is_array_value_empty($recipientRegion) || !is_array_value_empty($recipientCountry)) {
            Session::put('has_region_or_country_defined_in_transaction', true);
        } elseif ($hasRegionOrCountryDefinedInTransaction && (is_array_value_empty($recipientRegion) && is_array_value_empty($recipientCountry))) {
            $rules[$attribute] = 'country_or_region';
        }

        return $rules;
    }
}
