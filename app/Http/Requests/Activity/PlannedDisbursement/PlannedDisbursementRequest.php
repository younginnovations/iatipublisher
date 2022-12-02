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
    public function getRulesForPlannedDisbursement(array $formFields): array
    {
        $rules = [];

        foreach ($formFields as $plannedDisbursementIndex => $plannedDisbursement) {
            $plannedDisbursementForm = sprintf('planned_disbursement.%s', $plannedDisbursementIndex);
            $rules[sprintf('%s.planned_disbursement_type', $plannedDisbursementForm)] = 'nullable|in:' . implode(',', array_keys(getCodeList('BudgetType', 'Activity', false)));
            $diff = 0;
            $start = $plannedDisbursement['period_start'][0]['date'];
            $end = $plannedDisbursement['period_end'][0]['date'];

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
    public function getMessagesForPlannedDisbursement(array $formFields): array
    {
        $messages = [];

        foreach ($formFields as $plannedDisbursementIndex => $plannedDisbursement) {
            $plannedDisbursementForm = sprintf('planned_disbursement.%s', $plannedDisbursementIndex);
            $messages[sprintf('%s.planned_disbursement_type.in', $plannedDisbursementForm)] = 'The planned disbursement type is invalid.';

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
    public function getRulesForProviderOrg(array $formFields, $formBase): array
    {
        $rules = [];

        foreach ($formFields as $providerOrgIndex => $providerOrg) {
            $providerOrgForm = sprintf('%s.provider_org.%s', $formBase, $providerOrgIndex);
            $rules[sprintf('%s.type', $providerOrgForm)] = 'nullable|in:' . implode(',', array_keys(getCodeList('OrganizationType', 'Organization', false)));
            $rules[sprintf('%s.ref', $providerOrgForm)] = ['nullable', 'not_regex:/(&|!|\/|\||\?)/'];

            foreach ($this->getRulesForNarrative($providerOrg['narrative'], $providerOrgForm) as $providerOrgNarrativeIndex => $providerOrgNarrativeRules) {
                $rules[$providerOrgNarrativeIndex] = $providerOrgNarrativeRules;
            }
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
    public function getMessagesForProviderOrg(array $formFields, $formBase): array
    {
        $message = [];

        foreach ($formFields as $providerOrgIndex => $providerOrg) {
            $providerOrgForm = sprintf('%s.provider_org.%s', $formBase, $providerOrgIndex);
            $message[sprintf('%s.type.in', $providerOrgForm)] = 'The planned disbursement provider org type is invalid.';
            $message[sprintf('%s.ref.not_regex', $providerOrgForm)] = 'The planned disbursement provider org ref shouldn\'t contain the symbols /, &, | or ?.';

            foreach ($this->getMessagesForNarrative($providerOrg['narrative'], $providerOrgForm) as $providerOrgNarrativeIndex => $providerOrgNarrativeMessages) {
                $message[$providerOrgNarrativeIndex] = $providerOrgNarrativeMessages;
            }
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
    public function getRulesForReceiverOrg(array $formFields, $formBase): array
    {
        $rules = [];

        foreach ($formFields as $receiverOrgIndex => $receiverOrg) {
            $receiverOrgForm = sprintf('%s.receiver_org.%s', $formBase, $receiverOrgIndex);
            $rules[sprintf('%s.type', $receiverOrgForm)] = 'nullable|in:' . implode(',', array_keys(getCodeList('OrganizationType', 'Organization', false)));
            $rules[sprintf('%s.ref', $receiverOrgForm)] = ['nullable', 'not_regex:/(&|!|\/|\||\?)/'];

            foreach ($this->getRulesForNarrative($receiverOrg['narrative'], $receiverOrgForm) as $receiverOrgNarrativeIndex => $receiverOrgNarrativeRules) {
                $rules[$receiverOrgNarrativeIndex] = $receiverOrgNarrativeRules;
            }
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
    public function getMessagesForReceiverOrg(array $formFields, $formBase): array
    {
        $message = [];

        foreach ($formFields as $receiverOrgIndex => $receiverOrg) {
            $receiverOrgForm = sprintf('%s.receiver_org.%s', $formBase, $receiverOrgIndex);
            $message[sprintf('%s.type.in', $receiverOrgForm)] = 'The planned disbursement receiver org type is invalid.';
            $message[sprintf('%s.ref.not_regex', $receiverOrgForm)] = 'The planned disbursement receiver org ref shouldn\'t contain the symbols /, &, | or ?.';

            foreach ($this->getMessagesForNarrative($receiverOrg['narrative'], $receiverOrgForm) as $receiverOrgNarrativeIndex => $receiverOrgNarrativeMessages) {
                $message[$receiverOrgNarrativeIndex] = $receiverOrgNarrativeMessages;
            }
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
    public function getMessagesForValue($formFields, $formBase): array
    {
        $messages = [];

        foreach ($formFields as $valueIndex => $value) {
            $valueForm = sprintf('%s.value.%s', $formBase, $valueIndex);
            $messages[sprintf('%s.amount.required', $valueForm)] = 'Amount field is required';
            $messages[sprintf('%s.amount.numeric', $valueForm)] = 'Amount field must be a number';
            $messages[sprintf('%s.amount.min', $valueForm)] = 'Amount field must not be in negative.';
            $messages[sprintf('%s.currency.in', $valueForm)] = 'The value currency is invalid.';
            $messages[sprintf('%s.value_date.required', $valueForm)] = 'Value date is a required field';
            $messages[sprintf('%s.value_date.after', $valueForm)] = 'The value date field must be a between period start and period end';
            $messages[sprintf('%s.value_date.before', $valueForm)] = 'The value date field must be a between period start and period end';
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
