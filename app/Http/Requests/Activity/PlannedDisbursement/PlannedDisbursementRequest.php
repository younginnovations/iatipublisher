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
     * Returns planned disbursement rules.
     *
     * @return array
     */
    public function rules(): array
    {
        return $this->getRulesForPlannedDisbursement($this->get('planned_disbursement'));
    }

    /**
     * Custom messages for planned disbursement rules.
     *
     * @return array
     */
    public function messages(): array
    {
        return $this->getMessagesForPlannedDisbursement($this->get('planned_disbursement'));
    }

    /**
     * Generates planned disbursement rules.
     *
     * @param array $formFields
     *
     * @return array
     */
    protected function getRulesForPlannedDisbursement(array $formFields): array
    {
        $rules = [];

        foreach ($formFields as $plannedDisbursementIndex => $plannedDisbursement) {
            $plannedDisbursementForm = sprintf('planned_disbursement.%s', $plannedDisbursementIndex);
            $diff = 0;
            $start = $plannedDisbursement['period_start'][0]['date'];
            $end = $plannedDisbursement['period_end'][0]['date'];

            if ($start && $end) {
                $diff = (strtotime($end) - strtotime($start)) / 86400;
            }

            $rules = array_merge(
                $rules,
                $this->getPlannedDisbursementRulesForPeriodStart($plannedDisbursement['period_start'], $plannedDisbursementForm, $diff),
                $this->getPlannedDisbursementRulesForPeriodEnd($plannedDisbursement['period_end'], $plannedDisbursementForm, $diff),
                $this->getRulesForValue($plannedDisbursement['value'], $plannedDisbursementForm),
                $this->getRulesForProviderOrg($plannedDisbursement['provider_org'], $plannedDisbursementForm),
                $this->getRulesForReceiverOrg($plannedDisbursement['receiver_org'], $plannedDisbursementForm)
            );
        }

        return $rules;
    }

    /**
     * Generates custom error message.
     *
     * @param array $formFields
     *
     * @return array
     */
    protected function getMessagesForPlannedDisbursement(array $formFields): array
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
     * Rules for provider org.
     *
     * @param array $formFields
     * @param       $formBase
     *
     * @return array
     */
    protected function getRulesForProviderOrg(array $formFields, $formBase): array
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
     * Messages for provider org.
     *
     * @param array $formFields
     * @param       $formBase
     *
     * @return array
     */
    protected function getMessagesForProviderOrg(array $formFields, $formBase): array
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
     * Rules for receiver org.
     *
     * @param array $formFields
     * @param       $formBase
     *
     * @return array
     */
    protected function getRulesForReceiverOrg(array $formFields, $formBase): array
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
     * Messages for receiver org.
     *
     * @param array $formFields
     * @param       $formBase
     *
     * @return array
     */
    protected function getMessagesForReceiverOrg(array $formFields, $formBase): array
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
     * Rules for value.
     *
     * @param $formFields
     * @param $formBase
     *
     * @return array
     */
    protected function getRulesForValue($formFields, $formBase): array
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
     * Messages for value.
     *
     * @param $formFields
     * @param $formBase
     *
     * @return array
     */
    protected function getMessagesForValue($formFields, $formBase): array
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
     *
     * @param $formFields
     * @param $formBase
     *
     * @return array
     */
    public function getPlannedDisbursementRulesForPeriodStart($formFields, $formBase, $diff): array
    {
        $rules = [];

        foreach ($formFields as $periodStartKey => $periodStartVal) {
            $rules[$formBase . '.period_start.' . $periodStartKey . '.date'] = 'nullable|date|period_start_end:' . $diff . ',90';
        }

        return $rules;
    }

    /**
     * returns messages for period start form.
     *
     * @param $formFields
     * @param $formBase
     *
     * @return array
     */
    public function getMessagesForPeriodStart($formFields, $formBase): array
    {
        $messages = [];

        foreach ($formFields as $periodStartKey => $periodStartVal) {
            $messages[$formBase . '.period_start.' . $periodStartKey . '.date.required'] = trans('validation.required', ['attribute' => trans('elementForm.period_start')]);
            $messages[$formBase . '.period_end.' . $periodStartKey . '.date.date'] = 'Period end must be a date.';
            $messages[$formBase . '.period_end.' . $periodStartKey . '.date.date_greater_than'] = 'Period end date must be date greater than year 1900.';
            $messages[$formBase . '.period_start.' . $periodStartKey . '.date.period_start_end'] = 'The Planned Disbursement Period must not be longer than three months';
        }

        return $messages;
    }

    /**
     * returns rules for period end form.
     *
     * @param $formFields
     * @param $formBase
     * @param $diff
     *
     * @return array
     */
    public function getPlannedDisbursementRulesForPeriodEnd($formFields, $formBase, $diff): array
    {
        $rules = [];

        foreach ($formFields as $periodEndKey => $periodEndVal) {
            $rules[$formBase . '.period_end.' . $periodEndKey . '.date'][] = 'nullable';
            $rules[$formBase . '.period_end.' . $periodEndKey . '.date'][] = 'date';
            $rules[$formBase . '.period_end.' . $periodEndKey . '.date'][] = 'period_start_end:' . $diff . ',90';
            $rules[$formBase . '.period_end.' . $periodEndKey . '.date'][] = sprintf(
                'after:%s',
                $formBase . '.period_start.' . $periodEndKey . '.date'
            );
        }

        return $rules;
    }

    /**
     * returns messages for period end form.
     *
     * @param $formFields
     * @param $formBase
     *
     * @return array
     */
    public function getMessagesForPeriodEnd($formFields, $formBase): array
    {
        $messages = [];

        foreach ($formFields as $periodEndKey => $periodEndVal) {
            $messages[$formBase . '.period_end.' . $periodEndKey . '.date.required'] = 'Period end is a required field';
            $messages[$formBase . '.period_end.' . $periodEndKey . '.date.date'] = 'Period end must be a date field';
            $messages[$formBase . '.period_end.' . $periodEndKey . '.date.after'] = 'Period end must be a date after period';
            $messages[$formBase . '.period_end.' . $periodEndKey . '.date.date_greater_than'] = 'Period end date must be date greater than year 1900.';
            $messages[$formBase . '.period_end.' . $periodEndKey . '.date.period_start_end'] = 'The Planned Disbursement Period must not be longer than three months';
        }

        return $messages;
    }
}
