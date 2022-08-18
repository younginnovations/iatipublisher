<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\BaseFormCreator;
use App\IATI\Repositories\Activity\ActivityRepository;
use Illuminate\Database\Eloquent\Model;
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
    public function getCapitalSpendData(float $activity_id): ?float
    {
        return $this->activityRepository->find($activity_id)->capital_spend;
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
        return $this->activityRepository->find($id);
    }

    /**
     * Updates activity capital spend data.
     *
     * @param $id
     * @param $activity
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
     * @param id
     *
     * @return Form
     */
    public function formGenerator($id): Form
    {
        $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
        $model['capital_spend'] = $this->getCapitalSpendData($id);
        $this->baseFormCreator->url = route('admin.activity.capital-spend.update', [$id]);

        return $this->baseFormCreator->editForm($model, $element['capital_spend'], 'PUT', '/activity/' . $id);
    }
}
