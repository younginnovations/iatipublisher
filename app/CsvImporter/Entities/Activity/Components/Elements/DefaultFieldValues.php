<?php

namespace App\CsvImporter\Entities\Activity\Components\Elements;

use App\CsvImporter\Entities\Activity\Components\Elements\Foundation\Iati\Element;
use App\CsvImporter\Entities\Activity\Components\Factory\Validation;
use App\IATI\Traits\DataSanitizeTrait;

/**
 * Class DefaultFieldValues.
 */
class DefaultFieldValues extends Element
{
    use DataSanitizeTrait;

    /**
     * @var array
     */
    protected array $_csvHeaders = ['activity_default_currency', 'activity_default_language', 'humanitarian'];

    /**
     * @var string
     */
    protected string $index = 'default_field_values';

    /**
     * DefaultFieldValues constructor.
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
     * Prepare the IATI Element.
     *
     * @param $fields
     *
     * @return void
     */
    protected function prepare($fields): void
    {
        foreach ($fields as $key => $values) {
            if (!is_null($values) && array_key_exists($key, array_flip($this->_csvHeaders))) {
                foreach ($values as $index => $value) {
                    $this->map($key, $value, $index);
                }
            }
        }

        $fields = is_array($fields) ? $this->sanitizeData($fields) : $fields;
    }

    /**
     * Map data from CSV file into Default Field Values data format.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function map($key, $value, $index): void
    {
        if (!(is_null($value) || $value === '')) {
            $this->setDefaultCurrency($key, $value, $index);
            $this->setDefaultLanguage($key, $value, $index);
            $this->setDefaultHierarchy($index);
            $this->setHumanitarian($key, $value, $index);
            $this->setBudgetNotProvided($index);
        }
    }

    /**
     * Set linked data uri for the default field values.
     *
     * @param $index
     *
     * @return void
     */
    protected function setBudgetNotProvided($index): void
    {
        $this->data['default_field_values'][$index]['linked_data_uri'] = '';
    }

    /**
     * Set language for the default field values.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setDefaultLanguage($key, $value, $index): void
    {
        if (!isset($this->data['default_field_values'][$index]['default_language'])) {
            $this->data['default_field_values'][$index]['default_language'] = '';
        }

        if ($key === $this->_csvHeaders[1]) {
            $value = is_null($value) ? '' : trim($value);

            $validReportingOrgType = $this->loadCodeList('Language');

            if ($value) {
                foreach ($validReportingOrgType as $code => $name) {
                    if (strcasecmp($value, $name) === 0) {
                        $value = (string) $code;
                        break;
                    }
                }
            }

            $this->data['default_field_values'][$index]['default_language'] = strtolower($value);
        }
    }

    /**
     * Set currency for the default field values.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setDefaultCurrency($key, $value, $index): void
    {
        if (!isset($this->data['default_field_values'][$index]['default_currency'])) {
            $this->data['default_field_values'][$index]['default_currency'] = '';
        }

        if ($key === $this->_csvHeaders[0]) {
            $value = is_null($value) ? '' : trim($value);

            $validReportingOrgType = $this->loadCodeList('Currency');

            if ($value) {
                foreach ($validReportingOrgType as $code => $name) {
                    if (strcasecmp($value, $name) === 0) {
                        $value = (string) $code;
                        break;
                    }
                }
            }

            $this->data['default_field_values'][$index]['default_currency'] = strtoupper($value);
        }
    }

    /**
     * Set hierarchy for the default field values.
     *
     * @param $index
     *
     * @return void
     */
    protected function setDefaultHierarchy($index): void
    {
        if (!isset($this->data['default_field_values'][$index]['default_hierarchy'])) {
            $this->data['default_field_values'][$index]['default_hierarchy'] = '';
        }

        if (array_key_exists('default_currency', $this->data['default_field_values'][$index])) {
            $this->data['default_field_values'][$index]['default_hierarchy'] = '1';
        }
    }

    /**
     * Set humanitarian for the default field values.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setHumanitarian($key, $value, $index): void
    {
        if (!isset($this->data['default_field_values'][$index]['humanitarian'])) {
            $this->data['default_field_values'][$index]['humanitarian'] = '';
        }

        if ($key === $this->_csvHeaders[2]) {
            if ((strtolower($value) === 'yes') || (strtolower($value) === 'true') || $value === true) {
                $value = '1';
            } elseif ((strtolower($value) === 'no') || (strtolower($value) === 'false') || $value === false) {
                $value = '0';
            }

            $this->data['default_field_values'][$index]['humanitarian'] = $value;
        }
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
            ->with([], $this->messages())
            ->getValidatorInstance();
        $this->errorValidator = $this->factory->sign($this->data())
            ->with($this->rules(), $this->messages())
            ->getValidatorInstance();

        $this->setValidity();

        return $this;
    }

    /**
     * Provides the critical rules for the IATI Element validation.
     *
     * @return array
     * @throws \JsonException
     */
    public function rules(): array
    {
        return [
            'default_field_values' => 'size:1',
            'default_field_values.*.default_currency' => sprintf('in:%s', $this->defaultValueCodeList('Currency')),
            'default_field_values.*.default_language' => sprintf('in:%s', $this->defaultValueCodeList('Language')),
            'default_field_values.*.humanitarian' => sprintf('in:%s', '1,0'),
        ];
    }

    /**
     * Provides custom messages used for IATI Element Validation.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'default_field_values.size' => trans('validation.multiple_values', ['attribute' => trans('default_field_values')]),
            'default_field_values.*.default_currency.in' => trans('validation.code_list', ['attribute' => trans('default_currency')]),
            'default_field_values.*.default_language.in' => trans('validation.code_list', ['attribute' => trans('default_language')]),
            'default_field_values.*.humanitarian.in' => trans('validation.code_list', ['attribute' => trans('humanitarian')]),
        ];
    }

    /**
     * Return Code list of the default Field Values.
     *
     * @param $codeList
     *
     * @return string
     * @throws \JsonException
     */
    protected function defaultValueCodeList($codeList): string
    {
        return implode(',', array_keys(array_flip(array_keys($this->loadCodeList($codeList)))));
    }
}
