<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\ParentCollectionFormCreator;
use App\IATI\Repositories\Activity\ActivityRepository;
use Kris\LaravelFormBuilder\Form;

/**
 * Class PolicyMarkerService.
 */
class PolicyMarkerService
{
    /**
     * @var ActivityRepository
     */
    protected ActivityRepository $activityRepository;

    /**
     * @var ParentCollectionFormCreator
     */
    protected ParentCollectionFormCreator $parentCollectionFormCreator;

    /**
     * PolicyMarkerService constructor.
     *
     * @param ActivityRepository $activityRepository
     * @param ParentCollectionFormCreator $parentCollectionFormCreator
     */
    public function __construct(ActivityRepository $activityRepository, ParentCollectionFormCreator $parentCollectionFormCreator)
    {
        $this->activityRepository = $activityRepository;
        $this->parentCollectionFormCreator = $parentCollectionFormCreator;
    }

    /**
     * Returns policy marker data of an activity.
     *
     * @param int $activity_id
     *
     * @return array|null
     */
    public function getPolicyMarkerData(int $activity_id): ?array
    {
        return $this->activityRepository->find($activity_id)->policy_marker;
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
     * Updates activity policy marker.
     *
     * @param $activityPolicyMarker
     * @param $activity
     *
     * @return bool
     */
    public function update($activityPolicyMarker, $activity): bool
    {
        return $this->activityRepository->update($activity->id, ['policy_marker' => $this->sanitizePolicyMarkerData($activityPolicyMarker)]);
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
        $model['policy_marker'] = $this->getPolicyMarkerData($id);
        $this->parentCollectionFormCreator->url = route('admin.activity.policy-marker.update', [$id]);

        return $this->parentCollectionFormCreator->editForm($model, $element['policy_marker'], 'PUT', '/activity/' . $id);
    }

    /**
     * Sanitizes policy marker data.
     *
     * @param $activityPolicyMarker
     *
     * @return array
     */
    public function sanitizePolicyMarkerData($activityPolicyMarker): array
    {
        foreach ($activityPolicyMarker['policy_marker'] as $key => $policy_marker) {
            $activityPolicyMarker['policy_marker'][$key]['narrative'] = array_values($policy_marker['narrative']);
        }

        return array_values($activityPolicyMarker['policy_marker']);
    }
}
