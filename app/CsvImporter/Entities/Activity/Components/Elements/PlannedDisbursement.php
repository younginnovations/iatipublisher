<?php

declare(strict_types=1);

namespace App\CsvImporter\Entities\Activity\Components\Elements;

use App\CsvImporter\Entities\Activity\Components\Elements\Foundation\Iati\Element;
use App\CsvImporter\Entities\Activity\Components\Factory\Validation;
use Illuminate\Support\Arr;

/**
 * Class PlannedDisbursement.
 */
class PlannedDisbursement extends Element
{
    /**
     * Csv Header for PlannedDisbursement element.
     * @var array
     */
    private array $_csvHeaders
    = [
        'planned_disbursement_type',
        'planned_disbursement_period_start',
        'planned_disbursement_period_end',
        'planned_disbursement_value',
        'planned_disbursement_value_currency',
        'planned_disbursement_value_date',
        'planned_disbursement_provider_org_reference',
        'planned_disbursement_provider_org_activity_id',
        'planned_disbursement_provider_org_type',
        'planned_disbursement_provider_org_narrative',
        'planned_disbursement_receiver_org_reference',
        'planned_disbursement_receiver_org_activity_id',
        'planned_disbursement_receiver_org_type',
        'planned_disbursement_receiver_org_narrative',
    ];

    /**
     * Index under which the data is stored within the object.
     *
     * @var string
     */
    protected string $index = 'planned_disbursement';

    /**
     * PlannedDisbursement constructor.
     *
     * @param            $fields
     * @param Validation $factory
     */
    public function __construct($fields, Validation $factory)
    {
        $this->prepare($fields);
        $this->factory = $factory;
    }

    /**
     * Prepare PlannedDisbursement element.
     *
     * @param $fields
     *
     * @return void
     */
    public function prepare($fields): void
    {
        foreach ($fields as $key => $values) {
            if (!is_null($values) && array_key_exists($key, array_flip($this->_csvHeaders))) {
                foreach ($values as $index => $value) {
                    $this->map($key, $index, $value);
                }
            }
        }
    }

    /**
     * Map data from CSV file into PlannedDisbursement data format.
     *
     * @param $key
     * @param $index
     * @param $value
     *
     * @return void
     */
    public function map($key, $index, $value): void
    {
        if (!(is_null($value) || $value === '')) {
            $this->setPlannedDisbursementType($key, $value, $index);
            $this->setPlannedDisbursementPeriodStart($key, $value, $index);
            $this->setPlannedDisbursementPeriodEnd($key, $value, $index);
            $this->setPlannedDisbursementValue($key, $value, $index);
            $this->setPlannedDisbursementProviderOrg($key, $value, $index);
            $this->setPlannedDisbursementReceiverOrg($key, $value, $index);
        }
    }

    /**
     * Maps PlannedDisbursement Type.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setPlannedDisbursementType($key, $value, $index): void
    {
        if ($key === $this->_csvHeaders[0]) {
            $value = (!$value) ? '' : trim($value);

            $validType = $this->loadCodeList('BudgetType');

            if ($value) {
                foreach ($validType as $code => $name) {
                    if (strcasecmp($value, $name) === 0) {
                        $value = strval($code);
                        break;
                    }
                }
            }

            $this->data['planned_disbursement'][$index]['planned_disbursement_type'] = $value;
        }
    }

    /**
     * Maps PlannedDisbursement PeriodStart.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setPlannedDisbursementPeriodStart($key, $value, $index): void
    {
        if ($key === $this->_csvHeaders[1]) {
            $value = (!$value) ? '' : trim($value);
            $this->data['planned_disbursement'][$index]['period_start'][0]['date'] = dateFormat('Y-m-d', $value);
        }
    }

    /**
     * Maps PlannedDisbursement PeriodEnd.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setPlannedDisbursementPeriodEnd($key, $value, $index): void
    {
        if ($key === $this->_csvHeaders[2]) {
            $value = (!$value) ? '' : trim($value);
            $this->data['planned_disbursement'][$index]['period_end'][0]['date'] = dateFormat('Y-m-d', $value);
        }
    }

    /**
     * Maps PlannedDisbursement Value component.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setPlannedDisbursementValue($key, $value, $index): void
    {
        if ($key === $this->_csvHeaders[3]) {
            $value = (!$value) ? '' : trim($value);
            $this->data['planned_disbursement'][$index]['value'][0]['amount'] = $value;
            $this->data['planned_disbursement'][$index]['value'][0]['currency'] = Arr::get($this->data(), 'planned_disbursement.' . $index . '.value.0.currency', null) ?? '';
        } elseif ($key === $this->_csvHeaders[4]) {
            $value = (!$value) ? '' : trim($value);
            $validCurrency = $this->loadCodeList('Currency');

            if ($value) {
                foreach ($validCurrency as $code => $name) {
                    if (strcasecmp($value, $name) === 0) {
                        $value = strval($code);
                        break;
                    }
                }
            }

            $this->data['planned_disbursement'][$index]['value'][0]['currency'] = strtoupper($value);
        } elseif ($key === $this->_csvHeaders[5]) {
            $value = (!$value) ? '' : trim($value);
            $this->data['planned_disbursement'][$index]['value'][0]['value_date'] = dateFormat('Y-m-d', $value);
        }
    }

    /**
     * Maps PlannedDisbursement Provider Org.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setPlannedDisbursementProviderOrg($key, $value, $index): void
    {
        if ($key === $this->_csvHeaders[6]) {
            $value = (!$value) ? '' : trim($value);
            $this->data['planned_disbursement'][$index]['provider_org'][0]['ref'] = $value;
        } elseif ($key === $this->_csvHeaders[7]) {
            $value = (!$value) ? '' : trim($value);
            $this->data['planned_disbursement'][$index]['provider_org'][0]['provider_activity_id'] = $value;
        } elseif ($key === $this->_csvHeaders[8]) {
            $value = (!$value) ? '' : trim($value);
            $validProviderOrgType = $this->loadCodeList('OrganizationType', 'Organization');

            if ($value) {
                foreach ($validProviderOrgType as $code => $name) {
                    if (strcasecmp($value, $name) === 0) {
                        $value = strval($code);
                        break;
                    }
                }
            }

            $this->data['planned_disbursement'][$index]['provider_org'][0]['type'] = $value;
        } elseif ($key === $this->_csvHeaders[9]) {
            $value = $value ?: '';
            $narrative = [
                'narrative' => $value,
                'language'  => '',
            ];

            $this->data['planned_disbursement'][$index]['provider_org'][0]['narrative'][] = $narrative;
        }
    }

    /**
     * Maps PlannedDisbursement Receiver Org.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setPlannedDisbursementReceiverOrg($key, $value, $index): void
    {
        if ($key === $this->_csvHeaders[10]) {
            $value = (!$value) ? '' : trim($value);
            $this->data['planned_disbursement'][$index]['receiver_org'][0]['ref'] = $value;
        } elseif ($key === $this->_csvHeaders[11]) {
            $value = (!$value) ? '' : trim($value);
            $this->data['planned_disbursement'][$index]['receiver_org'][0]['receiver_activity_id'] = $value;
        } elseif ($key === $this->_csvHeaders[12]) {
            $value = (!$value) ? '' : trim($value);
            $validReceiverOrgType = $this->loadCodeList('OrganizationType', 'Organization');

            if ($value) {
                foreach ($validReceiverOrgType as $code => $name) {
                    if (strcasecmp($value, $name) === 0) {
                        $value = strval($code);
                        break;
                    }
                }
            }

            $this->data['planned_disbursement'][$index]['receiver_org'][0]['type'] = $value;
        } elseif ($key === $this->_csvHeaders[13]) {
            $value = $value ?: '';
            $narrative = [
                'narrative' => $value,
                'language'  => '',
            ];

            $this->data['planned_disbursement'][$index]['receiver_org'][0]['narrative'][] = $narrative;
        }
    }

    /**
     * Provides the rules for the IATI Element validation.
     *
     * @return array
     * @throws \JsonException
     */
    public function rules(): array
    {
        $validPlannedDisbursementType = implode(',', $this->validPlannedDisbursementCodeList('BudgetType'));
        $validCurrency = implode(',', $this->validPlannedDisbursementCodeList('Currency'));
        $validOrganizationType = implode(',', $this->validPlannedDisbursementCodeList('OrganizationType', 'Organization'));
        $rules = [];

        foreach (Arr::get($this->data(), 'planned_disbursement', []) as $key => $value) {
            $plannedDisbursementForm = sprintf('planned_disbursement.%s', $key);
            $diff = 0;
            $start = Arr::get($value, 'period_start.0.date', null);
            $end = Arr::get($value, 'period_end.0.date', null);

            if ($start && $end) {
                $diff = (dateStrToTime($end) - dateStrToTime($start)) / 86400;
            }

            $rules[sprintf('%s.planned_disbursement_type', $plannedDisbursementForm)] = sprintf(
                'nullable|in:%s',
                $validPlannedDisbursementType,
            );
            $rules[sprintf('%s.period_start.0.date', $plannedDisbursementForm)] = sprintf(
                'date|date_greater_than:1900|period_start_end:%s,90|required_with: %s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s',
                $diff,
                sprintf('%s.planned_disbursement_type', $plannedDisbursementForm),
                sprintf('%s.period_end.0.date', $plannedDisbursementForm),
                sprintf('%s.value.0.amount', $plannedDisbursementForm),
                sprintf('%s.value.0.currency', $plannedDisbursementForm),
                sprintf('%s.value.0.value_date', $plannedDisbursementForm),
                sprintf('%s.provider_org.0.ref', $plannedDisbursementForm),
                sprintf('%s.provider_org.0.provider_org_id', $plannedDisbursementForm),
                sprintf('%s.provider_org.0.type', $plannedDisbursementForm),
                sprintf('%s.provider_org.0.narrative.0.narrative', $plannedDisbursementForm),
                sprintf('%s.receiver_org.0.ref', $plannedDisbursementForm),
                sprintf('%s.receiver_org.0.receiver_org_id', $plannedDisbursementForm),
                sprintf('%s.receiver_org.0.type', $plannedDisbursementForm),
                sprintf('%s.receiver_org.0.narrative.0.narrative', $plannedDisbursementForm),
            );

            $rules[sprintf('%s.period_end.0.date', $plannedDisbursementForm)] = sprintf(
                'date|date_greater_than:1900|period_start_end:%s,90|after:%s.period_start.0.date|required_with: %s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s',
                $diff,
                $plannedDisbursementForm,
                sprintf('%s.planned_disbursement_type', $plannedDisbursementForm),
                sprintf('%s.period_start.0.date', $plannedDisbursementForm),
                sprintf('%s.value.0.amount', $plannedDisbursementForm),
                sprintf('%s.value.0.currency', $plannedDisbursementForm),
                sprintf('%s.value.0.value_date', $plannedDisbursementForm),
                sprintf('%s.provider_org.0.ref', $plannedDisbursementForm),
                sprintf('%s.provider_org.0.provider_org_id', $plannedDisbursementForm),
                sprintf('%s.provider_org.0.type', $plannedDisbursementForm),
                sprintf('%s.provider_org.0.narrative.0.narrative', $plannedDisbursementForm),
                sprintf('%s.receiver_org.0.ref', $plannedDisbursementForm),
                sprintf('%s.receiver_org.0.receiver_org_id', $plannedDisbursementForm),
                sprintf('%s.receiver_org.0.type', $plannedDisbursementForm),
                sprintf('%s.receiver_org.0.narrative.0.narrative', $plannedDisbursementForm),
            );
            $rules[sprintf('%s.value.0.amount', $plannedDisbursementForm)] = sprintf(
                'nullable|numeric|required_with: %s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s',
                sprintf('%s.planned_disbursement_type', $plannedDisbursementForm),
                sprintf('%s.period_start.0.date', $plannedDisbursementForm),
                sprintf('%s.period_end.0.date', $plannedDisbursementForm),
                sprintf('%s.value.0.currency', $plannedDisbursementForm),
                sprintf('%s.value.0.value_date', $plannedDisbursementForm),
                sprintf('%s.provider_org.0.ref', $plannedDisbursementForm),
                sprintf('%s.provider_org.0.provider_org_id', $plannedDisbursementForm),
                sprintf('%s.provider_org.0.type', $plannedDisbursementForm),
                sprintf('%s.provider_org.0.narrative.0.narrative', $plannedDisbursementForm),
                sprintf('%s.receiver_org.0.ref', $plannedDisbursementForm),
                sprintf('%s.receiver_org.0.receiver_org_id', $plannedDisbursementForm),
                sprintf('%s.receiver_org.0.type', $plannedDisbursementForm),
                sprintf('%s.receiver_org.0.narrative.0.narrative', $plannedDisbursementForm),
            );
            $rules[sprintf('%s.value.0.currency', $plannedDisbursementForm)] = sprintf(
                'sometimes|in:%s',
                $validCurrency
            );
            $rules[sprintf('%s.value.0.value_date', $plannedDisbursementForm)] = sprintf(
                'nullable|date|date_greater_than:1900|required_with: %s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s',
                sprintf('%s.planned_disbursement_type', $plannedDisbursementForm),
                sprintf('%s.period_start.0.date', $plannedDisbursementForm),
                sprintf('%s.period_end.0.date', $plannedDisbursementForm),
                sprintf('%s.value.0.currency', $plannedDisbursementForm),
                sprintf('%s.value.0.amount', $plannedDisbursementForm),
                sprintf('%s.provider_org.0.ref', $plannedDisbursementForm),
                sprintf('%s.provider_org.0.provider_org_id', $plannedDisbursementForm),
                sprintf('%s.provider_org.0.type', $plannedDisbursementForm),
                sprintf('%s.provider_org.0.narrative.0.narrative', $plannedDisbursementForm),
                sprintf('%s.receiver_org.0.ref', $plannedDisbursementForm),
                sprintf('%s.receiver_org.0.receiver_org_id', $plannedDisbursementForm),
                sprintf('%s.receiver_org.0.type', $plannedDisbursementForm),
                sprintf('%s.receiver_org.0.narrative.0.narrative', $plannedDisbursementForm),
            );
            $rules[sprintf('%s.provider_org.0.type', $plannedDisbursementForm)] = sprintf(
                'nullable|in:%s',
                $validOrganizationType
            );
            $rules[sprintf('%s.receiver_org.0.type', $plannedDisbursementForm)] = sprintf(
                'nullable|in:%s',
                $validOrganizationType
            );
        }

        return $rules;
    }

    /**
     * Return Valid PlannedDisbursement Type.
     *
     * @param $name
     * @param string $directory
     *
     * @return array
     * @throws \JsonException
     */
    protected function validPlannedDisbursementCodeList($name, string $directory = 'Activity'): array
    {
        return array_keys($this->loadCodeList($name, $directory));
    }

    /**
     * Provides custom messages used for IATI Element Validation.
     *
     * @return array
     */
    public function messages(): array
    {
        $messages = [];

        foreach (Arr::get($this->data(), 'planned_disbursement', []) as $key => $value) {
            $plannedDisbursementForm = sprintf('planned_disbursement.%s', $key);
            $messages[sprintf('%s.planned_disbursement_type.%s', $plannedDisbursementForm, 'in')] = trans(
                'validation.code_list',
                ['attribute' => trans('elementForm.planned_disbursement_type')]
            );
            $messages[sprintf('%s.period_start.0.date.%s', $plannedDisbursementForm, 'date')] = trans(
                'validation.date',
                ['attribute' => trans('elementForm.planned_disbursement_period_start_date')]
            );
            $messages[sprintf('%s.period_start.0.date.%s', $plannedDisbursementForm, 'date_greater_than')] = 'Planned disbursement period start date must be greater than 1900';
            $messages[sprintf('%s.period_start.0.date.%s', $plannedDisbursementForm, 'required_with')] = trans(
                'validation.required_with',
                ['attribute' => trans('elementForm.planned_disbursement_period_start_date'), 'values' => 'any planned disbursement element values']
            );
            $messages[sprintf('%s.period_start.0.date.%s', $plannedDisbursementForm, 'period_start_end')] = 'The Planned Disbursement Period must not be longer than three months';
            $messages[sprintf('%s.period_end.0.date.%s', $plannedDisbursementForm, 'date')] = trans(
                'validation.date',
                ['attribute' => trans('elementForm.planned_disbursement_period_end_date')]
            );
            $messages[sprintf('%s.period_end.0.date.%s', $plannedDisbursementForm, 'date_greater_than')] = 'Planned disbursement period end date must be greater than 1900';
            $messages[sprintf('%s.period_end.0.date.%s', $plannedDisbursementForm, 'required_with')] = trans(
                'validation.required_with',
                ['attribute' => trans('elementForm.planned_disbursement_period_end_date'), 'values' => 'any planned disbursement element values']
            );
            $messages[sprintf('%s.period_end.0.date.%s', $plannedDisbursementForm, 'period_start_end')] = 'The Planned Disbursement Period must not be longer than three months';
            $messages[sprintf('%s.period_end.0.date.%s', $plannedDisbursementForm, 'after')] = trans(
                'validation.after',
                ['attribute' => trans('elementForm.planned_disbursement_period_end_date'), 'date' => trans('elementForm.planned_disbursement_period_start_date')]
            );
            $messages[sprintf('%s.value.0.amount.%s', $plannedDisbursementForm, 'numeric')] = trans(
                'validation.numeric',
                ['attribute' => trans('elementForm.planned_disbursement_value')]
            );
            $messages[sprintf('%s.value.0.amount.%s', $plannedDisbursementForm, 'required_with')] = trans(
                'validation.required_with',
                ['attribute' => trans('elementForm.planned_disbursement_value'), 'values' => 'any planned disbursement element values']
            );
            $messages[sprintf('%s.value.0.currency.%s', $plannedDisbursementForm, 'in')] = trans(
                'validation.code_list',
                ['attribute' => trans('elementForm.planned_disbursement_value_currency')]
            );
            $messages[sprintf('%s.value.0.currency.%s', $plannedDisbursementForm, 'required_with')] = trans(
                'validation.required_with',
                ['attribute' => trans('elementForm.planned_disbursement_value_currency'), 'values' => 'any planned disbursement element values']
            );
            $messages[sprintf('%s.value.0.value_date.%s', $plannedDisbursementForm, 'date')] = trans(
                'validation.date',
                ['attribute' => trans('elementForm.planned_disbursement_value_date')]
            );
            $messages[sprintf('%s.value.0.value_date.%s', $plannedDisbursementForm, 'date_greater_than')] = 'Planned disbursement value date must be greater than 1900';
            $messages[sprintf('%s.value.0.value_date.%s', $plannedDisbursementForm, 'required_with')] = trans(
                'validation.required_with',
                ['attribute' => trans('elementForm.planned_disbursement_value_date'), 'values' => 'any planned disbursement element values']
            );
            $messages[sprintf('%s.provider_org.0.type.%s', $plannedDisbursementForm, 'in')] = trans(
                'validation.code_list',
                ['attribute' => trans('elementForm.planned_disbursement_provider_org_type')]
            );
            $messages[sprintf('%s.receiver_org.0.type.%s', $plannedDisbursementForm, 'in')] = trans(
                'validation.code_list',
                ['attribute' => trans('elementForm.planned_disbursement_receiver_org_type')]
            );
        }

        return $messages;
    }

    /**
     * Validate data for IATI Element.
     *
     * @return $this
     * @throws \JsonException
     */
    public function validate(): static
    {
        $this->validator = $this->factory->sign($this->data())
            ->with($this->rules(), $this->messages())
            ->getValidatorInstance();
        $this->setValidity();

        return $this;
    }
}
