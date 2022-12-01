<?php

declare(strict_types=1);

namespace App\CsvImporter\Entities\Activity\Components\Elements;

use App\CsvImporter\Entities\Activity\Components\Elements\Foundation\Iati\Element;
use App\CsvImporter\Entities\Activity\Components\Factory\Validation;
use App\Http\Requests\Activity\DefaultFinanceType\DefaultFinanceTypeRequest;
use Illuminate\Support\Arr;

/**
 * Class DefaultFinanceType.
 */
class DefaultFinanceType extends Element
{
    /**
     * CSV Header of Description with their code.
     */
    private array $_csvHeader = ['default_finance_type'];

    /**
     * Index under which the data is stored within the object.
     *
     * @var string
     */
    protected string $index = 'default_finance_type';

    /**
     * @var array
     */
    protected array $data;
    private DefaultFinanceTypeRequest $request;

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
        $this->request = new DefaultFinanceTypeRequest();
    }

    /**
     * Prepare the DefaultFinanceType element.
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
                $this->data[$this->csvHeader()] = '';

                foreach ($values as $value) {
                    $this->map($value, $values);
                }
            }
        }
    }

    /**
     * Map data from CSV into DefaultFinanceType data format.
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
            $validDefaultFinanceType = $this->loadCodeList('FinanceType');

            if (!is_int($value)) {
                foreach ($validDefaultFinanceType as $code => $name) {
                    if (strcasecmp(trim($value), $name) === 0) {
                        $value = is_int($code) ? (int) $code : $code;
                        break;
                    }
                }
            }

            (count(array_filter($values)) === 1) ? $this->data[$this->csvHeader()] = $value : $this->data[$this->csvHeader()][] = $value;
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
        return $this->request->rules(Arr::get($this->data(), $this->csvHeader()));
    }

    /**
     * Provides custom messages used for IATI Element Validation.
     *
     * @return array
     */
    public function messages(): array
    {
        return $this->request->messages();
    }

    /**
     * Get the Csv header for DefaultFinanceType.
     *
     * @return mixed
     */
    protected function csvHeader(): mixed
    {
        return end($this->_csvHeader);
    }
}
