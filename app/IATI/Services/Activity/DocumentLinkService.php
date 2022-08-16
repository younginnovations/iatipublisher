<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\ParentCollectionFormCreator;
use App\IATI\Models\Activity\Activity;
use App\IATI\Repositories\Activity\ActivityRepository;
use App\IATI\Traits\XmlBaseElement;
use Illuminate\Support\Arr;
use Kris\LaravelFormBuilder\Form;

/**
 * Class DocumentLinkService.
 */
class DocumentLinkService
{
    use XmlBaseElement;

    /**
     * @var ActivityRepository
     */
    protected ActivityRepository $activityRepository;

    /**
     * @var ParentCollectionFormCreator
     */
    protected ParentCollectionFormCreator $parentCollectionFormCreator;

    /**
     * DocumentLinkService constructor.
     *
     * @param ActivityRepository          $activityRepository
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
     * @param $id
     * @param $documentLink
     *
     * @return bool
     * @throws \JsonException
     */
    public function update($id, $documentLink): bool
    {
        return $this->activityRepository->update($id, ['document_link' => $this->sanitizeDocumentLinkData($documentLink)]);
    }

    /**
     * Generates document link form.
     *
     * @param $id
     *
     * @return Form
     * @throws \JsonException
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
                $document_link = json_decode($file['document_link'], true, 512, JSON_THROW_ON_ERROR);
                unset($document_link['document']);

                if (json_encode($document, JSON_THROW_ON_ERROR) === json_encode($document_link, JSON_THROW_ON_ERROR)) {
                    $model['document_link'][$key]['document'] = '';
                }
            }
        }

        $this->parentCollectionFormCreator->url = route('admin.activity.document-link.update', [$id]);

        return $this->parentCollectionFormCreator->editForm($model, $element, 'PUT', '/activity/' . $id);
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
                    '@attributes' => [
                        'url'    => Arr::get($documentLink, 'url', null),
                        'format' => Arr::get($documentLink, 'format', null),
                    ],
                    'title'       => [
                        'narrative' => $this->buildNarrative(Arr::get($documentLink, 'title.0.narrative', [])),
                    ],
                    'description' => [
                        'narrative' => $this->buildNarrative(Arr::get($documentLink, 'description.0.narrative', [])),
                    ],
                    'category'    => $categories,

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

    /**
     * Sanitizes document link data.
     *
     * @param $documentLink
     *
     * @return array
     * @throws \JsonException
     */
    public function sanitizeDocumentLinkData($documentLink): array
    {
        $element = getElementSchema('document_link');

        foreach ($documentLink['document_link'] as $key => $document) {
            foreach (array_keys($element['sub_elements']) as $subElement) {
                $documentLink['document_link'][$key][$subElement] = array_values($document[$subElement]);
            }
        }

        return array_values($documentLink['document_link']);
    }
}
