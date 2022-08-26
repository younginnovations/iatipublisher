<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\ParentCollectionFormCreator;
use App\IATI\Models\Activity\Activity;
use App\IATI\Repositories\Activity\LocationRepository;
use App\IATI\Traits\XmlBaseElement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Kris\LaravelFormBuilder\Form;

/**
 * Class LocationService.
 */
class LocationService
{
    use XmlBaseElement;

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
        $element = getElementSchema('location');
        $model['location'] = $this->getLocationData($id) ?: [];
        $this->parentCollectionFormCreator->url = route('admin.activities.location.update', [$id]);

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
        $locations = (array) $activity->location;

        if (count($locations)) {
            foreach ($locations as $location) {
                $point = [];

                if ((Arr::get($location, 'point.0.pos.0.latitude', '') != '') && (Arr::get($location, 'point.0.pos.0.longitude', '') != '')) {
                    $point = [
                        '@attributes' => [
                            'srsName' => Arr::get($location, 'point.0.srs_name', null),
                        ],
                        'pos'         => sprintf('%s %s', Arr::get($location, 'point.0.pos.0.latitude', ''), Arr::get($location, 'point.0.pos.0.longitude', '')),
                    ];
                }

                $activityData[] = [
                    '@attributes'          => [
                        'ref' => Arr::get($location, 'ref', null),
                    ],
                    'location-reach'       => [
                        '@attributes' => [
                            'code' => Arr::get($location, 'location_reach.0.code', null),
                        ],
                    ],
                    'location-id'          => [
                        '@attributes' => [
                            'code'       => Arr::get($location, 'location_id.0.code', null),
                            'vocabulary' => Arr::get($location, 'location_id.0.vocabulary', null),
                        ],
                    ],
                    'name'                 => [
                        'narrative' => $this->buildNarrative(Arr::get($location, 'name.0.narrative', [])),
                    ],
                    'description'          => [
                        'narrative' => $this->buildNarrative(Arr::get($location, 'description.0.narrative', [])),
                    ],
                    'activity-description' => [
                        'narrative' => $this->buildNarrative(Arr::get($location, 'activity_description.0.narrative', [])),
                    ],
                    'administrative'       => [
                        '@attributes' => [
                            'code'       => Arr::get($location, 'administrative.0.code', null),
                            'vocabulary' => Arr::get($location, 'administrative.0.vocabulary', null),
                            'level'      => Arr::get($location, 'administrative.0.level', null),
                        ],
                    ],
                    'point'                => $point,
                    'exactness'            => [
                        '@attributes' => [
                            'code' => Arr::get($location, 'exactness.0.code', null),
                        ],
                    ],
                    'location-class'       => [
                        '@attributes' => [
                            'code' => Arr::get($location, 'location_class.0.code', null),
                        ],
                    ],
                    'feature-designation'  => [
                        '@attributes' => [
                            'code' => Arr::get($location, 'feature_designation.0.code', null),
                        ],
                    ],
                ];
            }
        }

        return $activityData;
    }
}
