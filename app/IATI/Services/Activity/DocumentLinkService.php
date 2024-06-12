<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\ParentCollectionFormCreator;
use App\IATI\Models\Activity\Activity;
use App\IATI\Repositories\Activity\ActivityRepository;
use App\IATI\Repositories\Document\DocumentRepository;
use App\IATI\Traits\XmlBaseElement;
use Auth;
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
     * @var DocumentRepository
     */
    protected DocumentRepository $documentRepository;

    /**
     * DocumentLinkService constructor.
     *
     * @param ActivityRepository          $activityRepository
     * @param ParentCollectionFormCreator $parentCollectionFormCreator
     */
    public function __construct(ActivityRepository $activityRepository, DocumentRepository $documentRepository, ParentCollectionFormCreator $parentCollectionFormCreator)
    {
        $this->activityRepository = $activityRepository;
        $this->documentRepository = $documentRepository;
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
    public function update($id, $documentLinks): bool
    {
        $organizationId = Auth::user()->organization->id;

        foreach ($documentLinks['document_link'] as $index => $documentLink) {
            $document = Arr::get($documentLink, 'document', null);

            if ($document) {
                $extension = pathinfo($document->getClientOriginalName(), PATHINFO_EXTENSION);
                $fileName = basename($document->getClientOriginalName(), ".$extension") . time() . '.' . $extension;

                $documentData['activity_id'] = null;
                $documentData['activities'] = [(int) $id];
                $documentData['organization_id'] = $organizationId;
                $documentData['filename'] = $fileName;
                $documentData['extension'] = $extension;
                $documentData['document_link'] = $documentLink;

                awsUploadFile("/document-link/$organizationId/" . $fileName, $document->get());
                $this->documentRepository->store($documentData);

                $documentLink['url'] = awsUrl("/document-link/$organizationId/" . $fileName);
            }

            unset($documentLink['document']);
            $documentLinks['document_link'][$index] = $documentLink;
        }

        $documentLinks = $this->sanitizeDocumentLinkData($documentLinks);

        $activity = $this->activityRepository->find($id);
        $deprecationStatusMap = $activity->deprecation_status_map;
        $deprecationStatusMap['document_link'] = doesDocumentLinkHaveDeprecatedCode($documentLinks);

        return $this->activityRepository->update($activity->id, [
            'document_link'          => $documentLinks,
            'deprecation_status_map' => $deprecationStatusMap,
        ]);
    }

    /**
     * Generates document link form.
     *
     * @param $id
     *
     * @return Form
     * @throws \JsonException
     */
    public function formGenerator($id, $activityDefaultFieldValues, $deprecationStatusMap = []): Form
    {
        $element = getElementSchema('document_link');
        $activity = $this->getActivityData($id);
        $documentLinks = $activity->document_link;

        if ($documentLinks) {
            foreach ($documentLinks as $index => $documentLink) {
                unset($documentLink['document']);
                $documentLinks[$index] = $documentLink;
            }
        }

        $model['document_link'] = $documentLinks;

        $this->parentCollectionFormCreator->url = route('admin.activity.document-link.update', [$id]);

        return $this->parentCollectionFormCreator->editForm($model, $element, 'PUT', '/activity/' . $id, $activityDefaultFieldValues, deprecationStatusMap: $deprecationStatusMap);
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
                        'url' => Arr::get($documentLink, 'url', null),
                        'format' => Arr::get($documentLink, 'format', null),
                    ],
                    'title' => [
                        'narrative' => $this->buildNarrative(Arr::get($documentLink, 'title.0.narrative', [])),
                    ],
                    'description' => [
                        'narrative' => $this->buildNarrative(Arr::get($documentLink, 'description.0.narrative', [])),
                    ],
                    'category' => $categories,

                    'language' => $languages,
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
