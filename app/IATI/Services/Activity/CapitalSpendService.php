<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\BaseFormCreator;
use App\IATI\Models\Activity\Activity;
use App\IATI\Repositories\Activity\ActivityRepository;
use Kris\LaravelFormBuilder\Form;

/**
 * Class CapitalSpendService.
 */
class CapitalSpendService
{
    /**
     * @var BaseFormCreator
     */
    protected BaseFormCreator $baseFormCreator;

    /**
     * @var ActivityRepository
     */
    protected ActivityRepository $activityRepository;

    /**
     * CapitalSpendService constructor.
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
     * Returns capital spend data of an activity.
     *
     * @param int $activity_id
     *
     * @return float|null
     */
    public function getCapitalSpendData(int $activity_id): ?float
    {
        return $this->activityRepository->find($activity_id)->capital_spend;
    }

    /**
     * Returns activity object.
     *
     * @param $id
     *
     * @return object
     */
    public function getActivityData($id): Object
    {
        return $this->activityRepository->find($id);
    }

    /**
     * Updates activity capital spend data.
     *
     * @param $id
     * @param $activityCapitalSpend
     *
     * @return bool
     */
    public function update($id, $activityCapitalSpend): bool
    {
        return $this->activityRepository->update($id, ['capital_spend' => $activityCapitalSpend]);
    }

    /**
     * Generates capital spend form.
     *
     * @param $id
     *
     * @return Form
     * @throws \JsonException
     */
    public function formGenerator($id): Form
    {
        $element = getElementSchema('capital_spend');
        $model['capital_spend'] = $this->getCapitalSpendData($id);
        $this->baseFormCreator->url = route('admin.activity.capital-spend.update', [$id]);

        return $this->baseFormCreator->editForm($model, $element, 'PUT', '/activity/' . $id);
    }

    /**
     * Returns data in required xml array format.
     *
     *
     * @param Activity $activity
     *
     * @return array
     */
    public function getXmlData(Activity $activity): array
    {
        $activityData = [];

        if ($activity->capital_spend) {
            $activityData = [
                '@attributes' => [
                    'percentage' => $activity->capital_spend,
                ],
            ];
        }

        return $activityData;
    }
}
