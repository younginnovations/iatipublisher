<?php

declare(strict_types=1);

namespace App\CsvImporter\Entities\Activity\Components\Elements;

use App\CsvImporter\Entities\Activity\Components\Elements\Foundation\Iati\Element;
use App\CsvImporter\Entities\Activity\Components\Factory\Validation;
use App\Http\Requests\Activity\Tag\TagRequest;
use App\IATI\Traits\DataSanitizeTrait;
use Illuminate\Support\Arr;

/**
 * Class Tag.
 */
class Tag extends Element
{
    use DataSanitizeTrait;

    /**
     * Csv Header for Tag element.
     * @var array
     */
    private array $_csvHeaders = [
        'tag_vocabulary',
        'tag_code',
        'tag_vocabulary_uri',
        'tag_narrative',
    ];

    /**
     * Index under which the data is stored within the object.
     *
     * @var string
     */
    protected string $index = 'tag';

    /**
     * @var TagRequest
     */
    private TagRequest $request;

    /**
     * Tag constructor.
     *
     * @param            $fields
     * @param Validation $factory
     */
    public function __construct($fields, Validation $factory)
    {
        $this->prepare($fields);
        $this->factory = $factory;
        $this->request = new TagRequest();
    }

    /**
     * Prepare Tag element.
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
     * Map data from CSV file into Tag data format.
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
            $this->setTagVocabulary($key, $value, $index);
            $this->setTagCode($key, $value, $index);
            $this->setVocabularyUri($key, $value, $index);
            $this->setTagNarrative($key, $value, $index);
        }
    }

    /**
     * Maps Tag Vocabulary.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setTagVocabulary($key, $value, $index): void
    {
        if (!isset($this->data['tag'][$index]['tag_vocabulary'])) {
            $this->data['tag'][$index]['tag_vocabulary'] = '';
        }

        if ($key === $this->_csvHeaders[0]) {
            $value = is_null($value) ? '' : trim($value);

            $validTagVocab = $this->loadCodeList('TagVocabulary');

            if ($value) {
                foreach ($validTagVocab as $code => $name) {
                    if (strcasecmp($value, $name) === 0) {
                        $value = (string) $code;
                        break;
                    }
                }
            }

            $this->data['tag'][$index]['tag_vocabulary'] = (string) $value;
        }
    }

    /**
     * Maps Tag Code.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setTagCode($key, $value, $index): void
    {
        if (!isset($this->data['tag'][$index]['tag_text'])) {
            $this->data['tag'][$index]['tag_text'] = '';
        }

        if ($key === $this->_csvHeaders[1]) {
            $tagVocabulary = $this->data['tag'][$index]['tag_vocabulary'] ?? '';
            $value = (!$value) ? '' : trim((string) $value);

            if ($tagVocabulary === '2') {
                $validTagCode = $this->loadCodeList('UNSDG-Goals');

                if ($value) {
                    foreach ($validTagCode as $code => $name) {
                        if (strcasecmp($value, $name) === 0) {
                            $value = (string) $code;
                            break;
                        }
                    }
                }

                $this->data['tag'][$index]['goals_tag_code'] = $value;
            } elseif ($tagVocabulary === '3') {
                $validTagCode = $this->loadCodeList('UNSDG-Targets');

                if (!is_float($value)) {
                    foreach ($validTagCode as $code => $name) {
                        if (strcasecmp($value, $name) === 0) {
                            $value = is_float($code) ? (float) $code : $code;
                            break;
                        }
                    }
                }

                $this->data['tag'][$index]['targets_tag_code'] = $value;
            } else {
                $this->data['tag'][$index]['tag_text'] = $value;
                $this->data['tag'][$index]['tag_vocabulary'] = $tagVocabulary;
            }
        }
    }

    /**
     * Set vocabulary uri for Tag.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setVocabularyUri($key, $value, $index): void
    {
        if ($key === $this->_csvHeaders[2] && Arr::get($this->data, 'tag.' . $index . '.vocabulary') === '99') {
            $this->data['tag'][$index]['vocabulary_uri'] = $value;
        }
    }

    /**
     * Set narrative for Tag.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setTagNarrative($key, $value, $index): void
    {
        if (!isset($this->data['tag'][$index]['narrative'][0]['narrative'])) {
            $this->data['tag'][$index]['narrative'][0] = [
                'narrative' => '',
                'language'  => '',
            ];
        }

        if ($key === $this->_csvHeaders[3]) {
            $value = $value ?: '';
            $narrative = [
                'narrative' => $value,
                'language'  => '',
            ];

            $this->data['tag'][$index]['narrative'][0] = $narrative;
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
        return $this->request->getWarningForTag(Arr::get($this->data(), 'tag', []));
    }

    /**
     * Provides the critical rules for the IATI Element validation.
     *
     * @return array
     * @throws \JsonException
     */
    public function errorRules(): array
    {
        return $this->request->getErrorsForTag(Arr::get($this->data(), 'tag', []));
    }

    /**
     * Provides custom messages used for IATI Element Validation.
     *
     * @return array
     */
    public function messages(): array
    {
        return $this->request->getMessagesForTag(Arr::get($this->data(), 'tag', []));
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
