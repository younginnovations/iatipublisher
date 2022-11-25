<?php

declare(strict_types=1);

namespace App\CsvImporter\Entities\Activity\Components\Elements;

use App\CsvImporter\Entities\Activity\Components\Elements\Foundation\Iati\Element;
use App\CsvImporter\Entities\Activity\Components\Factory\Validation;
use Illuminate\Support\Arr;

/**
 * Class DefaultFlowType.
 */
class DefaultFlowType extends Element
{
    /**
     * CSV Header of Description with their code.
     */
    private array $_csvHeader = ['default_flow_type'];

    /**
     * Index under which the data is stored within the object.
     *
     * @var string
     */
    protected string $index = 'default_flow_type';

    /**
     * @var array
     */
    protected array $data;

    /**
     * Description constructor.
     *
     * @param            $fields
     * @param Validation $factory
     *
     * @throws \JsonException
     */
    public function __construct($fields, Validation $factory)
    {
        $this->prepare($fields);
        $this->factory = $factory;
    }

    /**
     * Prepare the DefaultFlowType element.
     *
     * @param $fields
     *
     * @return void
     * @throws \JsonException
     */
    public function prepare($fields): void
    {
        foreach ($fields as $key => $values) {
            if (!is_null($values) && array_key_exists($key, array_flip($this->_csvHeader))) {
                foreach ($values as $value) {
                    $this->map($value, $values);
                    break;
                }
            }
        }
    }

    /**
     * Map data from CSV into DefaultFlowType data format.
     *
     * @param $value
     * @param $values
     *
     * @return void
     * @throws \JsonException
     */
    public function map($value, $values): void
    {
        if (!(is_null($value) || $value === '')) {
            $validDefaultFlowType = $this->loadCodeList('FlowType');

            if (!is_int($value)) {
                foreach ($validDefaultFlowType as $code => $name) {
                    if (strcasecmp(trim($value), $name) === 0) {
                        $value = is_int($code) ? (int) $code : $code;
                        break;
                    }
                }
            }

            (count(array_filter($values)) === 1) ? $this->data[$this->csvHeader()] = trim($value) : $this->data[$this->csvHeader()][] = trim($value);
        } else {
            $this->data[$this->csvHeader()] = '';
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
        $this->validator = $this->factory->sign($this->data)
                                         ->with($this->rules(), $this->messages())
                                         ->getValidatorInstance();

        $this->setValidity();

        return $this;
    }

    /**
     * Provides the rules for the IATI Element validation.
     *
     * @return array
     * @throws \JsonException
     */
    public function rules(): array
    {
        $rules = [
            $this->csvHeader() => sprintf('nullable|in:%s', $this->validDefaultFlowType()),
        ];

        (!is_array(Arr::get($this->data, 'default_flow_type'))) ?: $rules[$this->csvHeader()] .= 'nullable|size:1';

        return $rules;
    }

    /**
     * Provides custom messages used for IATI Element Validation.
     *
     * @return array
     */
    public function messages(): array
    {
        $key = $this->csvHeader();

        return [
            sprintf('%s.size', $key)     => trans('validation.multiple_values', ['attribute' => trans('element.default_flow_type')]),
            sprintf('%s.in', $key)       => trans('validation.code_list', ['attribute' => trans('element.default_flow_type')]),
        ];
    }

    /**
     * Get the Csv header for DefaultFlowType.
     *
     * @return mixed
     */
    protected function csvHeader(): mixed
    {
        return end($this->_csvHeader);
    }

    /**
     * Get the valid DefaultFlowType from the DefaultFlowType codelist as a string.
     *
     * @return string
     * @throws \JsonException
     */
    protected function validDefaultFlowType(): string
    {
        return implode(',', array_keys(array_flip(array_keys($this->loadCodeList('FlowType')))));
    }
}
