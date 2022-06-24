<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Repositories\Activity\DocumentLinkRepository;
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
     * Returns country budget item data of an activity.
     *
     * @param int $activity_id
     *
     * @return array|null
     */
    public function getDocumentLinkData(int $activity_id): ?array
    {
        return $this->documentLinkRepository->getDocumentLinkData($activity_id);
    }

    /**
     * Returns activity object.
     *
     * @param $id
     *
     * @return Model
     */
    public function getActivityData($id): Model
    {
        return $this->documentLinkRepository->getActivityData($id);
    }

    /**
     * Updates activity country budget item.
     *
     * @param $documentLink
     * @param $activity
     *
     * @return bool
     */
    public function update($documentLink, $activity): bool
    {
        return $this->documentLinkRepository->update($documentLink, $activity);
    }
}
