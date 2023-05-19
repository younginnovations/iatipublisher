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
        $data = $this->get('planned_disbursement');

        $totalRules = [
            $this->getWarningForPlannedDisbursement($data),
            $this->getErrorsForPlannedDisbursement($data),
        ];

        return mergeRules($totalRules);
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
    public function getWarningForPlannedDisbursement(array $formFields): array
    {
        $rules = [];

        foreach ($formFields as $plannedDisbursementIndex => $plannedDisbursement) {
            $plannedDisbursementForm = sprintf('planned_disbursement.%s', $plannedDisbursementIndex);
            $diff = 0;
            $start = $plannedDisbursement['period_start'][0]['date'];
            $end = $plannedDisbursement['period_end'][0]['date'];

            if ($start && $end) {
                $diff = (dateStrToTime($end) - dateStrToTime($start)) / 86400;
            }

            $tempRules = [
                $this->getPlannedDisbursementRulesForPeriodStart($plannedDisbursement['period_start'], $plannedDisbursementForm, $diff),
                $this->getPlannedDisbursementRulesForPeriodEnd($plannedDisbursement['period_end'], $plannedDisbursementForm, $diff),
                $this->getWarningForValue($plannedDisbursement['value'], $plannedDisbursementForm),
                $this->getWarningForProviderOrg($plannedDisbursement['provider_org'], $plannedDisbursementForm),
                $this->getWarningForReceiverOrg($plannedDisbursement['receiver_org'], $plannedDisbursementForm),
            ];

            foreach ($tempRules as $rule) {
                foreach ($rule as $key => $ruleValue) {
                    $rules[$key] = $ruleValue;
                }
            }
        }

        return $rules;
    }

    /**
     * Generates planned disbursement rules.
     *
     * @param array $formFields
     *
     * @return array
     */
    public function getErrorsForPlannedDisbursement(array $formFields): array
    {
        $rules = [];

        foreach ($formFields as $plannedDisbursementIndex => $plannedDisbursement) {
            $plannedDisbursementForm = sprintf('planned_disbursement.%s', $plannedDisbursementIndex);
            $rules[sprintf('%s.planned_disbursement_type', $plannedDisbursementForm)] = 'nullable|in:' . implode(',', array_keys(getCodeList('BudgetType', 'Activity', false)));

            $tempRules = [
                $this->getCriticalPlannedDisbursementRulesForPeriodStart($plannedDisbursement['period_start'], $plannedDisbursementForm),
                $this->getCriticalPlannedDisbursementRulesForPeriodEnd($plannedDisbursement['period_end'], $plannedDisbursementForm),
                $this->getErrorsForValue($plannedDisbursement['value'], $plannedDisbursementForm),
                $this->getErrorsForProviderOrg($plannedDisbursement['provider_org'], $plannedDisbursementForm),
                $this->getErrorsForReceiverOrg($plannedDisbursement['receiver_org'], $plannedDisbursementForm),
            ];

            foreach ($tempRules as $rule) {
                foreach ($rule as $key => $ruleValue) {
                    $rules[$key] = $ruleValue;
                }
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
    public function getWarningForProviderOrg(array $formFields, $formBase): array
    {
        $rules = [];

        foreach ($formFields as $providerOrgIndex => $providerOrg) {
            $providerOrgForm = sprintf('%s.provider_org.%s', $formBase, $providerOrgIndex);
            $rules[sprintf('%s.ref', $providerOrgForm)] = ['nullable', 'not_regex:/(&|!|\/|\||\?)/'];

            foreach ($this->getWarningForNarrative($providerOrg['narrative'], $providerOrgForm) as $providerOrgNarrativeIndex => $providerOrgNarrativeRules) {
                $rules[$providerOrgNarrativeIndex] = $providerOrgNarrativeRules;
            }
        }

        return $rules;
    }

    /**
     * Critical rules for provider org.
     *
     * @param array $formFields
     * @param       $formBase
     *
     * @return array
     */
    public function getErrorsForProviderOrg(array $formFields, $formBase): array
    {
        $rules = [];

        foreach ($formFields as $providerOrgIndex => $providerOrg) {
            $providerOrgForm = sprintf('%s.provider_org.%s', $formBase, $providerOrgIndex);
            $rules[sprintf('%s.type', $providerOrgForm)] = 'nullable|in:' . implode(',', array_keys(getCodeList('OrganizationType', 'Organization', false)));

            foreach ($this->getErrorsForNarrative($providerOrg['narrative'], $providerOrgForm) as $providerOrgNarrativeIndex => $providerOrgNarrativeRules) {
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
    public function getWarningForReceiverOrg(array $formFields, $formBase): array
    {
        $rules = [];

        foreach ($formFields as $receiverOrgIndex => $receiverOrg) {
            $receiverOrgForm = sprintf('%s.receiver_org.%s', $formBase, $receiverOrgIndex);
            $rules[sprintf('%s.ref', $receiverOrgForm)] = ['nullable', 'not_regex:/(&|!|\/|\||\?)/'];

            foreach ($this->getWarningForNarrative($receiverOrg['narrative'], $receiverOrgForm) as $receiverOrgNarrativeIndex => $receiverOrgNarrativeRules) {
                $rules[$receiverOrgNarrativeIndex] = $receiverOrgNarrativeRules;
            }
        }

        return $rules;
    }

    /**
     * Critical rules for receiver org.
     *
     * @param array $formFields
     * @param       $formBase
     *
     * @return array
     */
    public function getErrorsForReceiverOrg(array $formFields, $formBase): array
    {
        $rules = [];

        foreach ($formFields as $receiverOrgIndex => $receiverOrg) {
            $receiverOrgForm = sprintf('%s.receiver_org.%s', $formBase, $receiverOrgIndex);
            $rules[sprintf('%s.type', $receiverOrgForm)] = 'nullable|in:' . implode(',', array_keys(getCodeList('OrganizationType', 'Organization', false)));

            foreach ($this->getErrorsForNarrative($receiverOrg['narrative'], $receiverOrgForm) as $receiverOrgNarrativeIndex => $receiverOrgNarrativeRules) {
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
            $messages[sprintf('%s.value_date.after_or_equal', $valueForm)] = 'The value date field must be a date between period start and period end';
            $messages[sprintf('%s.value_date.before_or_equal', $valueForm)] = 'The value date field must be a date between period start and period end';
            $messages[sprintf('%s.value_date.date', $valueForm)] = 'The Value Date must be a valid Date';
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
            $rules[$formBase . '.period_start.' . $periodStartKey . '.date'] = 'nullable|period_start_end:' . $diff . ',90';
        }

        return $rules;
    }

    /**
     * returns criticalrules for period start form.
     *
     * @param $formFields
     * @param $formBase
     *
     * @return array
     */
    public function getCriticalPlannedDisbursementRulesForPeriodStart($formFields, $formBase): array
    {
        $rules = [];

        foreach ($formFields as $periodStartKey => $periodStartVal) {
            $rules[$formBase . '.period_start.' . $periodStartKey . '.date'] = 'nullable|date';
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
            $messages[$formBase . '.period_start.' . $periodStartKey . '.date.date'] = 'Period Start must be a date.';
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
            $rules[$formBase . '.period_end.' . $periodEndKey . '.date'][] = 'period_start_end:' . $diff . ',90';
            $rules[$formBase . '.period_end.' . $periodEndKey . '.date'][] = sprintf(
                'after_or_equal:%s',
                $formBase . '.period_start.' . $periodEndKey . '.date'
            );
        }

        return $rules;
    }

    /**
     * returns critical rules for period end form.
     *
     * @param $formFields
     * @param $formBase
     *
     * @return array
     */
    public function getCriticalPlannedDisbursementRulesForPeriodEnd($formFields, $formBase): array
    {
        $rules = [];

        foreach ($formFields as $periodEndKey => $periodEndVal) {
            $rules[$formBase . '.period_end.' . $periodEndKey . '.date'][] = 'nullable';
            $rules[$formBase . '.period_end.' . $periodEndKey . '.date'][] = 'date';
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
