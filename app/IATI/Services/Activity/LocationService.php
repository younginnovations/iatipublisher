<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\ParentCollectionFormCreator;
use App\IATI\Repositories\Activity\ActivityRepository;
use Kris\LaravelFormBuilder\Form;

/**
 * Class LocationService.
 */
class LocationService
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
     * LocationService constructor.
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
     * Returns location of an activity.
     *
     * @param int $activity_id
     *
     * @return array|null
     */
    public function getLocationData(int $activity_id): ?array
    {
        return $this->activityRepository->find($activity_id)->location;
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
     * Updates activity location.
     *
     * @param $location
     * @param $activity
     *
     * @return bool
     */
    public function update($location, $activity): bool
    {
        return $this->activityRepository->update($activity->id, ['location' => $this->sanitizeLocationData($location)]);
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
        $model['location'] = $this->getLocationData($id) ?: [];
        $this->parentCollectionFormCreator->url = route('admin.activity.location.update', [$id]);

        return $this->parentCollectionFormCreator->editForm($model, $element['location'], 'PUT', '/activity/' . $id);
    }

    /**
     * Sanitizes location data.
     *
     * @param $location
     *
     * @return array
     */
    public function sanitizeLocationData($location): array
    {
        $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true)['location'];

        foreach ($location['location'] as $key => $location_value) {
            foreach (array_keys($element['sub_elements']) as $subelement) {
                $location['location'][$key][$subelement] = array_values($location_value[$subelement]);
            }
        }

        return array_values($location['location']);
    }
}
