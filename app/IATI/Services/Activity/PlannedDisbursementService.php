<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\ParentCollectionFormCreator;
use App\IATI\Repositories\Activity\ActivityRepository;
use Kris\LaravelFormBuilder\Form;

/**
 * Class planned$plannedDisbursementService.
 */
class PlannedDisbursementService
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
     * @param $plannedDisbursement
     * @param $activity
     *
     * @return bool
     */
    public function update($plannedDisbursement, $activity): bool
    {
        return $this->activityRepository->update($activity->id, ['planned_disbursement' => $this->sanitizePlannedDisbursementData($plannedDisbursement)]);
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
        $this->parentCollectionFormCreator->url = route('admin.activity.planned-disbursement.update', [$id]);

        return $this->parentCollectionFormCreator->editForm($model, $element['planned_disbursement'], 'PUT', '/activity/' . $id);
    }

    /**
     * Sanitizes planned disbursement data.
     *
     * @param $plannedDisbursement
     *
     * @return array
     */
    public function sanitizePlannedDisbursementData($plannedDisbursement): array
    {
        $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true)['planned_disbursement'];

        foreach ($plannedDisbursement['planned_disbursement'] as $key => $disbursement) {
            foreach (array_keys($element['sub_elements']) as $subelement) {
                $plannedDisbursement['planned_disbursement'][$key][$subelement] = array_values($disbursement[$subelement]);
            }
        }

        return array_values($plannedDisbursement['planned_disbursement']);
    }
}
