<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\BaseFormCreator;
use App\IATI\Models\Activity\Activity;
use App\IATI\Repositories\Activity\ActivityRepository;
use Illuminate\Support\Arr;
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
     * @param BaseFormCreator    $baseFormCreator
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
     * @param $id
     * @param $activityRelatedActivity
     *
     * @return bool
     */
    public function update($id, $activityRelatedActivity): bool
    {
        $activityRelatedActivity = array_values($activityRelatedActivity['related_activity']);
        $activity = $this->activityRepository->find($id);
        $deprecationStatusMap = $activity->deprecation_status_map;
        $deprecationStatusMap['related_activity'] = doesRelatedActivityHaveDeprecatedCode($activityRelatedActivity);

        return $this->activityRepository->update($id, [
            'related_activity'       => $activityRelatedActivity,
            'deprecation_status_map' => $deprecationStatusMap,
        ]);
    }

    /**
     * Generates related activity form.
     *
     * @param $id
     *
     * @return Form
     * @throws \JsonException
     */
    public function formGenerator($id, $deprecationStatusMap = []): Form
    {
        $element = getElementSchema('related_activity');
        $model['related_activity'] = $this->getRelatedActivityData($id);
        $this->baseFormCreator->url = route('admin.activity.related-activity.update', [$id]);

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
        $relatedActivities = (array) $activity->related_activity;

        if (count($relatedActivities)) {
            foreach ($relatedActivities as $relatedActivity) {
                $activityData[] = [
                    '@attributes' => [
                        'ref'  => Arr::get($relatedActivity, 'activity_identifier', null),
                        'type' => Arr::get($relatedActivity, 'relationship_type', null),
                    ],
                ];
            }
        }

        return $activityData;
    }
}
