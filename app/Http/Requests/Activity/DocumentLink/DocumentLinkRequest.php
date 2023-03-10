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
     * Return rules for document link.
     *
     * @return array
     */
    public function rules(): array
    {
        $data = $this->get('document_link');
        $totalRules = [$this->getErrors($data), $this->getWarning($data)];

        return mergeRules($totalRules);
    }

    /**
     * Return critical rules for document link.
     *
     * @param $data
     *
     * @return array
     */
    public function getErrors($data): array
    {
        return $this->getErrorsForDocumentLink($data);
    }

    /**
     * Return critical rules for document link.
     *
     * @param $data
     *
     * @return array
     */
    public function getWarning($data): array
    {
        return $this->getWarningForDocumentLink($data);
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return $this->getMessagesForDocumentLink($this->get('document_link'));
    }
}
