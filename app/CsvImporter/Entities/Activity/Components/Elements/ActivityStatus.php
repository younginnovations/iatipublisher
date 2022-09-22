<?php

declare(strict_types=1);

namespace App\CsvImporter\Entities\Activity\Components\Elements;

use App\CsvImporter\Entities\Activity\Components\Elements\Foundation\Iati\Element;
use App\CsvImporter\Entities\Activity\Components\Factory\Validation;
use Illuminate\Support\Arr;

/**
 * Class ActivityStatus.
 */
class ActivityStatus extends Element
{
    /**
     * CSV Header of Description with their code.
     */
    private array $_csvHeader = ['activity_status'];

    /**
     * Index under which the data is stored within the object.
     *
     * @var string
     */
    protected string $index = 'activity_status';

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
     * Prepare the ActivityStatus element.
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
                }
            }
        }
    }

    /**
     * Map data from CSV into ActivityStatus data format.
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
            $validActivityStatus = $this->loadCodeList('ActivityStatus');

            foreach ($validActivityStatus as $key => $status) {
                if ($value === $status) {
                    $value = $key;
                    break;
                }
            }
            (count(array_filter($values)) === 1) ? $this->data[$this->csvHeader()] = $value : $this->data[$this->csvHeader()][] = $value;
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
        $rules = [
            $this->csvHeader() => sprintf('nullable|in:%s', $this->validActivityStatus()),
        ];

        (!is_array(Arr::get($this->data, 'activity_status'))) ?: $rules[$this->csvHeader()] .= '|size:1';

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
            sprintf('%s.required', $key) => trans('validation.required', ['attribute' => trans('element.activity_status')]),
            sprintf('%s.size', $key)     => trans('validation.multiple_values', ['attribute' => trans('element.activity_status')]),
            sprintf('%s.in', $key)       => trans('validation.code_list', ['attribute' => trans('element.activity_status')]),
        ];
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
     * Get the Csv header for ActivityStatus.
     *
     * @return mixed
     */
    protected function csvHeader(): mixed
    {
        return end($this->_csvHeader);
    }

    /**
     * Get the valid ActivityStatus from the ActivityStatus codelist as a string.
     *
     * @return string
     * @throws \JsonException
     */
    protected function validActivityStatus(): string
    {
        return implode(',', array_keys(array_flip(array_keys($this->loadCodeList('ActivityStatus')))));
    }
}
