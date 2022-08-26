<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\ParentCollectionFormCreator;
use App\IATI\Models\Activity\Activity;
use App\IATI\Repositories\Activity\PlannedDisbursementRepository;
use App\IATI\Traits\XmlBaseElement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Kris\LaravelFormBuilder\Form;

/**
 * Class planned$plannedDisbursementService.
 */
class PlannedDisbursementService
{
    use XmlBaseElement;

    /**
     * @var PlannedDisbursementRepository
     */
    protected PlannedDisbursementRepository $plannedDisbursementRepo;

    /**
     * @var ParentCollectionFormCreator
     */
    protected ParentCollectionFormCreator $parentCollectionFormCreator;

    /**
     * PlannedDisbursementService constructor.
     *
     * @param PlannedDisbursementRepository $plannedDisbursementRepo
     * @param ParentCollectionFormCreator $parentCollectionFormCreator
     */
    public function __construct(PlannedDisbursementRepository $plannedDisbursementRepo, ParentCollectionFormCreator $parentCollectionFormCreator)
    {
        $this->plannedDisbursementRepository = $plannedDisbursementRepo;
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
        return $this->plannedDisbursementRepository->getPlannedDisbursementData($activity_id);
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
        return $this->plannedDisbursementRepository->getActivityData($id);
    }

    /**
     * Updates activity planned disbursement.
     *
     * @param $plannedDisbursement
     * @param $activity
     *
     * @return bool
     */
    public function update($plannedDisbursement, $activity): bool
    {
        return $this->plannedDisbursementRepository->update($plannedDisbursement, $activity);
    }

    /**
     * Generates planned disbursement form.
     *
     * @param id
     *
     * @return Form
     */
    public function formGenerator($id): Form
    {
        $element = getElementSchema('planned_disbursement');
        $model['planned_disbursement'] = $this->getPlannedDisbursementData($id) ?: [];
        $this->parentCollectionFormCreator->url = route('admin.activities.planned-disbursement.update', [$id]);

        return $this->parentCollectionFormCreator->editForm($model, $element, 'PUT', '/activities/' . $id);
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
                        'iso-date' => Arr::get($plannedDisbursement, 'period_start.0.iso_date', null),
                    ],
                ],
                'period-end'   => [
                    '@attributes' => [
                        'iso-date' => Arr::get($plannedDisbursement, 'period_end.0.iso_date', null),
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
                        'receiver-activity-id' => Arr::get($plannedDisbursement, 'receiver_org.0.provider_activity_id', null),
                        'type'                 => Arr::get($plannedDisbursement, 'receiver_org.0.type', null),
                    ],
                    'narrative'   => $this->buildNarrative(Arr::get($plannedDisbursement, 'receiver_org.0.narrative', [])),
                ],
            ];
        }

        return $activityData;
    }
}
