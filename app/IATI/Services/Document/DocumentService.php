<?php

declare(strict_types=1);

namespace App\IATI\Services\Document;

use App\IATI\Repositories\Document\DocumentRepository;
use Illuminate\Support\Facades\Storage;

/**
 * Class DocumentService.
 */
class DocumentService
{
    /**
     * @var DocumentRepository
     */
    private DocumentRepository $documentRepo;

    /**
     * Sett constructor.
     *
     * @param DocumentRepository $documentRepo
     */
    public function __construct(DocumentRepository $documentRepo)
    {
        $this->documentRepo = $documentRepo;
    }

    /**
     * Updates activity country budget item.
     *
     * @param $documentLink
     * @param $activity
     *
     * @return bool
     * @throws \JsonException
     */
    public function update($documentLink, $activity): bool
    {
        $savedDocumentLinks = $activity->documentLinks()->orderBy('updated_at', 'desc')->get()->toArray();

        foreach ($documentLink['document_link'] as $key => $document) {
            if (isset($document['document']) || !empty($document['url'])) {
                $file_exists = false;

                foreach ($savedDocumentLinks as $id => $savedLink) {
                    $temp_document = $document;
                    unset($temp_document['document']);
                    $fileLink = (array)$savedLink['document_link'];
                    unset($fileLink['document']);

                    if (json_encode($temp_document, JSON_THROW_ON_ERROR) === json_encode($fileLink, JSON_THROW_ON_ERROR)
                        || $temp_document['url'] === env('AWS_ENDPOINT').'/'.env('AWS_BUCKET').'/document_link/'.$activity['id'].'/'.$savedLink['filename']) {
                        unset($savedDocumentLinks[$id]);
                        $data = ['document_link' => json_encode($document, JSON_THROW_ON_ERROR)];
                        $this->documentRepo->updateOrCreateDocument($savedLink['filename'], $activity['id'], $data);
                        $file_exists = true;
                    }
                }

                if (!$file_exists && isset($document['document'])) {
                    $file             = $document['document'];
                    $data['filename'] = str_replace(' ', '_', $file->getClientOriginalName());
                    Storage::disk('minio')->putFileAs('/document_link/'.$activity['id'], $file, $data['filename']);
                    $data['activity_id']   = $activity['id'];
                    $data['extension']     = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
                    $data['document_link'] = json_encode($document, JSON_THROW_ON_ERROR);
                    $this->documentRepo->store($data);
                }
            }
        }

        if (count($savedDocumentLinks) > 0) {
            foreach ($savedDocumentLinks as $id => $savedFile) {
                $this->documentRepo->delete($savedFile['id']);
                Storage::disk('minio')->delete('/document_link/'.$activity['id'].'/'.$savedFile['filename']);
            }
        }

        return true;
    }

    /**
     * Find all document links corresponding to activity id.
     *
     * @param $activity_id
     *
     * @return array
     */
    public function getDocumentLinkData($activity_id): array
    {
        return $this->documentRepo->findBy('activity_id', $activity_id)->toArray();
    }
}
