<?php

declare(strict_types=1);

namespace App\CsvImporter\Entities\Activity\Components\Elements;

use App\CsvImporter\Entities\Activity\Components\Elements\Foundation\Iati\Element;
use App\CsvImporter\Entities\Activity\Components\Factory\Validation;
use Illuminate\Support\Arr;

/**
 * Class Tag.
 */
class Tag extends Element
{
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
     * Tag constructor.
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
        if ($key === $this->_csvHeaders[0]) {
            $value = (!$value) ? '' : trim($value);

            $validTagVocab = $this->loadCodeList('TagVocabulary');

            if ($value) {
                foreach ($validTagVocab as $code => $name) {
                    if (strcasecmp($value, $name) === 0) {
                        $value = strval($code);
                        break;
                    }
                }
            }

            $this->data['tag'][$index]['tag_vocabulary'] = strval($value);
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
        if ($key === $this->_csvHeaders[1]) {
            $tagVocabulary = $this->data['tag'][$index]['tag_vocabulary'] ?? '';
            $tagVocabulary = $tagVocabulary;
            $value = (!$value) ? '' : trim($value);

            if ($tagVocabulary === '1' || $tagVocabulary === '99') {
                $this->data['tag'][$index]['tag_text'] = $value;
            } elseif ($tagVocabulary === '2') {
                $validTagCode = $this->loadCodeList('UNSDG-Goals');

                if ($value) {
                    foreach ($validTagCode as $code => $name) {
                        if (strcasecmp($value, $name) === 0) {
                            $value = strval($code);
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
        if ($key === $this->_csvHeaders[2]) {
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
        if ($key === $this->_csvHeaders[3]) {
            $value = $value ?: '';
            $narrative = [
                'narrative' => $value,
                'language'  => '',
            ];

            $this->data['tag'][$index]['narrative'][] = $narrative;
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
        $validGoalsTagCode = implode(',', $this->validTagCodeList('UNSDG-Goals'));
        $validTargetsTagCode = implode(',', $this->validTagCodeList('UNSDG-Targets'));

        $rules = [];

        foreach (Arr::get($this->data(), 'tag', []) as $key => $value) {
            $tagForm = sprintf('tag.%s', $key);
            $rules[sprintf('%s.tag_vocabulary', $tagForm)] = sprintf(
                'in:1,2,3,99|required_with: %s,%s,%s,%s,%s',
                sprintf('%s.tag_text', $tagForm),
                sprintf('%s.goals_tag_code', $tagForm),
                sprintf('%s.targets_tag_code', $tagForm),
                sprintf('%s.vocabulary_uri', $tagForm),
                sprintf('%s.narrative.0.narrative', $tagForm),
            );
            $vocabulary = Arr::get($value, 'tag_vocabulary');

            if ($vocabulary) {
                $rules[sprintf('%s.vocabulary_uri', $tagForm)] = 'nullable|url';

                switch ($vocabulary) {
                    case '1':
                        $rules[sprintf('%s.tag_text', $tagForm)] = sprintf(
                            'required_with: %s,%s',
                            sprintf('%s.tag_vocabulary', $tagForm),
                            sprintf('%s.narrative.0.narrative', $tagForm),
                        );
                        break;
                    case '2':
                        $rules[sprintf('%s.goals_tag_code', $tagForm)] = sprintf(
                            'in:%s|required_with: %s,%s,%s',
                            $validGoalsTagCode,
                            sprintf('%s.tag_vocabulary', $tagForm),
                            sprintf('%s.vocabulary_uri', $tagForm),
                            sprintf('%s.narrative.0.narrative', $tagForm),
                        );
                        break;
                    case '3':
                        $rules[sprintf('%s.targets_tag_code', $tagForm)] = sprintf(
                            'in:%s|required_with: %s,%s,%s',
                            $validTargetsTagCode,
                            sprintf('%s.tag_vocabulary', $tagForm),
                            sprintf('%s.vocabulary_uri', $tagForm),
                            sprintf('%s.narrative.0.narrative', $tagForm),
                        );
                        break;
                    case '99':
                        $rules[sprintf('%s.tag_text', $tagForm)] = sprintf(
                            'required_with: %s,%s,%s',
                            sprintf('%s.tag_vocabulary', $tagForm),
                            sprintf('%s.vocabulary_uri', $tagForm),
                            sprintf('%s.narrative.0.narrative', $tagForm),
                        );
                        $rules[sprintf('%s.vocabulary_uri', $tagForm)] = sprintf(
                            'required_with: %s,%s,%s',
                            sprintf('%s.tag_vocabulary', $tagForm),
                            sprintf('%s.tag_text', $tagForm),
                            sprintf('%s.narrative.0.narrative', $tagForm),
                        );
                        break;
                    default:
                        $rules[sprintf('%s.tag_text', $tagForm)] = 'required';
                        break;
                }
            }
        }

        return $rules;
    }

    /**
     * Return Valid Tag Type.
     *
     * @param $name
     *
     * @return array
     * @throws \JsonException
     */
    protected function validTagCodeList($name): array
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

        foreach (Arr::get($this->data(), 'tag', []) as $key => $value) {
            $tagForm = sprintf('tag.%s', $key);
            $messages[sprintf('%s.tag_vocabulary.%s', $tagForm, 'in')] = trans('validation.code_list', ['attribute' => trans('elementForm.tag_vocabulary')]);
            $messages[sprintf('%s.tag_vocabulary.%s', $tagForm, 'required_with')] = trans('validation.required_with', ['attribute' => trans('elementForm.tag_vocabulary'), 'values' => 'code, uri or narrative']);
            $vocabulary = Arr::get($value, 'tag_vocabulary');

            if ($vocabulary) {
                $messages[sprintf('%s.vocabulary_uri.%s', $tagForm, 'url')] = trans(
                    'validation.active_url',
                    ['attribute' => trans('elementForm.tag_vocabulary_url')]
                );

                switch ($vocabulary) {
                    case '1':
                        $messages[sprintf('%s.tag_text.%s', $tagForm, 'required_with')] = trans(
                            'validation.required_with',
                            ['attribute' => trans('elementForm.tag_code'),
                                'values' => 'Vocabulary, url or narrative', ]
                        );
                        break;
                    case '2':
                        $messages[sprintf('%s.goals_tag_code.%s', $tagForm, 'required_with')] = trans(
                            'validation.required_with',
                            ['attribute' => trans('elementForm.tag_code'),
                             'values' => 'Vocabulary, url or narrative', ]
                        );
                        break;
                    case '3':
                        $messages[sprintf('%s.targets_tag_code.%s', $tagForm, 'required_with')] = trans(
                            'validation.required_with',
                            ['attribute' => trans('elementForm.tag_code'),
                             'values' => 'Vocabulary, url or narrative', ]
                        );
                        break;
                    case '99':
                        $messages[sprintf('%s.tag_text.%s', $tagForm, 'required_with')] = trans(
                            'validation.required_with',
                            ['attribute' => trans('elementForm.tag_code'),
                             'values' => 'Vocabulary, url or narrative', ]
                        );
                        $messages[sprintf('%s.vocabulary_uri.%s', $tagForm, 'required_with')] = trans(
                            'validation.required_with',
                            ['attribute' => trans('elementForm.vocabulary_uri'),
                             'values' => 'Vocabulary, code or narrative', ]
                        );
                        break;
                    default:
                        $messages[sprintf('%s.tag_text.%s', $tagForm, 'required_with')] = trans(
                            'validation.required_with',
                            ['attribute' => trans('elementForm.tag_code'),
                             'values' => 'Vocabulary, url or narrative', ]
                        );
                }
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
