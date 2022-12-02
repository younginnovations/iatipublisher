<?php

declare(strict_types=1);

namespace App\CsvImporter\Entities\Activity\Components\Elements;

use App\CsvImporter\Entities\Activity\Components\Elements\Foundation\Iati\Element;
use App\CsvImporter\Entities\Activity\Components\Factory\Validation;
use App\Http\Requests\Activity\PlannedDisbursement\PlannedDisbursementRequest;
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
     * @var PlannedDisbursementRequest
     */
    private PlannedDisbursementRequest $request;

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
        $this->request = new PlannedDisbursementRequest();
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
        // if (!(is_null($value) || $value === '')) {
        $this->setPlannedDisbursementType($key, $value, $index);
        $this->setPlannedDisbursementPeriodStart($key, $value, $index);
        $this->setPlannedDisbursementPeriodEnd($key, $value, $index);
        $this->setPlannedDisbursementValue($key, $value, $index);
        $this->setPlannedDisbursementProviderOrg($key, $value, $index);
        $this->setPlannedDisbursementReceiverOrg($key, $value, $index);
        // }
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
        if (!isset($this->data['planned_disbursement'][$index]['planned_disbursement_type'])) {
            $this->data['planned_disbursement'][$index]['planned_disbursement_type'] = '';
        }

        if ($key === $this->_csvHeaders[0]) {
            $value = (!$value) ? '' : trim($value);

            $validType = $this->loadCodeList('BudgetType');

            if ($value) {
                foreach ($validType as $code => $name) {
                    if (strcasecmp($value, $name) === 0) {
                        $value = (string) $code;
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
        if (!isset($this->data['planned_disbursement'][$index]['period_start'][0]['date'])) {
            $this->data['planned_disbursement'][$index]['period_start'][0]['date'] = '';
        }

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
        if (!isset($this->data['planned_disbursement'][$index]['period_end'][0]['date'])) {
            $this->data['planned_disbursement'][$index]['period_end'][0]['date'] = '';
        }

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
        if (!isset($this->data['planned_disbursement'][$index]['value'][0]['amount'])) {
            $this->data['planned_disbursement'][$index]['value'][0]['amount'] = '';
        }

        if (!isset($this->data['planned_disbursement'][$index]['value'][0]['currency'])) {
            $this->data['planned_disbursement'][$index]['value'][0]['currency'] = '';
        }

        if (!isset($this->data['planned_disbursement'][$index]['value'][0]['value_date'])) {
            $this->data['planned_disbursement'][$index]['value'][0]['value_date'] = '';
        }

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
                        $value = (string) $code;
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
        if (!isset($this->data['planned_disbursement'][$index]['provider_org'][0]['ref'])) {
            $this->data['planned_disbursement'][$index]['provider_org'][0]['ref'] = '';
        }

        if (!isset($this->data['planned_disbursement'][$index]['provider_org'][0]['provider_activity_id'])) {
            $this->data['planned_disbursement'][$index]['provider_org'][0]['provider_activity_id'] = '';
        }

        if (!isset($this->data['planned_disbursement'][$index]['provider_org'][0]['type'])) {
            $this->data['planned_disbursement'][$index]['provider_org'][0]['type'] = '';
        }

        if (!isset($this->data['planned_disbursement'][$index]['provider_org'][0]['narrative'][0]['narrative'])) {
            $this->data['planned_disbursement'][$index]['provider_org'][0]['narrative'][0] = [
                'narrative' => '',
                'language'  => '',
            ];
        }

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
                        $value = (string) $code;
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

            $this->data['planned_disbursement'][$index]['provider_org'][0]['narrative'][0] = $narrative;
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
        if (!isset($this->data['planned_disbursement'][$index]['receiver_org'][0]['ref'])) {
            $this->data['planned_disbursement'][$index]['receiver_org'][0]['ref'] = '';
        }

        if (!isset($this->data['planned_disbursement'][$index]['receiver_org'][0]['provider_activity_id'])) {
            $this->data['planned_disbursement'][$index]['receiver_org'][0]['provider_activity_id'] = '';
        }

        if (!isset($this->data['planned_disbursement'][$index]['receiver_org'][0]['type'])) {
            $this->data['planned_disbursement'][$index]['receiver_org'][0]['type'] = '';
        }

        if (!isset($this->data['planned_disbursement'][$index]['receiver_org'][0]['narrative'][0]['narrative'])) {
            $this->data['planned_disbursement'][$index]['receiver_org'][0]['narrative'][0] = [
                'narrative' => '',
                'language'  => '',
            ];
        }

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
                        $value = (string) $code;
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

            $this->data['planned_disbursement'][$index]['receiver_org'][0]['narrative'][0] = $narrative;
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
        return $this->request->getRulesForPlannedDisbursement(Arr::get($this->data, 'planned_disbursement', []));
    }

    /**
     * Provides custom messages used for IATI Element Validation.
     *
     * @return array
     */
    public function messages(): array
    {
        return $this->request->getMessagesForPlannedDisbursement(Arr::get($this->data, 'planned_disbursement', []));
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
