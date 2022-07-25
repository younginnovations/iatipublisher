<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\ParentCollectionFormCreator;
use App\IATI\Repositories\Activity\PolicyMarkerRepository;
use Illuminate\Database\Eloquent\Model;
use Kris\LaravelFormBuilder\Form;

/**
 * Class PolicyMarkerService.
 */
class PolicyMarkerService
{
    /**
     * @var PolicyMarkerRepository
     */
    protected PolicyMarkerRepository $policyMarkerRepository;

    /**
     * @var ParentCollectionFormCreator
     */
    protected ParentCollectionFormCreator $parentCollectionFormCreator;

    /**
     * PolicyMarkerService constructor.
     *
     * @param PolicyMarkerRepository $policyMarkerRepository
     * @param ParentCollectionFormCreator $parentCollectionFormCreator
     */
    public function __construct(PolicyMarkerRepository $policyMarkerRepository, ParentCollectionFormCreator $parentCollectionFormCreator)
    {
        $this->policyMarkerRepository = $policyMarkerRepository;
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
        return $this->policyMarkerRepository->getPolicyMarkerData($activity_id);
    }

    /**
     * Returns activity object.
     *
     * @param $id
     *
     * @return Model
     */
    public function getActivityData($id): Model
    {
        return $this->policyMarkerRepository->getActivityData($id);
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
        return $this->policyMarkerRepository->update($activityPolicyMarker, $activity);
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
        $this->parentCollectionFormCreator->url = route('admin.activities.policy-marker.update', [$id]);

        return $this->parentCollectionFormCreator->editForm($model, $element['policy_marker'], 'PUT', '/activities/' . $id);
    }
}
