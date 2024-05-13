<?php

declare(strict_types=1);

namespace App\CsvImporter\Entities\Activity\Components\Elements;

use App\CsvImporter\Entities\Activity\Components\Elements\Foundation\Iati\Element;
use App\CsvImporter\Entities\Activity\Components\Factory\Validation;
use App\Http\Requests\Activity\HumanitarianScope\HumanitarianScopeRequest;
use App\IATI\Traits\DataSanitizeTrait;
use Illuminate\Support\Arr;

/**
 * Class HumanitarianScope.
 */
class HumanitarianScope extends Element
{
    use DataSanitizeTrait;

    /**
     * Csv Header for HumanitarianScope element.
     * @var array
     */
    private array $_csvHeaders
        = [
            'humanitarian_scope_type',
            'humanitarian_scope_vocabulary',
            'humanitarian_scope_vocabulary_uri',
            'humanitarian_scope_code',
            'humanitarian_scope_narrative',
        ];

    /**
     * Index under which the data is stored within the object.
     *
     * @var string
     */
    protected string $index = 'humanitarian_scope';

    /**
     * @var HumanitarianScopeRequest
     */
    private HumanitarianScopeRequest $request;

    /**
     * HumanitarianScope constructor.
     *
     * @param            $fields
     * @param Validation $factory
     */
    public function __construct($fields, Validation $factory)
    {
        $this->prepare($fields);
        $this->factory = $factory;
        $this->request = new HumanitarianScopeRequest();
    }

    /**
     * Prepare HumanitarianScope element.
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
     * Map data from CSV file into HumanitarianScope data format.
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
            $this->setHumanitarianScopeType($key, $value, $index);
            $this->setHumanitarianScopeVocabulary($key, $value, $index);
            $this->setVocabularyUri($key, $value, $index);
            $this->setHumanitarianScopeCode($key, $value, $index);
            $this->setHumanitarianScopeNarrative($key, $value, $index);
        }
    }

    /**
     * Maps HumanitarianScope Type.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setHumanitarianScopeType($key, $value, $index): void
    {
        if (!isset($this->data['humanitarian_scope'][$index]['type'])) {
            $this->data['humanitarian_scope'][$index]['type'] = '';
        }

        if ($key === $this->_csvHeaders[0]) {
            $value = is_null($value) ? '' : trim($value);

            $validHumanitarianScopeVocab = $this->loadCodeList('HumanitarianScopeType');

            if ($value) {
                foreach ($validHumanitarianScopeVocab as $code => $name) {
                    if (strcasecmp($value, $name) === 0) {
                        $value = (string) $code;
                        break;
                    }
                }
            }

            $this->data['humanitarian_scope'][$index]['type'] = $value;
        }
    }

    /**
     * Maps HumanitarianScope Vocabulary.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setHumanitarianScopeVocabulary($key, $value, $index): void
    {
        if (!isset($this->data['humanitarian_scope'][$index]['vocabulary'])) {
            $this->data['humanitarian_scope'][$index]['vocabulary'] = '';
        }

        if ($key === $this->_csvHeaders[1]) {
            $value = is_null($value) ? '' : trim($value);

            $validHumanitarianScopeVocab = $this->loadCodeList('HumanitarianScopeVocabulary');

            if ($value) {
                foreach ($validHumanitarianScopeVocab as $code => $name) {
                    if (strcasecmp($value, $name) === 0) {
                        $value = is_int($code) ? (int) $code : $code;
                        break;
                    }
                }
            }

            $this->data['humanitarian_scope'][$index]['vocabulary'] = $value;
        }
    }

    /**
     * Set vocabulary uri for HumanitarianScope.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setVocabularyUri($key, $value, $index): void
    {
        if ($key === $this->_csvHeaders[2] && Arr::get($this->data(), 'humanitarian_scope.' . $index . '.vocabulary') === '99') {
            $this->data['humanitarian_scope'][$index]['vocabulary_uri'] = $value;
        }
    }

    /**
     * Maps HumanitarianScope Code.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setHumanitarianScopeCode($key, $value, $index): void
    {
        if (!isset($this->data['humanitarian_scope'][$index]['code'])) {
            $this->data['humanitarian_scope'][$index]['code'] = '';
        }

        if ($key === $this->_csvHeaders[3]) {
            $value = is_null($value) ? '' : trim($value);
            $this->data['humanitarian_scope'][$index]['code'] = $value;
        }
    }

    /**
     * Set narrative for HumanitarianScope.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setHumanitarianScopeNarrative($key, $value, $index): void
    {
        if (!isset($this->data['humanitarian_scope'][$index]['narrative'][0]['narrative'])) {
            $this->data['humanitarian_scope'][$index]['narrative'][0] = [
                'narrative' => '',
                'language'  => '',
            ];
        }

        if ($key === $this->_csvHeaders[4]) {
            $value = $value ?: '';
            $narrative = [
                'narrative' => $value,
                'language'  => '',
            ];

            $this->data['humanitarian_scope'][$index]['narrative'][0] = $narrative;
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
        return $this->request->getWarningForHumanitarianScope(Arr::get($this->data(), 'humanitarian_scope', []));
    }

    /**
     * Provides the rules for the IATI Element validation.
     *
     * @return array
     * @throws \JsonException
     */
    public function errorRules(): array
    {
        return $this->request->getErrorsForHumanitarianScope(Arr::get($this->data(), 'humanitarian_scope', []));
    }

    /**
     * Provides custom messages used for IATI Element Validation.
     *
     * @return array
     */
    public function messages(): array
    {
        return $this->request->getMessagesForHumanitarianScope(Arr::get($this->data(), 'humanitarian_scope', []));
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
