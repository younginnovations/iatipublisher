<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\BaseFormCreator;
use App\IATI\Repositories\Activity\ActivityRepository;
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
     * @param BaseFormCreator $baseFormCreator
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
     * @param $activityLegacy
     * @param $activity
     *
     * @return bool
     */
    public function update($activityLegacy, $activity): bool
    {
        return $this->activityRepository->update($activity->id, ['legacy_data' => array_values($activityLegacy['legacy_data'])]);
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
        $model['legacy_data'] = $this->getActivityLegacyData($id);
        $this->baseFormCreator->url = route('admin.activity.legacy-data.update', [$id]);

        return $this->baseFormCreator->editForm($model, $element['legacy_data'], 'PUT', '/activity/' . $id);
    }
}
