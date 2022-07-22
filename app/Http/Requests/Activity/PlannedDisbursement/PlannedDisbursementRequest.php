<?php

declare(strict_types=1);

namespace App\Http\Requests\Activity\PlannedDisbursement;

use App\Http\Requests\Activity\ActivityBaseRequest;

/**
 * Class PlannedDisbursementRequest.
 */
class PlannedDisbursementRequest extends ActivityBaseRequest
{
    /**
     * @return array
     */
    public function rules()
    {
        return $this->getRulesForPlannedDisbursement($this->get('planned_disbursement'));
    }

    /**
     * @return array
     */
    public function messages()
    {
        return $this->getMessagesForPlannedDisbursement($this->get('planned_disbursement'));
    }

    /**
     * @param array $formFields
     * @return array
     */
    protected function getRulesForPlannedDisbursement(array $formFields)
    {
        $rules = [];

        foreach ($formFields as $plannedDisbursementIndex => $plannedDisbursement) {
            $plannedDisbursementForm = sprintf('planned_disbursement.%s', $plannedDisbursementIndex);

            $rules = array_merge(
                $rules,
                $this->getRulesForPeriodStart($plannedDisbursement['period_start'], $plannedDisbursementForm),
                $this->getRulesForPeriodEnd($plannedDisbursement['period_end'], $plannedDisbursementForm),
                $this->getRulesForValue($plannedDisbursement['value'], $plannedDisbursementForm),
                $this->getRulesForProviderOrg($plannedDisbursement['provider_org'], $plannedDisbursementForm),
                $this->getRulesForReceiverOrg($plannedDisbursement['receiver_org'], $plannedDisbursementForm)
            );
        }

        return $rules;
    }

    /**
     * @param array $formFields
     * @return array
     */
    protected function getMessagesForPlannedDisbursement(array $formFields)
    {
        $messages = [];

        foreach ($formFields as $plannedDisbursementIndex => $plannedDisbursement) {
            $plannedDisbursementForm = sprintf('planned_disbursement.%s', $plannedDisbursementIndex);

            $messages = array_merge(
                $messages,
                $this->getMessagesForPeriodStart($plannedDisbursement['period_start'], $plannedDisbursementForm),
                $this->getMessagesForPeriodEnd($plannedDisbursement['period_end'], $plannedDisbursementForm),
                $this->getMessagesForValue($plannedDisbursement['value'], $plannedDisbursementForm),
                $this->getMessagesForProviderOrg($plannedDisbursement['provider_org'], $plannedDisbursementForm),
                $this->getMessagesForReceiverOrg($plannedDisbursement['receiver_org'], $plannedDisbursementForm)
            );
        }

        return $messages;
    }

    /**
     * @param array $formFields
     * @param       $formBase
     * @return array
     */
    protected function getRulesForProviderOrg(array $formFields, $formBase)
    {
        $rules = [];

        foreach ($formFields as $providerOrgIndex => $providerOrg) {
            $providerOrgForm = sprintf('%s.provider_org.%s', $formBase, $providerOrgIndex);
            $rules = array_merge(
                $rules,
                $this->getRulesForNarrative($providerOrg['narrative'], $providerOrgForm)
            );
        }

        return $rules;
    }

    /**
     * @param array $formFields
     * @param       $formBase
     * @return array
     */
    protected function getMessagesForProviderOrg(array $formFields, $formBase)
    {
        $message = [];

        foreach ($formFields as $providerOrgIndex => $providerOrg) {
            $providerOrgForm = sprintf('%s.provider_org.%s', $formBase, $providerOrgIndex);
            $message = array_merge(
                $message,
                $this->getMessagesForNarrative($providerOrg['narrative'], $providerOrgForm)
            );
        }

        return $message;
    }

    /**
     * @param array $formFields
     * @param       $formBase
     * @return array
     */
    protected function getRulesForReceiverOrg(array $formFields, $formBase)
    {
        $rules = [];

        foreach ($formFields as $receiverOrgIndex => $receiverOrg) {
            $receiverOrgForm = sprintf('%s.receiver_org.%s', $formBase, $receiverOrgIndex);
            $rules = array_merge(
                $rules,
                $this->getRulesForNarrative($receiverOrg['narrative'], $receiverOrgForm)
            );
        }

        return $rules;
    }

    /**
     * @param array $formFields
     * @param       $formBase
     * @return array
     */
    protected function getMessagesForReceiverOrg(array $formFields, $formBase)
    {
        $message = [];

        foreach ($formFields as $receiverOrgIndex => $receiverOrg) {
            $receiverOrgForm = sprintf('%s.receiver_org.%s', $formBase, $receiverOrgIndex);
            $message = array_merge(
                $message,
                $this->getMessagesForNarrative($receiverOrg['narrative'], $receiverOrgForm)
            );
        }

        return $message;
    }

    /**
     * @param $formFields
     * @param $formBase
     * @return array
     */
    protected function getRulesForValue($formFields, $formBase)
    {
        $rules = [];
        foreach ($formFields as $valueIndex => $value) {
            $valueForm = sprintf('%s.value.%s', $formBase, $valueIndex);
            $rules[sprintf('%s.amount', $valueForm)] = 'nullable|numeric';
            $rules[sprintf('%s.value_date', $valueForm)] = 'nullable|date';
        }

        return $rules;
    }

    /**
     * @param $formFields
     * @param $formBase
     * @return array
     */
    protected function getMessagesForValue($formFields, $formBase)
    {
        $messages = [];
        foreach ($formFields as $valueIndex => $value) {
            $valueForm = sprintf('%s.value.%s', $formBase, $valueIndex);
            $messages[sprintf('%s.amount.required', $valueForm)] = 'Amount field is required';
            $messages[sprintf('%s.amount.numeric', $valueForm)] = 'Amount field must be a number';
            $messages[sprintf('%s.value_date.required', $valueForm)] = 'Value date is a required field';
        }

        return $messages;
    }

    /**
     * returns rules for period start form.
     * @param $formFields
     * @param $formBase
     * @return array
     */
    public function getRulesForPeriodStart($formFields, $formBase)
    {
        $rules = [];
        foreach ($formFields as $periodStartKey => $periodStartVal) {
            $rules[$formBase . '.period_start.' . $periodStartKey . '.iso_date'] = 'date';
        }

        return $rules;
    }

    /**
     * returns messages for period start form.
     * @param $formFields
     * @param $formBase
     * @return array
     */
    public function getMessagesForPeriodStart($formFields, $formBase)
    {
        $messages = [];
        foreach ($formFields as $periodStartKey => $periodStartVal) {
            $messages[$formBase . '.period_start.' . $periodStartKey . '.iso_date.required'] = trans('validation.required', ['attribute' => trans('elementForm.period_start')]);
            $messages[$formBase . '.period_end.' . $periodStartKey . '.iso_date.date'] = 'Period end must be a date.';
            $messages[$formBase . '.period_end.' . $periodStartKey . '.iso_date.date_greater_than'] = 'Period end date must be date greater than year 1900.';
        }

        return $messages;
    }

    /**
     * returns rules for period end form.
     * @param $formFields
     * @param $formBase
     * @return array
     */
    public function getRulesForPeriodEnd($formFields, $formBase)
    {
        $rules = [];

        foreach ($formFields as $periodEndKey => $periodEndVal) {
            $rules[$formBase . '.period_end.' . $periodEndKey . '.iso_date'][] = 'date';
            $rules[$formBase . '.period_end.' . $periodEndKey . '.iso_date'][] = sprintf(
                'after:%s',
                $formBase . '.period_start.' . $periodEndKey . '.iso_date'
            );
        }

        return $rules;
    }

    /**
     * returns messages for period end form.
     * @param $formFields
     * @param $formBase
     * @return array
     */
    public function getMessagesForPeriodEnd($formFields, $formBase)
    {
        $messages = [];

        foreach ($formFields as $periodEndKey => $periodEndVal) {
            $messages[$formBase . '.period_end.' . $periodEndKey . '.iso_date.required'] = 'Period end is a required field';
            $messages[$formBase . '.period_end.' . $periodEndKey . '.iso_date.date'] = 'Period end must be a date field';
            $messages[$formBase . '.period_end.' . $periodEndKey . '.iso_date.after'] = 'Period end must be a date after period';
            $messages[$formBase . '.period_end.' . $periodEndKey . '.iso_date.date_greater_than'] = 'Period end date must be date greater than year 1900.';
        }

        return $messages;
    }
}
