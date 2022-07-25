<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\ParentCollectionFormCreator;
use App\IATI\Repositories\Activity\LocationRepository;
use Illuminate\Database\Eloquent\Model;
use Kris\LaravelFormBuilder\Form;

/**
 * Class LocationService.
 */
class LocationService
{
    /**
     * @var LocationRepository
     */
    protected LocationRepository $locationRepository;

    /**
     * @var ParentCollectionFormCreator
     */
    protected ParentCollectionFormCreator $parentCollectionFormCreator;

    /**
     * LocationService constructor.
     *
     * @param LocationRepository $locationRepository
     * @param ParentCollectionFormCreator $parentCollectionFormCreator
     */
    public function __construct(LocationRepository $locationRepository, ParentCollectionFormCreator $parentCollectionFormCreator)
    {
        $this->locationRepository = $locationRepository;
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
        return $this->locationRepository->getLocationData($activity_id);
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
        return $this->locationRepository->getActivityData($id);
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
        return $this->locationRepository->update($location, $activity);
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
        $this->parentCollectionFormCreator->url = route('admin.activities.location.update', [$id]);

        return $this->parentCollectionFormCreator->editForm($model, $element['location'], 'PUT', '/activities/' . $id);
    }
}
