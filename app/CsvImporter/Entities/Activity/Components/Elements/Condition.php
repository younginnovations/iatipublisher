<?php

declare(strict_types=1);

namespace App\CsvImporter\Entities\Activity\Components\Elements;

use App\CsvImporter\Entities\Activity\Components\Elements\Foundation\Iati\Element;
use App\CsvImporter\Entities\Activity\Components\Factory\Validation;
use App\Http\Requests\Activity\Condition\ConditionRequest;
use App\IATI\Traits\DataSanitizeTrait;
use Illuminate\Support\Arr;

/**
 * Class Condition.
 */
class Condition extends Element
{
    use DataSanitizeTrait;

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
     * @var ConditionRequest
     */
    private ConditionRequest $request;

    /**
     * Condition constructor.
     *
     * @param            $fields
     * @param Validation $factory
     */
    public function __construct($fields, Validation $factory)
    {
        $this->prepare($fields);
        $this->removeEmptyCondition();
        $this->factory = $factory;
        $this->request = new ConditionRequest();
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

        $fields = is_array($fields) ? $this->sanitizeData($fields) : $fields;
    }

    /**
     * Remove empty budget items.
     *
     * @return void
     */
    public function removeEmptyCondition(): void
    {
        $conditions = Arr::get($this->data, 'conditions.condition', []);

        if (!empty($conditions)) {
            foreach ($conditions as $key => $condition) {
                $has_data = false;

                array_walk_recursive($condition, function ($item) use (&$condition, &$has_data) {
                    if ($item !== null && $item != '') {
                        $has_data = true;
                    }
                });

                if (!$has_data) {
                    unset($this->data['conditions']['condition'][$key]);
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
        if (!isset($this->data['conditions']['condition_attached'])) {
            $this->data['conditions']['condition_attached'] = '';
        }

        if ($key === $this->_csvHeaders[0]) {
            if (is_string($value)) {
                if ($value === '0' || strtolower($value) === 'false' || strtolower($value) === 'no') {
                    $value = '0';
                } elseif ($value === '1' || strtolower($value) === 'true' || strtolower($value) === 'yes') {
                    $value = '1';
                }
            } elseif (is_bool($value) || is_int($value)) {
                $value = $value ? '1' : '0';
            }

            $condition_attached = Arr::get($this->data(), 'conditions.condition_attached');

            if ($condition_attached === '') {
                $this->data['conditions']['condition_attached'] = $value;
            }
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
        if (!isset($this->data['conditions']['condition'][$index]['condition_type'])) {
            $this->data['conditions']['condition'][$index]['condition_type'] = '';
        }

        if ($key === $this->_csvHeaders[1]) {
            $value = is_null($value) ? '' : trim($value);

            $validConditionType = $this->loadCodeList('ConditionType');

            if ($value) {
                foreach ($validConditionType as $code => $name) {
                    if (strcasecmp(trim($value), $name) === 0) {
                        $value = (string) $code;
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
        if (!isset($this->data['conditions']['condition'][$index]['narrative'][0]['narrative'])) {
            $this->data['conditions']['condition'][$index]['narrative'][0] = [
                'narrative' => '',
                'language'  => '',
            ];
        }

        if ($key === $this->_csvHeaders[2]) {
            $value = $value ?: '';
            $narrative = [
                'narrative' => $value,
                'language'  => '',
            ];

            $this->data['conditions']['condition'][$index]['narrative'][0] = $narrative;
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
        $rules = $this->getBaseRules($this->request->getWarningForCondition(Arr::get($this->data, 'conditions.condition', [])), false);

        return $rules;
    }

    /**
     * Provides the rules for the IATI Element validation.
     *
     * @return array
     * @throws \JsonException
     */
    public function errorRules(): array
    {
        $rules = $this->getBaseRules($this->request->getErrorsForCondition(Arr::get($this->data, 'conditions.condition', [])), false);
        $rules['conditions.condition_attached'] = 'size:1|in:0,1';

        return $rules;
    }

    /**
     * Provides custom messages used for IATI Element Validation.
     *
     * @return array
     */
    public function messages(): array
    {
        $messages = $this->getBaseMessages($this->request->getMessagesForCondition(Arr::get($this->data, 'conditions.condition', [])), false);
        $messages['conditions.condition_attached.in'] = translateCommonError('condition_attached_value_is_invalid');

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
        $this->errorValidator = $this->factory->sign($this->data())
            ->with($this->errorRules(), $this->messages())
            ->getValidatorInstance();
        $this->setValidity();

        return $this;
    }
}
