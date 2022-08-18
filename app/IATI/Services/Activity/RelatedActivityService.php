<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\BaseFormCreator;
use App\IATI\Repositories\Activity\ActivityRepository;
use Kris\LaravelFormBuilder\Form;

/**
 * Class RelatedActivityService.
 */
class RelatedActivityService
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
     * RelatedActivityService constructor.
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
     * Returns related activity data of an activity.
     *
     * @param int $activity_id
     *
     * @return array|null
     */
    public function getRelatedActivityData(int $activity_id): ?array
    {
        return $this->activityRepository->find($activity_id)->related_activity;
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
     * Updates activity related activity.
     *
     * @param $activityRelatedActivity
     * @param $activity
     *
     * @return bool
     */
    public function update($activityRelatedActivity, $activity): bool
    {
        return $this->activityRepository->update($activity->id, ['related_activity' => array_values($activityRelatedActivity['related_activity'])]);
    }

    /**
     * Generates related activity form.
     *
     * @param id
     *
     * @return Form
     */
    public function formGenerator($id): Form
    {
        $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
        $model['related_activity'] = $this->getRelatedActivityData($id);
        $this->baseFormCreator->url = route('admin.activity.related-activity.update', [$id]);

        return $this->baseFormCreator->editForm($model, $element['related_activity'], 'PUT', '/activity/' . $id);
    }
}
