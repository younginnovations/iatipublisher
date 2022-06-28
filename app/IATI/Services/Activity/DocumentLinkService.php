<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Repositories\Activity\DocumentLinkRepository;
use App\IATI\Repositories\Document\DocumentRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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
     * @var DocumentRepository
     */
    protected DocumentRepository $documentRepo;

    /**
     * DocumentLinkService constructor.
     *
     * @param DocumentLinkRepository $documentLinkRepository
     * @param DocumentRepository $documentRepo
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
        // foreach($documentLink['document_link'] as  $document){
        //     // dd($document['document']);
        //     try{
        //         dd(Storage::disk('s3')->files('content/artwork'),Storage::disk('s3'),$document['document'],Storage::disk('s3')->put('/', $document['document']));
        //         Storage::disk('s3')->put('/', file_get_content($document['document']));
        //     } catch(\Exception $e) {
        //     }
        // }
        return $this->documentLinkRepository->update($documentLink, $activity);
    }
}
