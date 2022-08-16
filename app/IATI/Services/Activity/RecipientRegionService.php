<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\ParentCollectionFormCreator;
use App\IATI\Models\Activity\Activity;
use App\IATI\Repositories\Activity\ActivityRepository;
use App\IATI\Traits\XmlBaseElement;
use Kris\LaravelFormBuilder\Form;

/**
 * Class RecipientRegionService.
 */
class RecipientRegionService
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
     * RecipientRegionService constructor.
     *
     * @param ActivityRepository          $activityRepository
     * @param ParentCollectionFormCreator $parentCollectionFormCreator
     */
    public function __construct(ActivityRepository $activityRepository, ParentCollectionFormCreator $parentCollectionFormCreator)
    {
        $this->activityRepository          = $activityRepository;
        $this->parentCollectionFormCreator = $parentCollectionFormCreator;
    }

    /**
     * Returns recipient region data of an activity.
     *
     * @param int $activity_id
     *
     * @return array|null
     */
    public function getRecipientRegionData(int $activity_id): ?array
    {
        return $this->activityRepository->find($activity_id)->recipient_region;
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
     * Updates activity recipient region.
     *
     * @param $id
     * @param $activityRecipientRegion
     *
     * @return bool
     */
    public function update($id, $activityRecipientRegion): bool
    {
        return $this->activityRepository->update($id, ['recipient_region' => $this->sanitizeRecipientRegionData($activityRecipientRegion)]);
    }

    /**
     * Generates budget form.
     *
     * @param $id
     *
     * @return Form
     * @throws \JsonException
     */
    public function formGenerator($id): Form
    {
        $element                                = getElementSchema('recipient_region');
        $model['recipient_region']              = $this->getRecipientRegionData($id);
        $this->parentCollectionFormCreator->url = route('admin.activity.recipient-region.update', [$id]);

        return $this->parentCollectionFormCreator->editForm($model, $element, 'PUT', '/activity/'.$id);
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
        $activityData     = [];
        $recipientRegions = (array)$activity->recipient_region;

        if (count($recipientRegions)) {
            foreach ($recipientRegions as $recipientRegion) {
                $vocabulary = Arr::get($recipientRegion, 'region_vocabulary', null);

                switch ($vocabulary) {
                    case '1':
                        $code = Arr::get($recipientRegion, 'region_code', null);
                        break;

                    case '2':
                    case '99':
                        $code = Arr::get($recipientRegion, 'custom_code', null);
                        break;

                    default:
                        $code = Arr::get($recipientRegion, 'custom_code', null);
                }

                $activityData[] = [
                    '@attributes' => [
                        'code'           => $code,
                        'percentage'     => Arr::get($recipientRegion, 'percentage', null),
                        'vocabulary'     => $vocabulary,
                        'vocabulary-uri' => Arr::get($recipientRegion, 'vocabulary_uri', null),
                    ],
                    'narrative'   => $this->buildNarrative(Arr::get($recipientRegion, 'narrative', [])),
                ];
            }
        }

        return $activityData;
    }

    /**
     * Sanitizes recipient region data.
     *
     * @param $activityRecipientRegion
     *
     * @return array
     */
    public function sanitizeRecipientRegionData($activityRecipientRegion): array
    {
        foreach ($activityRecipientRegion['recipient_region'] as $key => $recipient_region) {
            $activityRecipientRegion['recipient_region'][$key]['narrative'] = array_values($recipient_region['narrative']);
        }

        return array_values($activityRecipientRegion['recipient_region']);
    }
}
