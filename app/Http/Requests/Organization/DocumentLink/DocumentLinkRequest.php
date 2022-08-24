<?php

declare(strict_types=1);

namespace App\Http\Requests\Organization\DocumentLink;

use App\Http\Requests\Organization\OrganizationBaseRequest;

/**
 * Class DocumentLinkRequest.
 */
class DocumentLinkRequest extends OrganizationBaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Rules for document link.
     *
     * @return array
     */
    public function rules(): array
    {
        return $this->getRulesForDocumentLink($this->get('document_link'));
    }

    /**
     * Custom message for rules.
     *
     * @return array
     */
    public function messages(): array
    {
        return $this->getMessagesForDocumentLink($this->get('document_link'));
    }

    /**
     * Rules for fields of document link form.
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
            $rules[sprintf('document_link.%s.url', $documentLinkIndex)] = 'nullable|url';
            $rules[sprintf('document_link.%s.format', $documentLinkIndex)] = 'nullable';
            $rules[sprintf('document_link.%s.document_date.0.date', $documentLinkIndex)] = 'nullable|date';
            $rules = array_merge(
                $rules,
                $this->getRulesForNarrative($documentLink['title'][0]['narrative'], sprintf('%s.title.0', $documentLinkForm), true),
                $this->getRulesForNarrative($documentLink['description'][0]['narrative'], sprintf('%s.description.0', $documentLinkForm)),
                $this->getRulesForDocumentCategory($documentLink['category'], $documentLinkForm),
                $this->getRulesForDocumentLanguage($documentLink['language'], $documentLinkForm),
                $this->getRulesForRecipientCountry($documentLink['recipient_country'], $documentLinkForm)
            );
        }

        return $rules;
    }

    /**
     * Custom message for document link.
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
                $this->getMessagesForDocumentLanguage($documentLink['language'], $documentLinkForm),
                $this->getMessagesForRecipientCountry($documentLink['recipient_country'], $documentLinkForm)
            );
        }

        return $messages;
    }

    /**
     * Rules for document link category field.
     *
     * @param $formFields
     * @param $formIndex
     *
     * @return array
     */
    public function getRulesForDocumentCategory($formFields, $formIndex): array
    {
        $rules = [];
        $rules[sprintf('%s.category', $formIndex)] = 'unique_category';

        foreach ($formFields as $documentCategoryIndex => $documentCategory) {
            $rules[sprintf('%s.category.%s.code', $formIndex, $documentCategoryIndex)] = 'nullable';
        }

        return $rules;
    }

    /**
     * Custom message for document link category.
     *
     * @param $formFields
     * @param $formIndex
     *
     * @return array
     */
    public function getMessagesForDocumentCategory($formFields, $formIndex): array
    {
        $messages = [];
        $messages[sprintf(
            '%s.category.unique_category',
            $formIndex
        )] = 'The category @code field must be unique.';

        foreach ($formFields as $documentCategoryIndex => $documentCategory) {
            $messages[sprintf(
                '%s.category.%s.code.required',
                $formIndex,
                $documentCategoryIndex
            )] = 'The @code field is required.';
        }

        return $messages;
    }

    /**
     * Rules for document language code field.
     *
     * @param $formFields
     * @param $formIndex
     *
     * @return array
     */
    public function getRulesForDocumentLanguage($formFields, $formIndex): array
    {
        $rules = [];
        $rules[sprintf('%s.language', $formIndex)] = 'unique_category';

        foreach ($formFields as $documentCategoryIndex => $documentCategory) {
            $rules[sprintf('%s.language.%s.code', $formIndex, $documentCategoryIndex)] = 'nullable';
        }

        return $rules;
    }

    /**
     * Custom message for document language.
     *
     * @param $formFields
     * @param $formIndex
     *
     * @return array
     */
    public function getMessagesForDocumentLanguage($formFields, $formIndex): array
    {
        $messages = [];
        $messages[sprintf(
            '%s.language.unique_category',
            $formIndex
        )] = 'The language @code field must be unique.';

        foreach ($formFields as $documentCategoryIndex => $documentCategory) {
            $messages[sprintf(
                '%s.language.%s.code.required',
                $formIndex,
                $documentCategoryIndex
            )] = 'The @code field is required.';
        }

        return $messages;
    }

    /**
     * Rules for recipient country of document link.
     *
     * @param $formFields
     * @param $formIndex
     *
     * @return array
     */
    public function getRulesForRecipientCountry($formFields, $formIndex): array
    {
        $rules = [];

        foreach ($formFields as $recipientCountryIndex => $recipientCountryVal) {
            $budgetItemForm = sprintf('%s.recipient_country.%s', $formIndex, $recipientCountryIndex);
            $rules = array_merge(
                $rules,
                $this->getRulesForNarrative($recipientCountryVal['narrative'], $budgetItemForm)
            );
        }

        return $rules;
    }

    /**
     * Custom rules for recipient country of document link.
     *
     * @param $formFields
     * @param $formIndex
     *
     * @return array
     */
    public function getMessagesForRecipientCountry($formFields, $formIndex): array
    {
        $messages = [];

        foreach ($formFields as $recipientCountryIndex => $recipientCountryVal) {
            $budgetItemForm = sprintf('%s.recipient_country.%s', $formIndex, $recipientCountryIndex);
            $messages = array_merge(
                $messages,
                $this->getMessagesForNarrative($recipientCountryVal['narrative'], $budgetItemForm)
            );
        }

        return $messages;
    }
}
