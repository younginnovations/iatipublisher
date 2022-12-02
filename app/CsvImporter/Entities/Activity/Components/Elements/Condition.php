<?php

declare(strict_types=1);

namespace App\CsvImporter\Entities\Activity\Components\Elements;

use App\CsvImporter\Entities\Activity\Components\Elements\Foundation\Iati\Element;
use App\CsvImporter\Entities\Activity\Components\Factory\Validation;
use App\Http\Requests\Activity\Condition\ConditionRequest;
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
            if (is_int($value) || is_bool($value)) {
                $value = (int) $value;
            } elseif (is_string($value)) {
                if ($value === '0' || strcasecmp($value, 'false') === 0 || strcasecmp($value, 'no') === 0) {
                    $value = '0';
                } elseif ($value === '1' || strcasecmp($value, 'true') === 0 || strcasecmp($value, 'yes') === 0) {
                    $value = '1';
                }
            }

            $this->data['conditions']['condition_attached'] = Arr::get($this->data(), 'conditions.condition_attached', $value);
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
            $value = (!$value) ? '' : trim($value);

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
        $rules = $this->getBaseRules($this->request->getRulesForCondition(Arr::get($this->data, 'conditions.condition', [])), false);
        $rules['conditions.condition_attached'] = 'in:0,1';

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
        $messages['conditions.condition_attached.in'] = 'The condition attached value is invalid.';

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
