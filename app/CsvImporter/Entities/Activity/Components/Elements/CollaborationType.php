<?php

declare(strict_types=1);

namespace App\CsvImporter\Entities\Activity\Components\Elements;

use App\CsvImporter\Entities\Activity\Components\Elements\Foundation\Iati\Element;
use App\CsvImporter\Entities\Activity\Components\Factory\Validation;
use App\Http\Requests\Activity\CollaborationType\CollaborationTypeRequest;
use Illuminate\Support\Arr;

/**
 * Class CollaborationType.
 */
class CollaborationType extends Element
{
    /**
     * CSV Header of Description with their code.
     */
    private array $_csvHeader = ['collaboration_type'];

    /**
     * Index under which the data is stored within the object.
     *
     * @var string
     */
    protected string $index = 'collaboration_type';

    /**
     * @var array
     */
    protected array $data;

    /**
     * @var CollaborationTypeRequest
     */
    private CollaborationTypeRequest $request;

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
        $this->request = new CollaborationTypeRequest();
    }

    /**
     * Prepare the CollaborationType element.
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
     * Map data from CSV into CollaborationType data format.
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
            $validCollaborationType = $this->loadCodeList('CollaborationType');

            if (!is_int($value)) {
                foreach ($validCollaborationType as $code => $name) {
                    if (strcasecmp(trim($value), $name) === 0) {
                        $value = is_int($code) ? (int) $code : $code;
                        break;
                    }
                }
            }

            (count(array_filter($values)) === 1) ? $this->data[$this->csvHeader()] = $value : $this->data[$this->csvHeader()][] = $value;
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
        return [];

//        $rules = [
//            $this->csvHeader() => sprintf('nullable|in:%s', $this->validCollaborationType()),
//        ];
//
//        (!is_array(Arr::get($this->data, 'collaboration_type'))) ?: $rules[$this->csvHeader()] .= 'nullable|size:1';
//
//        return $rules;
    }

    /**
     * Provides custom messages used for IATI Element Validation.
     *
     * @return array
     */
    public function messages(): array
    {
        return [];

//        $key = $this->csvHeader();
//
//        return [
//            sprintf('%s.size', $key)     => trans('validation.multiple_values', ['attribute' => trans('element.collaboration_type')]),
//            sprintf('%s.in', $key)       => trans('validation.code_list', ['attribute' => trans('element.collaboration_type')]),
//        ];
    }

    /**
     * Get the Csv header for CollaborationType.
     *
     * @return mixed
     */
    protected function csvHeader(): mixed
    {
        return end($this->_csvHeader);
    }

    /**
     * Get the valid CollaborationType from the CollaborationType codelist as a string.
     *
     * @return string
     * @throws \JsonException
     */
    protected function validCollaborationType(): string
    {
        return implode(',', array_keys(array_flip(array_keys($this->loadCodeList('CollaborationType')))));
    }
}
