<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Organization;

use App\IATI\Models\Organization\Organization;
use Illuminate\Database\Eloquent\Model;

/**
 * Class  DocumentLinkRepository.
 */
class DocumentLinkRepository
{
    /**
     * @var Organization
     */
    protected Organization $organization;

    /**
     *  DocumentLinkRepository Constructor.
     *
     * @param Organization $organization
     */
    public function __construct(Organization $organization)
    {
        $this->organization = $organization;
    }

    /**
     * Returns document link data of an organization.
     *
     * @param $organizationId
     *
     * @return array|null
     */
    public function getDocumentLinkData($organizationId): ?array
    {
        return $this->organization->findorFail($organizationId)->document_link;
    }

    /**
     * Returns organization object.
     *
     * @param $id
     *
     * @return Model
     */
    public function getOrganizationData($id): Model
    {
        return $this->organization->findOrFail($id);
    }

    /**
     * Updates organization document link.
     *
     * @param $documentLink
     * @param $organization
     *
     * @return bool
     */
    public function update($documentLink, $organization): bool
    {
        $element = json_decode(file_get_contents(app_path('IATI/Data/organizationElementJsonSchema.json')), true)['document_link'];

        foreach ($documentLink['document_link'] as $key => $document) {
            foreach (array_keys($element['sub_elements']) as $subelement) {
                $documentLink['document_link'][$key][$subelement] = array_values($document[$subelement]);
            }
        }

        $organization->document_link = $documentLink['document_link'];

        return $organization->save();
    }
}
