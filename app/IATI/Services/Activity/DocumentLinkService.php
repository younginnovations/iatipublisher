<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\ParentCollectionFormCreator;
use App\IATI\Models\Activity\Activity;
use App\IATI\Repositories\Activity\DocumentLinkRepository;
use App\IATI\Repositories\Document\DocumentRepository;
use App\IATI\Traits\XmlBaseElement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Kris\LaravelFormBuilder\Form;

/**
 * Class DocumentLinkService.
 */
class DocumentLinkService
{
    use XmlBaseElement;

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
        $element = getElementSchema('document_link');
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

        $this->parentCollectionFormCreator->url = route('admin.activities.document-link.update', [$id]);

        return $this->parentCollectionFormCreator->editForm($model, $element, 'PUT', '/activities/' . $id);
    }

    /**
     * Returns data in required xml array format.
     *
     * @param Activity $activity
     *
     * @return array
     */
    public function getXmlData(Activity $activity): array
    {
        $activityData = [];
        $documentLinks = (array) $activity->document_link;

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

                $activityData[] = [
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

        return $activityData;
    }
}
