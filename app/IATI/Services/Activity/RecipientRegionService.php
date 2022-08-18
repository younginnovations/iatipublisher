<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\ParentCollectionFormCreator;
use App\IATI\Repositories\Activity\ActivityRepository;
use Kris\LaravelFormBuilder\Form;

/**
 * Class RecipientRegionService.
 */
class RecipientRegionService
{
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
     * @param ActivityRepository $activityRepository
     * @param ParentCollectionFormCreator $parentCollectionFormCreator
     */
    public function __construct(ActivityRepository $activityRepository, ParentCollectionFormCreator $parentCollectionFormCreator)
    {
        $this->activityRepository = $activityRepository;
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
     * @param $activityRecipientRegion
     * @param $activity
     *
     * @return bool
     */
    public function update($activityRecipientRegion, $activity): bool
    {
        return $this->activityRepository->update($activity->id, ['recipient_region' => $this->sanitizeRecipientRegionData($activityRecipientRegion)]);
    }

    /**
     * Generates budget form.
     *
     * @param id
     *
     * @return Form
     */
    public function formGenerator($id): Form
    {
        $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
        $model['recipient_region'] = $this->getRecipientRegionData($id);
        $this->parentCollectionFormCreator->url = route('admin.activity.recipient-region.update', [$id]);

        return $this->parentCollectionFormCreator->editForm($model, $element['recipient_region'], 'PUT', '/activity/' . $id);
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
