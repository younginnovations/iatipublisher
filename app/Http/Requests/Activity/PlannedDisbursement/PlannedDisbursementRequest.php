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
            $start = $plannedDisbursement['period_start'][0]['iso_date'];
            $end = $plannedDisbursement['period_end'][0]['iso_date'];

            if ($start && $end) {
                $diff = (strtotime($end) - strtotime($start)) / 86400;
            }

            $periodStartRules = $this->getPlannedDisbursementRulesForPeriodStart($plannedDisbursement['period_start'], $plannedDisbursementForm, $diff);

            foreach ($periodStartRules as $key => $periodStartRule) {
                $rules[$key] = $periodStartRule;
            }

            $periodEndRules = $this->getPlannedDisbursementRulesForPeriodEnd($plannedDisbursement['period_end'], $plannedDisbursementForm, $diff);

            foreach ($periodEndRules as $key => $periodEndRule) {
                $rules[$key] = $periodEndRule;
            }

            $valueRules = $this->getRulesForValue($plannedDisbursement['value'], $plannedDisbursementForm);

            foreach ($valueRules as $key => $valueRule) {
                $rules[$key] = $valueRule;
            }

            $providerOrgRules = $this->getRulesForProviderOrg($plannedDisbursement['provider_org'], $plannedDisbursementForm);

            foreach ($providerOrgRules as $key => $providerOrgRule) {
                $rules[$key] = $providerOrgRule;
            }

            $receiverOrgRules = $this->getRulesForReceiverOrg($plannedDisbursement['receiver_org'], $plannedDisbursementForm);

            foreach ($receiverOrgRules as $key => $receiverOrgRule) {
                $rules[$key] = $receiverOrgRule;
            }
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

            $periodStartMessages = $this->getMessagesForPeriodStart($plannedDisbursement['period_start'], $plannedDisbursementForm);

            foreach ($periodStartMessages as $key => $periodStartMessage) {
                $messages[$key] = $periodStartMessage;
            }

            $periodEndMessages = $this->getMessagesForPeriodEnd($plannedDisbursement['period_end'], $plannedDisbursementForm);

            foreach ($periodEndMessages as $key => $periodEndMessage) {
                $messages[$key] = $periodEndMessage;
            }

            $valueMessages = $this->getMessagesForValue($plannedDisbursement['value'], $plannedDisbursementForm);

            foreach ($valueMessages as $key => $valueMessage) {
                $messages[$key] = $valueMessage;
            }

            $providerOrgMessages = $this->getMessagesForProviderOrg($plannedDisbursement['provider_org'], $plannedDisbursementForm);

            foreach ($providerOrgMessages as $key => $providerOrgMessage) {
                $messages[$key] = $providerOrgMessage;
            }

            $receiverOrgMessages = $this->getMessagesForReceiverOrg($plannedDisbursement['receiver_org'], $plannedDisbursementForm);

            foreach ($receiverOrgMessages as $key => $receiverOrgMessage) {
                $messages[$key] = $receiverOrgMessage;
            }
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
            $messages[sprintf('%s.value_date.after', $valueForm)] = 'The @value-date field must be a between period start and period end';
            $messages[sprintf('%s.value_date.before', $valueForm)] = 'The @value-date field must be a between period start and period end';
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
            $rules[$formBase . '.period_start.' . $periodStartKey . '.iso_date'] = 'nullable|date|period_start_end:' . $diff . ',90';
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
            $messages[$formBase . '.period_start.' . $periodStartKey . '.iso_date.required'] = trans('validation.required', ['attribute' => trans('elementForm.period_start')]);
            $messages[$formBase . '.period_end.' . $periodStartKey . '.iso_date.date'] = 'Period end must be a date.';
            $messages[$formBase . '.period_end.' . $periodStartKey . '.iso_date.date_greater_than'] = 'Period end date must be date greater than year 1900.';
            $messages[$formBase . '.period_start.' . $periodStartKey . '.iso_date.period_start_end'] = 'The Planned Disbursement Period must not be longer than three months';
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
            $rules[$formBase . '.period_end.' . $periodEndKey . '.iso_date'][] = 'nullable';
            $rules[$formBase . '.period_end.' . $periodEndKey . '.iso_date'][] = 'date';
            $rules[$formBase . '.period_end.' . $periodEndKey . '.iso_date'][] = 'period_start_end:' . $diff . ',90';
            $rules[$formBase . '.period_end.' . $periodEndKey . '.iso_date'][] = sprintf(
                'after:%s',
                $formBase . '.period_start.' . $periodEndKey . '.iso_date'
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
            $messages[$formBase . '.period_end.' . $periodEndKey . '.iso_date.required'] = 'Period end is a required field';
            $messages[$formBase . '.period_end.' . $periodEndKey . '.iso_date.date'] = 'Period end must be a date field';
            $messages[$formBase . '.period_end.' . $periodEndKey . '.iso_date.after'] = 'Period end must be a date after period';
            $messages[$formBase . '.period_end.' . $periodEndKey . '.iso_date.date_greater_than'] = 'Period end date must be date greater than year 1900.';
            $messages[$formBase . '.period_end.' . $periodEndKey . '.iso_date.period_start_end'] = 'The Planned Disbursement Period must not be longer than three months';
        }

        return $messages;
    }
}
