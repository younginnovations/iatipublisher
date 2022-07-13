<?php

declare(strict_types=1);

namespace App\IATI\Services\Organization;

use App\IATI\Repositories\Organization\DocumentLinkRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DocumentLinkService.
 */
class DocumentLinkService
{
    /**
     * @var DocumentLinkRepository
     */
    protected DocumentLinkRepository $documentLinkRepository;

    /**
     * DocumentLinkService constructor.
     *
     * @param DocumentLinkRepository $documentLinkRepository
     */
    public function __construct(DocumentLinkRepository $documentLinkRepository)
    {
        $this->documentLinkRepository = $documentLinkRepository;
    }

    /**
     * Returns document link of an organization.
     *
     * @param int $organization_id
     *
     * @return array|null
     */
    public function getDocumentLinkData(int $organization_id): ?array
    {
        return $this->documentLinkRepository->getDocumentLinkData($organization_id);
    }

    /**
     * Returns Organization object.
     *
     * @param $id
     *
     * @return Model
     */
    public function getOrganizationData($id): Model
    {
        return $this->documentLinkRepository->getOrganizationData($id);
    }

    /**
     * Updates Organization document link.
     *
     * @param $documentLink
     * @param $organization
     *
     * @return bool
     */
    public function update($documentLink, $organization): bool
    {
        return $this->documentLinkRepository->update($documentLink, $organization);
    }
}
