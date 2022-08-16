<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\BaseFormCreator;
use App\IATI\Models\Activity\Activity;
use App\IATI\Repositories\Activity\ActivityRepository;
use Kris\LaravelFormBuilder\Form;

/**
 * Class DefaultTiedStatusService.
 */
class DefaultTiedStatusService
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
     * DefaultTiedStatusService constructor.
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
     * Returns default tied status data of an activity.
     *
     * @param int $activity_id
     *
     * @return int|null
     */
    public function getDefaultTiedStatusData(int $activity_id): ?int
    {
        return $this->activityRepository->find($activity_id)->default_tied_status;
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
     * Updates activity default tied status data.
     *
     * @param $id
     * @param $activityDefaultTiedStatus
     *
     * @return bool
     */
    public function update($id, $activityDefaultTiedStatus): bool
    {
        return $this->activityRepository->update($id, ['default_tied_status' => $activityDefaultTiedStatus]);
    }

    /**
     * Generates default tied status form.
     *
     * @param $id
     *
     * @return Form
     * @throws \JsonException
     */
    public function formGenerator($id): Form
    {
        $element = getElementSchema('default_tied_status');
        $model['default_tied_status'] = $this->getDefaultTiedStatusData($id);
        $this->baseFormCreator->url = route('admin.activity.default-tied-status.update', [$id]);

        return $this->baseFormCreator->editForm($model, $element, 'PUT', '/activity/' . $id);
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

        if ($activity->default_tied_status) {
            $activityData = [
                '@attributes' => [
                    'code' => $activity->default_tied_status,
                ],
            ];
        }

        return $activityData;
    }
}
