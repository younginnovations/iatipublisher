<?php

declare(strict_types=1);

namespace App\Http\Requests\Activity\Result;

use App\Http\Requests\Activity\ActivityBaseRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

/**
 * Class ResultRequest.
 */
class ResultRequest extends ActivityBaseRequest
{
    /**
     * Result request constructor.
     */
    public function __construct()
    {
        parent::__construct();

        Validator::extendImplicit(
            'required_if_any',
            function ($attribute, $value, $parameters, $validator) {
                $countValue = count(array_filter($parameters, function ($val, $key) {
                    return ($key % 2 != 0) && $val != '';
                }, ARRAY_FILTER_USE_BOTH));

                if ($value == '' && $countValue === 0) {
                    return true;
                }

                if ($countValue > 0) {
                    return false;
                }

                return true;
            }
        );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return $this->getRulesForResult(request()->except(['_token']));
    }

    /**
     * Get the error message as required.
     *
     * @return array
     */
    public function messages(): array
    {
        return $this->getMessagesForResult(request()->except(['_token']));
    }

    /**
     * Returns rules for related activity.
     *
     * @param array $formFields
     *
     * @return array
     */
    protected function getRulesForResult(array $formFields): array
    {
        $rules = [];

        $rules = array_merge(
            $rules,
            $this->getRulesForNarrative($formFields['title'][0]['narrative'], 'title.0'),
            $this->getRulesForNarrative($formFields['description'][0]['narrative'], 'description.0'),
            $this->getRulesForDocumentLink($formFields['document_link']),
            $this->getRulesForReferences($formFields['reference'])
        );

        return $rules;
    }

    /**
     * Returns messages for related activity validations.
     *
     * @param array $formFields
     *
     * @return array
     */
    protected function getMessagesForResult(array $formFields): array
    {
        $messages = [];

        $messages = array_merge(
            $messages,
            $this->getMessagesForNarrative($formFields['title'][0]['narrative'], 'title.0'),
            $this->getMessagesForNarrative($formFields['description'][0]['narrative'], 'description.0'),
            $this->getMessagesForDocumentLink($formFields['document_link']),
            $this->getMessagesForReferences($formFields['reference'])
        );

        return $messages;
    }

    /**
     * returns rules for Document Link.
     *
     * @param $formFields
     * @param $formBase
     *
     * @return array|mixed
     */
    public function getRulesForDocumentLink($formFields)
    {
        $rules = [];

        foreach ($formFields as $documentLinkIndex => $documentLink) {
            $documentLinkForm = sprintf('document_link.%s', $documentLinkIndex);

            if (Arr::get($documentLink, 'url', null) == '') {
                $rules[sprintf('%s.url', $documentLinkForm)]
                    = sprintf(
                        'required_if_any:format,%s,title,%s,description,%s,category_code,%s,language,%s,document_date,%s',
                        $documentLink['format'],
                        $documentLink['title'][0]['narrative'][0]['narrative'],
                        $documentLink['description'][0]['narrative'][0]['narrative'],
                        $documentLink['category'][0]['code'],
                        $documentLink['language'][0]['language'],
                        $documentLink['document_date'][0]['date']
                    );
            }

            if (Arr::get($documentLink, 'format', null) == '') {
                $rules[sprintf('%s.format', $documentLinkForm)]
                    = sprintf(
                        'required_if_any:url,%s,title,%s,description,%s,category_code,%s,language,%s,document_date,%s',
                        $documentLink['url'],
                        $documentLink['title'][0]['narrative'][0]['narrative'],
                        $documentLink['description'][0]['narrative'][0]['narrative'],
                        $documentLink['category'][0]['code'],
                        $documentLink['language'][0]['language'],
                        $documentLink['document_date'][0]['date']
                    );
            }

            if (Arr::get($documentLink, 'title.0.narrative.0.narrative', null) == '') {
                $rules[sprintf('%s.title.0.narrative.0.narrative', $documentLinkForm)]
                    = sprintf(
                        'required_if_any:url,%s,format,%s,description,%s,category_code,%s,language,%s,document_date,%s',
                        $documentLink['url'],
                        $documentLink['format'],
                        $documentLink['description'][0]['narrative'][0]['narrative'],
                        $documentLink['category'][0]['code'],
                        $documentLink['language'][0]['language'],
                        $documentLink['document_date'][0]['date']
                    );
            }

            if (Arr::get($documentLink, 'category.0.code', null) == '') {
                $rules[sprintf('%s.category.0.code', $documentLinkForm)]
                    = sprintf(
                        'required_if_any:url,%s,format,%s,title,%s,description,%s,language,%s,document_date,%s',
                        $documentLink['url'],
                        $documentLink['format'],
                        $documentLink['title'][0]['narrative'][0]['narrative'],
                        $documentLink['description'][0]['narrative'][0]['narrative'],
                        $documentLink['language'][0]['language'],
                        $documentLink['document_date'][0]['date']
                    );
            }

            if (Arr::get($documentLink, 'url', null) != '') {
                $rules[sprintf('%s.url', $documentLinkForm)] = 'nullable|url';
            }

            if (Arr::get($documentLink, 'document_date', null) != '') {
                $rules = array_merge(
                    $rules,
                    $this->getRulesForDocumentDate($documentLink['document_date'], $documentLinkForm, $documentLink),
                );
            }
        }

        return $rules;
    }

    /**
     * returns messages for Document Link.
     *
     * @param $formFields
     *
     * @return array|mixed
     */
    public function getMessagesForDocumentLink($formFields)
    {
        $messages = [];

        foreach ($formFields as $documentLinkIndex => $documentLink) {
            $documentLinkForm = sprintf('document_link.%s', $documentLinkIndex);

            if (Arr::get($documentLink, 'url', null) == '') {
                $messages[sprintf('%s.url.required_if_any', $documentLinkForm)]
                    = 'The @url field is required if any of the fields of Document Link are filled.';
            }

            if (Arr::get($documentLink, 'format', null) == '') {
                $messages[sprintf('%s.format.required_if_any', $documentLinkForm)]
                    = 'The @format field is required if any of the fields of Document Link are filled.';
            }

            if (Arr::get($documentLink, 'title.0.narrative.0.narrative', null) == '') {
                $messages[sprintf('%s.title.0.narrative.0.narrative.required_if_any', $documentLinkForm)]
                    = 'The narrative field is required if any of the fields of Document Link are filled.';
            }

            if (Arr::get($documentLink, 'category.0.code', null) == '') {
                $messages[sprintf('%s.category.0.code.required_if_any', $documentLinkForm)]
                    = 'The @code field is required if any of the fields of Document Link are filled.';
            }

            if (Arr::get($documentLink, 'url', null) != '') {
                $messages[sprintf('%s.url.url', $documentLinkForm)] = 'The @url field must be a valid url.';
            }

            if (Arr::get($documentLink, 'document_date', null) != '') {
                $messages = array_merge(
                    $messages,
                    $this->getMessagesForDocumentDate($documentLink['document_date'], $documentLinkForm)
                );
            }
        }

        return $messages;
    }

    /**
     * returns messages for document date.
     *
     * @param $formFields
     * @param $formIndex
     *
     * @return array
     */
    protected function getMessagesForDocumentDate($formFields, $formIndex)
    {
        $messages = [];

        foreach ($formFields as $documentCategoryIndex => $documentCategory) {
            $messages[sprintf('%s.document_date.%s.date.date', $formIndex, $documentCategoryIndex)]
                = 'The @iso-date field must be a proper date.';
        }

        return $messages;
    }

    /**
     * returns rules for document date.
     *
     * @param $formFields
     * @param $formIndex
     * @param $documentLink
     *
     * @return array
     */
    protected function getRulesForDocumentDate($formFields, $formIndex, $documentLink)
    {
        $rules = [];

        foreach ($formFields as $documentCategoryIndex => $documentCategory) {
            $rules[sprintf('%s.document_date.%s.date', $formIndex, $documentCategoryIndex)] = 'nullable|date';
        }

        return $rules;
    }

    /**
     * returns rules for Reference.
     *
     * @param $formFields
     *
     * @return array|mixed
     */
    protected function getRulesforReferences($formFields)
    {
        $rules = [];

        foreach ($formFields as $referenceIndex => $reference) {
            $referenceForm = sprintf('reference.%s', $referenceIndex);
            $rules[sprintf('%s.code', $referenceForm)] = 'required_with:' . $referenceForm . '.vocabulary';
            $rules[sprintf('%s.vocabulary', $referenceForm)] = sprintf(
                'required_with:%s,%s',
                $referenceForm . '.code',
                $referenceForm . '.vocabulary_uri'
            );
            $rules[sprintf('%s.vocabulary_uri', $referenceForm)]
                = 'nullable|url|required_with:' . $referenceForm . '.vocabulary';
        }

        return $rules;
    }

    /**
     * returns messages for Reference.
     *
     * @param $formFields
     *
     * @return array|mixed
     */
    protected function getMessagesForReferences($formFields)
    {
        $messages = [];

        foreach ($formFields as $referenceIndex => $reference) {
            $referenceForm = sprintf('reference.%s', $referenceIndex);
            $messages[sprintf('%s.vocabulary.required_with', $referenceForm)]
                = 'The @vocabulary field is required with @code field.';
            $messages[sprintf('%s.code.required_with', $referenceForm)]
                = 'The @code field is required with @vocabulary field.';
            $messages[sprintf('%s.vocabulary_uri.url', $referenceForm)]
                = 'The @vocabulary-uri field must be a valid url.';
            $messages[sprintf('%s.vocabulary_uri.%s', $referenceForm, 'required_with')]
                = 'The @vocabulary-uri field is required with @vocabulary field.';
        }

        return $messages;
    }
}
