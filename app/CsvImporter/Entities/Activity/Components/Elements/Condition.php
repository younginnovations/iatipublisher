<?php

declare(strict_types=1);

namespace App\CsvImporter\Entities\Activity\Components\Elements;

use App\CsvImporter\Entities\Activity\Components\Elements\Foundation\Iati\Element;
use App\CsvImporter\Entities\Activity\Components\Factory\Validation;
use Illuminate\Support\Arr;

/**
 * Class Condition.
 */
class Condition extends Element
{
    /**
     * Csv Header for Condition element.
     * @var array
     */
    private array $_csvHeaders
    = [
        'conditions_attached',
        'condition_type',
        'condition_narrative',
    ];

    /**
     * Index under which the data is stored within the object.
     *
     * @var string
     */
    protected string $index = 'conditions';

    /**
     * Condition constructor.
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
     * Prepare Condition element.
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
     * Map data from CSV file into Condition data format.
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
            $this->setConditionAttached($key, $value);
            $this->setConditionType($key, $value, $index);
            $this->setConditionNarrative($key, $value, $index);
        }
    }

    /**
     * Maps Condition Attached.
     *
     * @param $key
     * @param $value
     *
     * @return void
     */
    protected function setConditionAttached($key, $value): void
    {
        if ($key === $this->_csvHeaders[0]) {
            if (is_int($value) || is_bool($value)) {
                $value = (int) $value;
            } elseif (is_string($value)) {
                if ($value === '0' || strcasecmp($value, 'false') === 0 || strcasecmp($value, 'no') === 0) {
                    $value = '0';
                } elseif ($value === '1' || strcasecmp($value, 'true') === 0 || strcasecmp($value, 'yes') === 0) {
                    $value = '1';
                }
            }

            $this->data['conditions']['condition_attached'] = $value;
        }
    }

    /**
     * Maps Condition Type.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setConditionType($key, $value, $index): void
    {
        if ($key === $this->_csvHeaders[1]) {
            $value = (!$value) ? '' : $value;

            $validConditionType = $this->loadCodeList('ConditionType');

            if ($value) {
                foreach ($validConditionType as $code => $name) {
                    if (strcasecmp(trim($value), $name) === 0) {
                        $value = strval($code);
                        break;
                    }
                }
            }

            $this->data['conditions']['condition'][$index]['condition_type'] = $value;
        }
    }

    /**
     * Set narrative for Condition.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setConditionNarrative($key, $value, $index): void
    {
        if ($key === $this->_csvHeaders[2]) {
            $value = $value ?: '';
            $narrative = [
                'narrative' => $value,
                'language'  => '',
            ];

            $this->data['conditions']['condition'][$index]['narrative'][] = $narrative;
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
        $validConditionType = implode(',', $this->validConditionCodeList('ConditionType'));

        $rules = [];

        $rules['conditions.condition_attached'][] = 'in:0,1';

        if (count(Arr::get($this->data, 'conditions.condition', []))) {
            foreach (Arr::get($this->data, 'conditions.condition', []) as $key => $conditionItem) {
                $rules['conditions.condition_attached'][] = sprintf(
                    'required_with: %s,%s',
                    'conditions.condition.' . $key . '.condition_type',
                    'conditions.condition.' . $key . '.narrative.0.narrative',
                );

                $rules['conditions.condition.' . $key . '.condition_type'] = sprintf(
                    'in:%s|required_with: %s,%s',
                    $validConditionType,
                    'conditions.condition_attached',
                    'conditions.condition.' . $key . '.narrative.0.narrative',
                );

                $rules['conditions.condition.' . $key . '.narrative.0.narrative'] = sprintf(
                    'required_with: %s,%s',
                    'conditions.condition_attached',
                    'conditions.condition.' . $key . '.condition_type',
                );
            }
        }

        return $rules;
    }

    /**
     * Return Valid Condition Type.
     *
     * @param $name
     *
     * @return array
     * @throws \JsonException
     */
    protected function validConditionCodeList($name): array
    {
        return array_keys($this->loadCodeList($name));
    }

    /**
     * Provides custom messages used for IATI Element Validation.
     *
     * @return array
     */
    public function messages(): array
    {
        $messages = [];

        $messages['conditions.condition_attached.in'] = trans(
            'validation.code_list',
            ['attribute' => trans('elementForm.condition_attached')]
        );

        if (count(Arr::get($this->data, 'conditions.condition', []))) {
            foreach (Arr::get($this->data(), 'conditions.condition', []) as $key => $conditionItem) {
                $messages['conditions.condition_attached.required_with'] = trans(
                    'validation.required_with',
                    [
                        'attribute' => trans('elementForm.condition_attached'),
                        'values'    => 'condition type or narrative',
                    ]
                );

                $messages['conditions.condition.' . $key . '.condition_type.in'] = trans(
                    'validation.code_list',
                    ['attribute' => trans('elementForm.condition_type')]
                );

                $messages['conditions.condition.' . $key . '.condition_type.required_with'] = trans(
                    'validation.required_with',
                    [
                        'attribute' => trans('elementForm.condition_type'),
                        'values'    => 'condition attached or narrative',
                    ]
                );

                $messages['conditions.condition.' . $key . '.narrative.0.narrative.required_with'] = trans(
                    'validation.required_with',
                    [
                        'attribute' => trans('elementForm.condition_narrative'),
                        'values'    => 'condition attached or type',
                    ]
                );
            }
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
