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
        $totalRules = [$this->getCriticalRules(), $this->getRules()];

        return mergeRules($totalRules);
    }

    /**
     * Return critical rules for document link.
     *
     * @return array
     */
    public function getCriticalRules(): array
    {
        return $this->getCriticalRulesForDocumentLink($this->get('document_link'));
    }

    /**
     * Return critical rules for document link.
     *
     * @return array
     */
    public function getRules(): array
    {
        return $this->getRulesForDocumentLink($this->get('document_link'));
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return $this->getMessagesForDocumentLink($this->get('document_link'));
    }
}
