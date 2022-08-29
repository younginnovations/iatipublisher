<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\BaseFormCreator;
use App\IATI\Models\Activity\Activity;
use App\IATI\Repositories\Activity\DefaultFinanceTypeRepository;
use Illuminate\Database\Eloquent\Model;
use Kris\LaravelFormBuilder\Form;

/**
 * Class DefaultFinanceTypeService.
 */
class DefaultFinanceTypeService
{
    /**
     * @var DefaultFinanceTypeRepository
     */
    protected DefaultFinanceTypeRepository $defaultFinanceTypeRepository;

    /**
     * @var BaseFormCreator
     */
    protected BaseFormCreator $baseFormCreator;

    /**
     * DefaultFinanceTypeService constructor.
     *
     * @param DefaultFinanceTypeRepository $defaultFinanceTypeRepository
     * @param BaseFormCreator $baseFormCreator
     */
    public function __construct(DefaultFinanceTypeRepository $defaultFinanceTypeRepository, BaseFormCreator $baseFormCreator)
    {
        $this->defaultFinanceTypeRepository = $defaultFinanceTypeRepository;
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
        return $this->defaultFinanceTypeRepository->getDefaultFinanceTypeData($activity_id);
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
        return $this->defaultFinanceTypeRepository->getActivityData($id);
    }

    /**
     * Updates activity default finance type data.
     *
     * @param $activityDefaultFinanceType
     * @param $activity
     *
     * @return bool
     */
    public function update($activityDefaultFinanceType, $activity): bool
    {
        return $this->defaultFinanceTypeRepository->update($activityDefaultFinanceType, $activity);
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
        $element = getElementSchema('default_finance_type');
        $model['default_finance_type'] = $this->getDefaultFinanceTypeData($id);
        $this->baseFormCreator->url = route('admin.activities.default-finance-type.update', [$id]);

        return $this->baseFormCreator->editForm($model, $element, 'PUT', '/activities/' . $id);
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

        if ($activity->default_finance_type) {
            $activityData = [
                '@attributes' => [
                    'code' => $activity->default_finance_type,
                ],
            ];
        }

        return $activityData;
    }
}
