<?php

declare(strict_types=1);

namespace App\CsvImporter\Entities\Activity\Components\Elements;

use App\CsvImporter\Entities\Activity\Components\Elements\Foundation\Iati\Element;
use App\CsvImporter\Entities\Activity\Components\Factory\Validation;
use App\Http\Requests\Activity\DefaultFlowType\DefaultFlowTypeRequest;
use App\IATI\Traits\DataSanitizeTrait;
use Illuminate\Support\Arr;

/**
 * Class DefaultFlowType.
 */
class DefaultFlowType extends Element
{
    use DataSanitizeTrait;

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
     * @var DefaultFlowTypeRequest
     */
    private DefaultFlowTypeRequest $request;

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
        $this->request = new DefaultFlowTypeRequest();
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
                $this->data[$this->csvHeader()] = [];

                foreach ($values as $value) {
                    $this->map($value, $values);
                }

                if (is_array($this->data[$this->csvHeader()]) && empty($this->data[$this->csvHeader()])) {
                    $this->data[$this->csvHeader()] = '';
                }
            }
        }

        $fields = is_array($fields) ? $this->sanitizeData($fields) : $fields;
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

            ($this->countArrayElements($values) === 1) ? $this->data[$this->csvHeader()] = $value : $this->data[$this->csvHeader()][] = $value;
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
        $this->errorValidator = $this->factory->sign($this->data)
            ->with($this->errorRules(), $this->messages())
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
        return $this->request->getWarningForDefaultFlowType();
    }

    /**
     * Provides the rules for the IATI Element validation.
     *
     * @return array
     * @throws \JsonException
     */
    public function errorRules(): array
    {
        return $this->request->getErrorsForDefaultFlowType(Arr::get($this->data(), $this->csvHeader()));
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
     * Get the Csv header for DefaultFlowType.
     *
     * @return mixed
     */
    protected function csvHeader(): mixed
    {
        return end($this->_csvHeader);
    }
}
