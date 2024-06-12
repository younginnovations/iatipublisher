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
 * Class planned$plannedDisbursementService.
 */
class PlannedDisbursementService
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
     * PlannedDisbursementService constructor.
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
     * Returns planned disbursement data of an activity.
     *
     * @param int $activity_id
     *
     * @return array|null
     */
    public function getPlannedDisbursementData(int $activity_id): ?array
    {
        return $this->activityRepository->find($activity_id)->planned_disbursement;
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
     * Updates activity planned disbursement.
     *
     * @param $id
     * @param $plannedDisbursement
     *
     * @return bool
     * @throws \JsonException
     */
    public function update($id, $plannedDisbursement): bool
    {
        $plannedDisbursement = $this->sanitizePlannedDisbursementData($plannedDisbursement);

        $activity = $this->activityRepository->find($id);
        $deprecationStatusMap = $activity->deprecation_status_map;

        $deprecationStatusMap['planned_disbursement'] = doesPlannedDisbursementHaveDeprecatedCode($plannedDisbursement);

        return $this->activityRepository->update($id, [
            'planned_disbursement'   => $plannedDisbursement,
            'deprecation_status_map' => $deprecationStatusMap,
        ]);
    }

    /**
     * Generates planned disbursement form.
     *
     * @param $id
     *
     * @return Form
     * @throws \JsonException
     */
    public function formGenerator($id, $activityDefaultFieldValues, $deprecationStatusMap = []): Form
    {
        $element = getElementSchema('planned_disbursement');
        $model['planned_disbursement'] = $this->getPlannedDisbursementData($id) ?: [];
        $this->parentCollectionFormCreator->url = route('admin.activity.planned-disbursement.update', [$id]);

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
        $plannedDisbursements = (array) $activity->planned_disbursement;

        foreach ($plannedDisbursements as $plannedDisbursement) {
            $activityData[] = [
                '@attributes'  => [
                    'type' => Arr::get($plannedDisbursement, 'planned_disbursement_type', null),
                ],
                'period-start' => [
                    '@attributes' => [
                        'iso-date' => Arr::get($plannedDisbursement, 'period_start.0.date', null),
                    ],
                ],
                'period-end'   => [
                    '@attributes' => [
                        'iso-date' => Arr::get($plannedDisbursement, 'period_end.0.date', null),
                    ],
                ],
                'value'        => [
                    '@attributes' => [
                        'currency'   => Arr::get($plannedDisbursement, 'value.0.currency', null),
                        'value-date' => Arr::get($plannedDisbursement, 'value.0.value_date', null),
                    ],
                    '@value'      => Arr::get($plannedDisbursement, 'value.0.amount', null),
                ],
                'provider-org' => [
                    '@attributes' => [
                        'ref'                  => Arr::get($plannedDisbursement, 'provider_org.0.ref', null),
                        'provider-activity-id' => Arr::get($plannedDisbursement, 'provider_org.0.provider_activity_id', null),
                        'type'                 => Arr::get($plannedDisbursement, 'provider_org.0.type', null),
                    ],
                    'narrative'   => $this->buildNarrative(Arr::get($plannedDisbursement, 'provider_org.0.narrative', [])),
                ],
                'receiver-org' => [
                    '@attributes' => [
                        'ref'                  => Arr::get($plannedDisbursement, 'receiver_org.0.ref', null),
                        'receiver-activity-id' => Arr::get($plannedDisbursement, 'receiver_org.0.receiver_activity_id', null),
                        'type'                 => Arr::get($plannedDisbursement, 'receiver_org.0.type', null),
                    ],
                    'narrative'   => $this->buildNarrative(Arr::get($plannedDisbursement, 'receiver_org.0.narrative', [])),
                ],
            ];
        }

        return $activityData;
    }

    /**
     * Sanitizes planned disbursement data.
     *
     * @param $plannedDisbursement
     *
     * @return array
     * @throws \JsonException
     */
    public function sanitizePlannedDisbursementData($plannedDisbursement): array
    {
        $element = getElementSchema('planned_disbursement');

        foreach ($plannedDisbursement['planned_disbursement'] as $key => $disbursement) {
            foreach (array_keys($element['sub_elements']) as $subElement) {
                $plannedDisbursement['planned_disbursement'][$key][$subElement] = array_values($disbursement[$subElement]);
            }
        }

        return array_values($plannedDisbursement['planned_disbursement']);
    }
}
