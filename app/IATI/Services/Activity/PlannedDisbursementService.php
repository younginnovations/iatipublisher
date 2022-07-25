<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\ParentCollectionFormCreator;
use App\IATI\Repositories\Activity\PlannedDisbursementRepository;
use Illuminate\Database\Eloquent\Model;
use Kris\LaravelFormBuilder\Form;

/**
 * Class planned$plannedDisbursementService.
 */
class PlannedDisbursementService
{
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
        $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
        $model['planned_disbursement'] = $this->getPlannedDisbursementData($id) ?: [];
        $this->parentCollectionFormCreator->url = route('admin.activities.planned-disbursement.update', [$id]);

        return $this->parentCollectionFormCreator->editForm($model, $element['planned_disbursement'], 'PUT', '/activities/' . $id);
    }
}
