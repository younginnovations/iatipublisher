<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\BaseFormCreator;
use App\IATI\Models\Activity\Activity;
use App\IATI\Repositories\Activity\ActivityRepository;
use Illuminate\Support\Arr;
use Kris\LaravelFormBuilder\Form;

/**
 * Class LegacyDataService.
 */
class LegacyDataService
{
    /**
     * @var ActivityRepository
     */
    protected ActivityRepository $activityRepository;

    /**
     * @var BaseFormCreator
     */
    protected BaseFormCreator $baseFormCreator;

    /**
     * LegacyDataService constructor.
     *
     * @param ActivityRepository $activityRepository
     * @param BaseFormCreator    $baseFormCreator
     */
    public function __construct(ActivityRepository $activityRepository, BaseFormCreator $baseFormCreator)
    {
        $this->activityRepository = $activityRepository;
        $this->baseFormCreator = $baseFormCreator;
    }

    /**
     * Returns legacy data of an activity.
     *
     * @param int $activity_id
     *
     * @return array|null
     */
    public function getActivityLegacyData(int $activity_id): ?array
    {
        return $this->activityRepository->find($activity_id)->legacy_data;
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
     * Updates activity legacy.
     *
     * @param $id
     * @param $activityLegacy
     *
     * @return bool
     */
    public function update($id, $activityLegacy): bool
    {
        $activity = $this->activityRepository->find($id);
        $deprecationStatusMap = $activity->deprecation_status_map;
        $deprecationStatusMap['legacy_data'] = doesLegacyDataHaveDeprecatedCode($activityLegacy);

        return $this->activityRepository->update($activity->id, [
            'legacy_data'            => array_values($activityLegacy['legacy_data']),
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
    public function formGenerator($id, $deprecationStatusMap = []): Form
    {
        $element = getElementSchema('legacy_data');
        $model['legacy_data'] = $this->getActivityLegacyData($id);
        $this->baseFormCreator->url = route('admin.activity.legacy-data.update', [$id]);

        return $this->baseFormCreator->editForm($model, $element, 'PUT', '/activity/' . $id, deprecationStatusMap: $deprecationStatusMap);
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
        $legacyData = (array) $activity->legacy_data;

        if (count($legacyData)) {
            foreach ($legacyData as $legacyDatum) {
                $activityData[] = [
                    '@attributes' => [
                        'name'            => Arr::get($legacyDatum, 'legacy_name', null),
                        'value'           => Arr::get($legacyDatum, 'value', null),
                        'iati-equivalent' => Arr::get($legacyDatum, 'iati_equivalent', null),
                    ],
                ];
            }
        }

        return $activityData;
    }
}
