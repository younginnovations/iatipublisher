<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\BaseFormCreator;
use App\IATI\Models\Activity\Activity;
use App\IATI\Repositories\Activity\ActivityRepository;
use Kris\LaravelFormBuilder\Form;

/**
 * Class ScopeService.
 */
class ScopeService
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
     * ScopeService constructor.
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
     * Returns scope data of an activity.
     *
     * @param int $activity_id
     *
     * @return int|null
     */
    public function getScopeData(int $activity_id): ?int
    {
        return $this->activityRepository->find($activity_id)->activity_scope;
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
     * Updates activity scope.
     *
     * @param $id
     * @param $activityScope
     *
     * @return bool
     */
    public function update($id, $activityScope): bool
    {
        return $this->activityRepository->update($id, ['activity_scope' => $activityScope]);
    }

    /**
     * Generates scope form.
     *
     * @param $id
     *
     * @return Form
     * @throws \JsonException
     */
    public function formGenerator($id): Form
    {
        $element                    = getElementSchema('activity_scope');
        $model['activity_scope']    = $this->getScopeData($id);
        $this->baseFormCreator->url = route('admin.activity.scope.update', [$id]);

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

        if ($activity->activity_scope) {
            $activityData = [
                '@attributes' => [
                    'code' => $activity->activity_scope,
                ],
            ];
        }

        return $activityData;
    }
}
