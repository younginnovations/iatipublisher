<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\ParentCollectionFormCreator;
use App\IATI\Models\Activity\Activity;
use App\IATI\Repositories\Activity\ActivityRepository;
use App\IATI\Traits\XmlBaseElement;
use Illuminate\Support\Arr;
use Kris\LaravelFormBuilder\Form;

/**
 * Class PolicyMarkerService.
 */
class PolicyMarkerService
{
    use XmlBaseElement;

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
     * @param $id
     * @param $activityPolicyMarker
     *
     * @return bool
     */
    public function update($id, $activityPolicyMarker): bool
    {
        $activityPolicyMarker = $this->sanitizePolicyMarkerData($activityPolicyMarker);

        $activity = $this->activityRepository->find($id);
        $deprecationStatusMap = $activity->deprecation_status_map;

        $deprecationStatusMap['policy_marker'] = doesPolicyMarkerHaveDeprecatedCode($activityPolicyMarker);

        return $this->activityRepository->update($id, [
            'policy_marker'          => $activityPolicyMarker,
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
    public function formGenerator($id, $activityDefaultFieldValues, $deprecationStatusMap = []): Form
    {
        $element = getElementSchema('policy_marker');
        $model['policy_marker'] = $this->getPolicyMarkerData($id);
        $this->parentCollectionFormCreator->url = route('admin.activity.policy-marker.update', [$id]);

        return $this->parentCollectionFormCreator->editForm($model, $element, 'PUT', '/activity/' . $id, $activityDefaultFieldValues, deprecationStatusMap: $deprecationStatusMap);
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
        $policyMarkers = (array) $activity->policy_marker;

        if (count($policyMarkers)) {
            foreach ($policyMarkers as $policyMarker) {
                $vocabulary = Arr::get($policyMarker, 'policy_marker_vocabulary', null);

                switch ($vocabulary) {
                    case '99':
                        $code = Arr::get($policyMarker, 'policy_marker_text', null);
                        break;
                    default:
                        $code = Arr::get($policyMarker, 'policy_marker', null);
                        break;
                }

                $activityData[] = [
                    '@attributes' => [
                        'vocabulary'     => $vocabulary,
                        'vocabulary-uri' => Arr::get($policyMarker, 'vocabulary_uri', null),
                        'code'           => $code,
                        'significance'   => Arr::get($policyMarker, 'significance', null),
                    ],
                    'narrative'   => $this->buildNarrative(Arr::get($policyMarker, 'narrative', [])),
                ];
            }
        }

        return $activityData;
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
