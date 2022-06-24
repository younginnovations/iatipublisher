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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return $this->getRulesForDocumentLink($this->get('document_link'));
    }

    /**
     * Get the error message as required.
     *
     * @return array
     */
    public function messages(): array
    {
        return $this->getMessagesForCountryBudgetItem(request()->except(['_token', '_method']));
    }

    /**
     * Rules for document link.
     *
     * @param array $formFields
     *
     * @return array
     */
    public function getRulesForDocumentLink(array $formFields): array
    {
        $rules = [];

        foreach ($formFields as $documentLinkIndex => $documentLink) {
            $documentLinkForm = sprintf(
                'document_link.%s',
                $documentLinkIndex
            );
            $rules[sprintf('document_link.%s.url', $documentLinkIndex)] = 'required|url';
            $rules[sprintf('document_link.%s.format', $documentLinkIndex)] = 'required';
            $rules[sprintf('document_link.%s.document_date.0.date', $documentLinkIndex)] = 'date';
            $rules = array_merge(
                $rules,
                $this->getRulesForNarrative($documentLink['title'][0]['narrative'], sprintf('%s.title.0', $documentLinkForm), true),
                $this->getRulesForNarrative($documentLink['description'][0]['narrative'], sprintf('%s.description.0', $documentLinkForm)),
                $this->getRulesForDocumentCategory($documentLink['category'], $documentLinkForm),
                $this->getRulesForRecipientCountry($documentLink['recipient_country'], $documentLinkForm)
            );
        }

        return $rules;
    }

    /**
     * Customized error message for document link.
     *
     * @param array $formFields
     *
     * @return array
     */
    public function getMessagesForDocumentLink(array $formFields): array
    {
        $messages = [];

        foreach ($formFields as $documentLinkIndex => $documentLink) {
            $documentLinkForm = sprintf(
                'document_link.%s',
                $documentLinkIndex
            );
            $messages[sprintf('document_link.%s.url.required', $documentLinkIndex)] = trans('validation.required', ['attribute' => trans('elementForm.url')]);
            $messages[sprintf(
                'document_link.%s.url.url',
                $documentLinkIndex
            )] = trans('validation.url');
            $messages[sprintf('document_link.%s.format.required', $documentLinkIndex)] = trans('validation.required', ['attribute' => trans('elementForm.format')]);
            $messages[sprintf('document_link.%s.document_date.0.date.date', $documentLinkIndex)] = trans('validation.date', ['attribute' => trans('elementForm.date')]);
            $messages = array_merge(
                $messages,
                $this->getMessagesForNarrative($documentLink['title'][0]['narrative'], sprintf('%s.title.0', $documentLinkForm)),
                $this->getMessagesForNarrative($documentLink['description'][0]['narrative'], sprintf('%s.description.0', $documentLinkForm)),
                $this->getMessagesForDocumentCategory($documentLink['category'], $documentLinkForm),
                $this->getMessagesForRecipientCountry($documentLink['recipient_country'], $documentLinkForm)
            );
        }

        return $messages;
    }
}
