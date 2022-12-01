<?php

declare(strict_types=1);

namespace App\CsvImporter\Entities\Activity\Components\Elements;

use App\CsvImporter\Entities\Activity\Components\Elements\Foundation\Iati\Element;
use App\CsvImporter\Entities\Activity\Components\Factory\Validation;
use App\Http\Requests\Activity\CapitalSpend\CapitalSpendRequest;
use Illuminate\Support\Arr;

/**
 * Class CapitalSpend.
 */
class CapitalSpend extends Element
{
    /**
     * CSV Header of Description with their code.
     */
    private array $_csvHeader = ['capital_spend'];

    /**
     * Index under which the data is stored within the object.
     *
     * @var string
     */
    protected string $index = 'capital_spend';

    /**
     * @var array
     */
    protected array $data;
    private CapitalSpendRequest $request;

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
        $this->request = new CapitalSpendRequest();
    }

    /**
     * Prepare the CapitalSpend element.
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
     * Map data from CSV into CapitalSpend data format.
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
//            $this->csvHeader() => 'nullable|numeric|between:0, 100',
//        ];
//
//        (!is_array(Arr::get($this->data, 'capital_spend'))) ?: $rules[$this->csvHeader()] .= 'nullable|size:1';
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
//            sprintf('%s.numeric', $key)  => trans('validation.numeric', ['attribute' => trans('element.capital_spend')]),
//            sprintf('%s.between', $key)  => trans('validation.between.numeric', ['attribute' => trans('element.capital_spend'), 'min' => '0', 'max' => '100']),
//            sprintf('%s.size', $key)     => trans('validation.multiple_values', ['attribute' => trans('element.capital_spend')]),
//        ];
    }

    /**
     * Get the Csv header for CapitalSpend.
     *
     * @return mixed
     */
    protected function csvHeader(): mixed
    {
        return end($this->_csvHeader);
    }
}
