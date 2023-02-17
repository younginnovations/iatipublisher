<?php

declare(strict_types=1);

namespace App\CsvImporter\Entities\Activity\Components\Elements;

use App\CsvImporter\Entities\Activity\Components\Elements\Foundation\Iati\Element;
use App\CsvImporter\Entities\Activity\Components\Factory\Validation;
use App\Http\Requests\Activity\LegacyData\LegacyDataRequest;
use App\IATI\Traits\DataSanitizeTrait;
use Illuminate\Support\Arr;

/**
 * Class LegacyData.
 */
class LegacyData extends Element
{
    use DataSanitizeTrait;

    /**
     * Csv Header for LegacyData element.
     * @var array
     */
    private array $_csvHeaders
        = [
            'legacy_data_name',
            'legacy_data_value',
            'legacy_data_iati_equivalent',
        ];

    /**
     * Index under which the data is stored within the object.
     *
     * @var string
     */
    protected string $index = 'legacy_data';

    /**
     * @var LegacyDataRequest
     */
    private LegacyDataRequest $request;

    /**
     * LegacyData constructor.
     *
     * @param            $fields
     * @param Validation $factory
     */
    public function __construct($fields, Validation $factory)
    {
        $this->prepare($fields);
        $this->factory = $factory;
        $this->request = new LegacyDataRequest();
    }

    /**
     * Prepare LegacyData element.
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

        $fields = is_array($fields) ? $this->sanitizeData($fields) : $fields;
    }

    /**
     * Map data from CSV file into LegacyData data format.
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
            $this->setLegacyDataName($key, $value, $index);
            $this->setLegacyDataValue($key, $value, $index);
            $this->setLegacyDataIatiEquivalent($key, $value, $index);
        }
    }

    /**
     * Set name for LegacyData.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setLegacyDataName($key, $value, $index): void
    {
        if (!isset($this->data['legacy_data'][$index]['legacy_name'])) {
            $this->data['legacy_data'][$index]['legacy_name'] = '';
        }

        if ($key === $this->_csvHeaders[0]) {
            $this->data['legacy_data'][$index]['legacy_name'] = $value;
        }
    }

    /**
     * Set value for LegacyData.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setLegacyDataValue($key, $value, $index): void
    {
        if (!isset($this->data['legacy_data'][$index]['value'])) {
            $this->data['legacy_data'][$index]['value'] = '';
        }

        if ($key === $this->_csvHeaders[1]) {
            $this->data['legacy_data'][$index]['value'] = $value;
        }
    }

    /**
     * Set iati equivalent for LegacyData.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setLegacyDataIatiEquivalent($key, $value, $index): void
    {
        if (!isset($this->data['legacy_data'][$index]['iati_equivalent'])) {
            $this->data['legacy_data'][$index]['iati_equivalent'] = '';
        }

        if ($key === $this->_csvHeaders[2]) {
            $this->data['legacy_data'][$index]['iati_equivalent'] = $value;
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
        return $this->request->getWarningForActivityLegacyData(Arr::get($this->data(), 'legacy_data', []));
    }

    /**
     * Provides the critical rules for the IATI Element validation.
     *
     * @return array
     * @throws \JsonException
     */
    public function errorRules(): array
    {
        return $this->request->getErrorsForLegacyData(Arr::get($this->data(), 'legacy_data', []));
    }

    /**
     * Provides custom messages used for IATI Element Validation.
     *
     * @return array
     */
    public function messages(): array
    {
        return $this->request->getMessagesForActivityLegacyData(Arr::get($this->data(), 'legacy_data', []));
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
        $this->errorValidator = $this->factory->sign($this->data())
                                         ->with($this->errorRules(), $this->messages())
                                         ->getValidatorInstance();
        $this->setValidity();

        return $this;
    }
}
