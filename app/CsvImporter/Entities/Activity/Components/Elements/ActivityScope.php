<?php

declare(strict_types=1);

namespace App\CsvImporter\Entities\Activity\Components\Elements;

use App\CsvImporter\Entities\Activity\Components\Elements\Foundation\Iati\Element;
use App\CsvImporter\Entities\Activity\Components\Factory\Validation;
use Illuminate\Support\Arr;

/**
 * Class ActivityScope.
 */
class ActivityScope extends Element
{
    /**
     * Csv Header for ActivityScope element.
     *
     * @var array
     */
    private array $_csvHeader = ['activity_scope'];

    /**
     * Index under which the data is stored within the object.
     *
     * @var string
     */
    protected string $index = 'activity_scope';

    /**
     * ActivityScope constructor.
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
            if (!is_null($values) && array_key_exists($key, array_flip($this->_csvHeader))) {
                foreach ($values as $value) {
                    $this->map($value, $values);
                    break;
                }
            }
        }
    }

    /**
     * Map data from CSV file into ActivitySec data format.
     *
     * @param $value
     * @param $values
     *
     * @return void
     */
    protected function map($value, $values): void
    {
        if (!(is_null($value) || $value === '')) {
            $validActivityScope = $this->loadCodeList('ActivityScope');

            if (!is_int($value)) {
                foreach ($validActivityScope as $code => $name) {
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
        $this->validator = $this->factory->sign($this->data())
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
        $rules[$this->csvHeader()] = (is_array(Arr::get($this->data, $this->csvHeader()))) ? 'size:1' : sprintf('in:%s', $this->validActivityScope());

        return $rules;
    }

    /**
     * Provides custom messages used for IATI Element Validation.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            $this->csvHeader() . '.size' => trans('validation.multiple_values', ['attribute' => trans('element.activity_scope')]),
            $this->csvHeader() . '.in'   => trans('validation.code_list', ['attribute' => trans('element.activity_scope')]),
        ];
    }

    /**
     * Get the valid ActivityScope from the ActivityScope code list as a string.
     *
     * @return string
     * @throws \JsonException
     */
    protected function validActivityScope(): string
    {
        return implode(',', array_keys(array_flip(array_keys($this->loadCodeList('ActivityScope')))));
    }

    /**
     * Get the Csv header for ActivityScope.
     *
     * @return mixed
     */
    protected function csvHeader(): mixed
    {
        return end($this->_csvHeader);
    }
}
