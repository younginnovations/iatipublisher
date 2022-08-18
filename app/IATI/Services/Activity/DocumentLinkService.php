<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\ParentCollectionFormCreator;
use App\IATI\Repositories\Activity\ActivityRepository;
use App\IATI\Repositories\Document\DocumentRepository;
use Kris\LaravelFormBuilder\Form;

/**
 * Class DocumentLinkService.
 */
class DocumentLinkService
{
    /**
     * @var ActivityRepository
     */
    protected ActivityRepository $activityRepository;

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
     * @param ActivityRepository $activityRepository
     * @param ParentCollectionFormCreator $parentCollectionFormCreator
     */
    public function __construct(ActivityRepository $activityRepository, ParentCollectionFormCreator $parentCollectionFormCreator)
    {
        $this->activityRepository = $activityRepository;
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
        return $this->activityRepository->find($activity_id)->document_link;
    }

    /**
     * Returns activity object.
     *
     * @param $id
     *
     * @return object
     */
    public function getActivityData($id): object
    {
        return $this->activityRepository->find($id);
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
        return $this->activityRepository->update($activity->id, ['document_link' => $this->sanitizeDocumentLinkData($documentLink)]);
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

    /**
     * Sanitizes document link data.
     *
     * @param $documentLink
     *
     * @return array
     */
    public function sanitizeDocumentLinkData($documentLink): array
    {
        $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true)['document_link'];

        foreach ($documentLink['document_link'] as $key => $document) {
            foreach (array_keys($element['sub_elements']) as $subelement) {
                $documentLink['document_link'][$key][$subelement] = array_values($document[$subelement]);
            }
        }

        return array_values($documentLink['document_link']);
    }
}
