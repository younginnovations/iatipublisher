<?php

declare(strict_types=1);

namespace App\CsvImporter\Entities\Activity\Components\Elements;

use App\CsvImporter\Entities\Activity\Components\Elements\Foundation\Iati\Element;
use App\CsvImporter\Entities\Activity\Components\Factory\Validation;
use App\Http\Requests\Activity\DocumentLink\DocumentLinkRequest;
use Illuminate\Support\Arr;

/**
 * Class DocumentLink.
 */
class DocumentLink extends Element
{
    /**
     * Csv Header for DocumentLink element.
     * @var array
     */
    private array $_csvHeaders
        = [
            'document_link_url',
            'document_link_format',
            'document_link_title',
            'document_link_description',
            'document_link_category',
            'document_link_language',
            'document_date',
        ];

    /**
     * Index under which the data is stored within the object.
     *
     * @var string
     */
    protected string $index = 'document_link';

    /**
     * @var DocumentLinkRequest
     */
    private DocumentLinkRequest $request;

    /**
     * DocumentLink constructor.
     *
     * @param            $fields
     * @param Validation $factory
     */
    public function __construct($fields, Validation $factory)
    {
        $this->prepare($fields);
        $this->factory = $factory;
        $this->request = new DocumentLinkRequest();
    }

    /**
     * Prepare DocumentLink element.
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
     * Map data from CSV file into DocumentLink data format.
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
            $this->setDocumentLinkUrl($key, $value, $index);
            $this->setDocumentLinkFormat($key, $value, $index);
            $this->setTitleNarrative($key, $value, $index);
            $this->setDescriptionNarrative($key, $value, $index);
            $this->setDocumentLinkCategory($key, $value, $index);
            $this->setDocumentLinkLanguage($key, $value, $index);
            $this->setDocumentLinkDate($key, $value, $index);
        }
    }

    /**
     * Set document url for DocumentLink.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setDocumentLinkUrl($key, $value, $index): void
    {
        if (!isset($this->data['document_link'][$index]['url'])) {
            $this->data['document_link'][$index]['url'] = '';
        }

        if ($key === $this->_csvHeaders[0]) {
            $this->data['document_link'][$index]['url'] = $value;
        }
    }

    /**
     * Maps DocumentLink Format.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setDocumentLinkFormat($key, $value, $index): void
    {
        if (!isset($this->data['document_link'][$index]['format'])) {
            $this->data['document_link'][$index]['format'] = '';
        }

        if ($key === $this->_csvHeaders[1]) {
            $value = (!$value) ? '' : trim($value);

            $this->data['document_link'][$index]['format'] = $value;
        }
    }

    /**
     * Set narrative for Title.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setTitleNarrative($key, $value, $index): void
    {
        if (!isset($this->data['document_link'][$index]['title'][0]['narrative'][0]['narrative'])) {
            $this->data['document_link'][$index]['title'][0]['narrative'][0] = [
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

            $this->data['document_link'][$index]['title'][0]['narrative'][0] = $narrative;
        }
    }

    /**
     * Set narrative for Description.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setDescriptionNarrative($key, $value, $index): void
    {
        if (!isset($this->data['document_link'][$index]['description'][0]['narrative'][0]['narrative'])) {
            $this->data['document_link'][$index]['description'][0]['narrative'][0] = [
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

            $this->data['document_link'][$index]['description'][0]['narrative'][0] = $narrative;
        }
    }

    /**
     * Set document link category for DocumentLink.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setDocumentLinkCategory($key, $value, $index): void
    {
        if (!isset($this->data['document_link'][$index]['category'][0]['code'])) {
            $this->data['document_link'][$index]['category'][0]['code'] = '';
        }

        if ($key === $this->_csvHeaders[4]) {
            $value = (!$value) ? '' : trim($value);

            $validDocumentCategory = $this->loadCodeList('DocumentCategory');

            if ($value) {
                foreach ($validDocumentCategory as $code => $name) {
                    if (strcasecmp($value, $name) === 0) {
                        $value = (string) $code;
                        break;
                    }
                }
            }

            $this->data['document_link'][$index]['category'][0]['code'] = strtoupper($value);
        }
    }

    /**
     * Set document link language for DocumentLink.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setDocumentLinkLanguage($key, $value, $index): void
    {
        if (!isset($this->data['document_link'][$index]['language'][0]['code'])) {
            $this->data['document_link'][$index]['language'][0]['code'] = '';
        }

        if ($key === $this->_csvHeaders[5]) {
            $value = (!$value) ? '' : trim($value);

            $validLanguage = $this->loadCodeList('Language');

            if ($value) {
                foreach ($validLanguage as $code => $name) {
                    if (strcasecmp($value, $name) === 0) {
                        $value = (string) $code;
                        break;
                    }
                }
            }

            $this->data['document_link'][$index]['language'][0]['code'] = $value;
        }
    }

    /**
     * Set document date for DocumentLink.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setDocumentLinkDate($key, $value, $index): void
    {
        if (!isset($this->data['document_link'][$index]['document_date'][0]['date'])) {
            $this->data['document_link'][$index]['document_date'][0]['date'] = '';
        }

        if ($key === $this->_csvHeaders[6]) {
            $value = (!$value) ? '' : trim($value);
            $this->data['document_link'][$index]['document_date'][0]['date'] = dateFormat('Y-m-d', $value);
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
        return $this->request->getRulesForDocumentLink(Arr::get($this->data(), 'document_link', []));
    }

    /**
     * Provides custom messages used for IATI Element Validation.
     *
     * @return array
     */
    public function messages(): array
    {
        return $this->request->getMessagesForDocumentLink(Arr::get($this->data(), 'document_link', []));
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
