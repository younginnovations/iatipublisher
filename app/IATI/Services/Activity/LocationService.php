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
 * Class LocationService.
 */
class LocationService
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
     * LocationService constructor.
     *
     * @param ActivityRepository $activityRepository
     * @param ParentCollectionFormCreator $parentCollectionFormCreator
     */
    public function __construct(
        ActivityRepository $activityRepository,
        ParentCollectionFormCreator $parentCollectionFormCreator
    ) {
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
     * @param $id
     * @param $location
     *
     * @return bool
     */
    public function update($id, $location): bool
    {
        $location = $this->sanitizeLocationData($location);

        $activity = $this->activityRepository->find($id);
        $deprecationStatusMap = $activity->deprecation_status_map;
        $deprecationStatusMap['location'] = doesLocationHaveDeprecatedCode($location);

        return $this->activityRepository->update($activity->id, [
            'location'               => $location,
            'deprecation_status_map' => $deprecationStatusMap,
        ]);
    }

    /**
     * Generates budget form.
     *
     * @param $id
     *
     * @return Form
     * @throws \JsonException
     */
    public function formGenerator($id, $activityDefaultFieldValues, $deprecationStatusMap = []): Form
    {
        $element = getElementSchema('location');
        $model['location'] = $this->getLocationData($id) ?: [];
        $this->parentCollectionFormCreator->url = route('admin.activity.location.update', [$id]);

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
        $locations = (array) $activity->location;

        if (count($locations)) {
            foreach ($locations as $location) {
                $point = [];

                if ((Arr::get($location, 'point.0.pos.0.latitude', '') !== '') && (Arr::get(
                    $location,
                    'point.0.pos.0.longitude',
                    ''
                ) !== '')) {
                    $point = [
                        '@attributes' => [
                            'srsName' => Arr::get($location, 'point.0.srs_name', null),
                        ],
                        'pos'         => sprintf(
                            '%s %s',
                            Arr::get($location, 'point.0.pos.0.latitude', ''),
                            Arr::get($location, 'point.0.pos.0.longitude', '')
                        ),
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
                    'location-id'          => $this->getLocationIdValues(Arr::get($location, 'location_id', [])),
                    'name'                 => [
                        'narrative' => $this->buildNarrative(Arr::get($location, 'name.0.narrative', [])),
                    ],
                    'description'          => [
                        'narrative' => $this->buildNarrative(Arr::get($location, 'description.0.narrative', [])),
                    ],
                    'activity-description' => [
                        'narrative' => $this->buildNarrative(
                            Arr::get($location, 'activity_description.0.narrative', [])
                        ),
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

    /**
     * Sanitizes location data.
     *
     * @param $location
     *
     * @return array
     * @throws \JsonException
     */
    public function sanitizeLocationData($location): array
    {
        $element = getElementSchema('location');

        foreach ($location['location'] as $key => $location_value) {
            foreach (array_keys($element['sub_elements']) as $subelement) {
                $location['location'][$key][$subelement] = array_values($location_value[$subelement]);
            }
        }

        return array_values($location['location']);
    }

    /**
     * Returns array for location ids.
     *
     * @param $locationIds
     *
     * @return array
     */
    public function getLocationIdValues($locationIds): array
    {
        $array = [];

        foreach ($locationIds as $locationId) {
            $array[] = [
                '@attributes' => [
                    'code'       => Arr::get($locationId, 'code', null),
                    'vocabulary' => Arr::get($locationId, 'vocabulary', null),
                ],
            ];
        }

        return $array;
    }
}
