<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\ParentCollectionFormCreator;
use App\IATI\Models\Activity\Activity;
use App\IATI\Repositories\Activity\PolicyMarkerRepository;
use App\IATI\Traits\XmlBaseElement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Kris\LaravelFormBuilder\Form;

/**
 * Class PolicyMarkerService.
 */
class PolicyMarkerService
{
    use XmlBaseElement;

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
                $vocabulary = Arr::get($policyMarker, 'policymarker_vocabulary', null);

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
}
