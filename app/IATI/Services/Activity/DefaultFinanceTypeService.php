<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\BaseFormCreator;
use App\IATI\Repositories\Activity\ActivityRepository;
use Illuminate\Database\Eloquent\Model;
use Kris\LaravelFormBuilder\Form;

/**
 * Class DefaultFinanceTypeService.
 */
class DefaultFinanceTypeService
{
    /**
     * @var ActivityRepository
     */
    protected ActivityRepository $activityRepository;

    /**
     * @var BaseFormCreator
     */
    protected BaseFormCreator $baseFormCreator;

    /**
     * DefaultFinanceTypeService constructor.
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
     * Returns default finance type data of an activity.
     *
     * @param int $activity_id
     *
     * @return int|null
     */
    public function getDefaultFinanceTypeData(int $activity_id): ?int
    {
        return $this->activityRepository->find($activity_id)->default_finance_type;
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
     * Updates activity default finance type data.
     *
     * @param $id
     * @param $activityDefaultFinanceType
     *
     * @return bool
     */
    public function update($id, $activityDefaultFinanceType): bool
    {
        return $this->activityRepository->update($id, ['default_finance_type' => $activityDefaultFinanceType]);
    }

    /**
     * Generates default finance type form.
     *
     * @param id
     *
     * @return Form
     */
    public function formGenerator($id): Form
    {
        $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
        $model['default_finance_type'] = $this->getDefaultFinanceTypeData($id);
        $this->baseFormCreator->url = route('admin.activity.default-finance-type.update', [$id]);

        return $this->baseFormCreator->editForm($model, $element['default_finance_type'], 'PUT', '/activity/' . $id);
    }
}
