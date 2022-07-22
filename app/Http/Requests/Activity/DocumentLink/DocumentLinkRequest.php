<?php

declare(strict_types=1);

namespace App\Http\Requests\Activity\DocumentLink;

use App\Http\Requests\Activity\ActivityBaseRequest;

/**
 * Class DocumentLinkRequest.
 */
class DocumentLinkRequest extends ActivityBaseRequest
{
    /**
     * @return array
     */
    public function rules()
    {
        return $this->getRulesForDocumentLink($this->get('document_link'));
    }

    /**
     * @return array
     */
    public function messages()
    {
        return $this->getMessagesForDocumentLink($this->get('document_link'));
    }

    /**
     * @param $formFields
     * @param $formIndex
     * @return array
     */
    protected function getRulesForDocumentCategory($formFields, $formIndex)
    {
        $rules = [];
        foreach ($formFields as $documentCategoryIndex => $documentCategory) {
            $rules[sprintf('%s.category.%s.code', $formIndex, $documentCategoryIndex)] = 'required';
        }

        return $rules;
    }

    /**
     * @param $formFields
     * @param $formIndex
     * @return array
     */
    protected function getMessagesForDocumentCategory($formFields, $formIndex)
    {
        $messages = [];
        foreach ($formFields as $documentCategoryIndex => $documentCategory) {
            $messages[sprintf('%s.category.%s.code.required', $formIndex, $documentCategoryIndex)] = trans('validation.required', ['attribute' => trans('elementForm.category')]);
        }

        return $messages;
    }
}
