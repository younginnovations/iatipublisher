<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\BaseFormCreator;
use App\IATI\Models\Activity\Activity;
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
     * @param BaseFormCreator    $baseFormCreator
     */
    public function __construct(ActivityRepository $activityRepository, BaseFormCreator $baseFormCreator)
    {
        $this->activityRepository = $activityRepository;
        $this->baseFormCreator    = $baseFormCreator;
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
     * @param $id
     * @param $activityStatus
     *
     * @return bool
     */
    public function update($id, $activityStatus): bool
    {
        return $this->activityRepository->update($id, ['activity_status' => $activityStatus]);
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
        $element                    = getElementSchema('activity_status');
        $model['activity_status']   = $this->getStatusData($id);
        $this->baseFormCreator->url = route('admin.activity.status.update', [$id]);

        return $this->baseFormCreator->editForm($model, $element, 'PUT', '/activity/'.$id);
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

        if ($activity->activity_status) {
            $activityData = [
                '@attributes' => [
                    'code' => $activity->activity_status,
                ],
            ];
        }

        return $activityData;
    }
}
