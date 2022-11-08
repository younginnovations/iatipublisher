<?php

declare(strict_types=1);

namespace App\CsvImporter\Entities\Activity\Components\Elements;

use App\CsvImporter\Entities\Activity\Components\Elements\Foundation\Iati\Element;
use App\CsvImporter\Entities\Activity\Components\Factory\Validation;
use Illuminate\Support\Arr;

/**
 * Class HumanitarianScope.
 */
class HumanitarianScope extends Element
{
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
     * HumanitarianScope constructor.
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
        if ($key === $this->_csvHeaders[0]) {
            $value = (!$value) ? '' : $value;

            $validHumanitarianScopeVocab = $this->loadCodeList('HumanitarianScopeType');

            if (!is_int($value)) {
                foreach ($validHumanitarianScopeVocab as $code => $name) {
                    if (strcasecmp(trim($value), $name) === 0) {
                        $value = $code;
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
        if ($key === $this->_csvHeaders[1]) {
            $value = (!$value) ? '' : $value;

            $validHumanitarianScopeVocab = $this->loadCodeList('HumanitarianScopeVocabulary');

            if (!is_int($value)) {
                foreach ($validHumanitarianScopeVocab as $code => $name) {
                    if (strcasecmp(trim($value), $name) === 0) {
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
        if ($key === $this->_csvHeaders[2]) {
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
        if ($key === $this->_csvHeaders[3]) {
            $value = (!$value) ? '' : $value;
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
        if ($key === $this->_csvHeaders[4]) {
            $value = $value ?: '';
            $narrative = [
                'narrative' => $value,
                'language'  => '',
            ];

            $this->data['humanitarian_scope'][$index]['narrative'][] = $narrative;
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
        $validHumanitarianScopeVocabulary = implode(',', $this->validHumanitarianScopeCodeList('HumanitarianScopeVocabulary'));
        $validHumanitarianScopeType = implode(',', $this->validHumanitarianScopeCodeList('HumanitarianScopeType'));

        $rules = [];

        foreach (Arr::get($this->data(), 'humanitarian_scope', []) as $key => $value) {
            $humanitarianScopeForm = sprintf('humanitarian_scope.%s', $key);
            $rules[sprintf('%s.type', $humanitarianScopeForm)] = sprintf(
                'in:%s|required_with: %s,%s,%s,%s',
                $validHumanitarianScopeType,
                sprintf('%s.vocabulary', $humanitarianScopeForm),
                sprintf('%s.vocabulary_uri', $humanitarianScopeForm),
                sprintf('%s.code', $humanitarianScopeForm),
                sprintf('%s.narrative.0.narrative', $humanitarianScopeForm),
            );

            $rules[sprintf('%s.vocabulary', $humanitarianScopeForm)] = sprintf(
                'in:%s|required_with: %s,%s,%s,%s',
                $validHumanitarianScopeVocabulary,
                sprintf('%s.type', $humanitarianScopeForm),
                sprintf('%s.vocabulary_uri', $humanitarianScopeForm),
                sprintf('%s.code', $humanitarianScopeForm),
                sprintf('%s.narrative.0.narrative', $humanitarianScopeForm),
            );

            $rules[sprintf('%s.code', $humanitarianScopeForm)] = sprintf(
                'required_with: %s,%s,%s,%s',
                sprintf('%s.type', $humanitarianScopeForm),
                sprintf('%s.vocabulary', $humanitarianScopeForm),
                sprintf('%s.vocabulary_uri', $humanitarianScopeForm),
                sprintf('%s.narrative.0.narrative', $humanitarianScopeForm),
            );
            $vocabulary = Arr::get($value, 'vocabulary');

            if ($vocabulary) {
                $rules[sprintf('%s.vocabulary_uri', $humanitarianScopeForm)] = 'nullable|url';

                if ($vocabulary === '99') {
                    $rules[sprintf('%s.vocabulary_uri', $humanitarianScopeForm)] = sprintf(
                        'required_with: %s,%s,%s,%s',
                        sprintf('%s.type', $humanitarianScopeForm),
                        sprintf('%s.vocabulary', $humanitarianScopeForm),
                        sprintf('%s.code', $humanitarianScopeForm),
                        sprintf('%s.narrative.0.narrative', $humanitarianScopeForm),
                    );
                }
            }
        }

        return $rules;
    }

    /**
     * Return Valid HumanitarianScope Type.
     *
     * @param $name
     *
     * @return array
     * @throws \JsonException
     */
    protected function validHumanitarianScopeCodeList($name): array
    {
        return array_keys($this->loadCodeList($name));
    }

    /**
     * Provides custom messages used for IATI Element Validation.
     *
     * @return array
     */
    public function messages(): array
    {
        $messages = [];

        foreach (Arr::get($this->data(), 'humanitarian_scope', []) as $key => $value) {
            $humanitarianScopeForm = sprintf('humanitarian_scope.%s', $key);
            $messages[sprintf('%s.type.%s', $humanitarianScopeForm, 'in')] = trans(
                'validation.code_list',
                ['attribute' => trans('elementForm.humanitarian_scope_type')]
            );
            $messages[sprintf('%s.type.%s', $humanitarianScopeForm, 'required_with')] = trans(
                'validation.required_with',
                ['attribute' => trans('elementForm.humanitarian_scope_type'), 'values' => 'vocabulary, code, uri or narrative']
            );
            $messages[sprintf('%s.vocabulary.%s', $humanitarianScopeForm, 'in')] = trans(
                'validation.code_list',
                ['attribute' => trans('elementForm.humanitarian_scope_vocabulary')]
            );
            $messages[sprintf('%s.vocabulary.%s', $humanitarianScopeForm, 'required_with')] = trans(
                'validation.required_with',
                ['attribute' => trans('elementForm.humanitarian_scope_vocabulary'), 'values' => 'vocabulary, code, uri or narrative']
            );
            $messages[sprintf('%s.code.%s', $humanitarianScopeForm, 'required_with')] = trans(
                'validation.required_with',
                ['attribute' => trans('elementForm.humanitarian_scope_code'), 'values' => 'vocabulary, code, uri or narrative']
            );
            $vocabulary = Arr::get($value, 'vocabulary');

            if ($vocabulary) {
                $messages[sprintf('%s.vocabulary_uri.%s', $humanitarianScopeForm, 'url')] = trans(
                    'validation.active_url',
                    ['attribute' => trans('elementForm.humanitarian_scope_vocabulary_url')]
                );

                $messages[sprintf('%s.vocabulary_uri.%s', $humanitarianScopeForm, 'required_with')] = trans(
                    'validation.required_with',
                    ['attribute' => trans('elementForm.humanitarian_scope_vocabulary_uri'), 'values' => 'vocabulary, type, code or narrative']
                );
            }
        }

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
