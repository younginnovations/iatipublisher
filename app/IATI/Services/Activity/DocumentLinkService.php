<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\ParentCollectionFormCreator;
use App\IATI\Repositories\Activity\DocumentLinkRepository;
use App\IATI\Repositories\Document\DocumentRepository;
use Illuminate\Database\Eloquent\Model;
use Kris\LaravelFormBuilder\Form;

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
     * @var ParentCollectionFormCreator
     */
    protected ParentCollectionFormCreator $parentCollectionFormCreator;

    /**
     * DocumentLinkService constructor.
     *
     * @param DocumentLinkRepository $documentLinkRepository
     * @param ParentCollectionFormCreator $parenCollectionFormCreator
     */
    public function __construct(DocumentLinkRepository $documentLinkRepository, ParentCollectionFormCreator $parentCollectionFormCreator)
    {
        $this->documentLinkRepository = $documentLinkRepository;
        $this->parentCollectionFormCreator = $parentCollectionFormCreator;
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

    /**
     * Generates document link form.
     *
     * @param id
     *
     * @return Form
     */
    public function formGenerator($id): Form
    {
        $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
        $activity = $this->getActivityData($id);
        $model['document_link'] = $this->getDocumentLinkData($id) ?: [];
        $documentLinks = $activity->documentLinks()->orderBy('updated_at', 'desc')->get()->toArray();

        foreach ($model['document_link'] as $key => $document) {
            foreach ($documentLinks as $findIndex => $file) {
                unset($document['document']);
                $document_link = (array) json_decode($file['document_link']);
                unset($document_link['document']);

                if (json_encode($document) == json_encode($document_link)) {
                    $model['document_link'][$key]['document'] = '';
                }
            }
        }

        $this->parentCollectionFormCreator->url = route('admin.activity.document-link.update', [$id]);

        return $this->parentCollectionFormCreator->editForm($model, $element['document_link'], 'PUT', '/activity/' . $id);
    }
}
