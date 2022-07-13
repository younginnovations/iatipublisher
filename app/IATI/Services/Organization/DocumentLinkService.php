<?php

declare(strict_types=1);

namespace App\IATI\Services\Organization;

use App\IATI\Models\Organization\Organization;
use App\IATI\Repositories\Organization\DocumentLinkRepository;
use App\IATI\Traits\OrganizationXmlBaseElements;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

/**
 * Class DocumentLinkService.
 */
class DocumentLinkService
{
    use OrganizationXmlBaseElements;

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

    /**
     * Returns data in required xml array format.
     *
     * @param Organization $organization
     *
     * @return array
     */
    public function getXmlData(Organization $organization): array
    {
        $organizationData = [];
        $documentLinks = (array) $organization->document_link;

        if (count($documentLinks)) {
            foreach ($documentLinks as $documentLink) {
                $categories = [];

                foreach (Arr::get($documentLink, 'category', []) as $value) {
                    $categories[] = [
                        '@attributes' => ['code' => Arr::get($value, 'code', null)],
                    ];
                }

                $languages = [];

                foreach (Arr::get($documentLink, 'language', []) as $language) {
                    $languages[] = [
                        '@attributes' => ['code' => Arr::get($language, 'code', null)],
                    ];
                }

                $organizationData[] = [
                    '@attributes'   => [
                        'url'    => Arr::get($documentLink, 'url', null),
                        'format' => Arr::get($documentLink, 'format', null),
                    ],
                    'title'         => [
                        'narrative' => $this->buildNarrative(Arr::get($documentLink, 'title.0.narrative', [])),
                    ],
                    'description'   => [
                        'narrative' => $this->buildNarrative(Arr::get($documentLink, 'description.0.narrative', [])),
                    ],
                    'category'      => $categories,

                    'language'      => $languages,
                    'document-date' => [
                        '@attributes' => [
                            'iso-date' => Arr::get($documentLink, 'document_date.0.date', null),
                        ],
                    ],
                ];
            }
        }

        return $organizationData;
    }
}
