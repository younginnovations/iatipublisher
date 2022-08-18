<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\BaseFormCreator;
use App\IATI\Repositories\Activity\ActivityRepository;
use Kris\LaravelFormBuilder\Form;

/**
 * Class StatusService.
 */
class StatusService
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
     * StatusService constructor.
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
     * Returns status data of an activity.
     *
     * @param int $activity_id
     *
     * @return int|null
     */
    public function getStatusData(int $activity_id): ?int
    {
        return $this->activityRepository->find($activity_id)->activity_status;
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
     * Updates activity status.
     *
     * @param $activityStatus
     * @param $activity
     *
     * @return bool
     */
    public function update($activityStatus, $activity): bool
    {
        return $this->activityRepository->update($activity->id, ['activity_status' => $activityStatus]);
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
        $model['activity_status'] = $this->getStatusData($id);
        $this->baseFormCreator->url = route('admin.activity.status.update', [$id]);

        return $this->baseFormCreator->editForm($model, $element['activity_status'], 'PUT', '/activity/' . $id);
    }
}
