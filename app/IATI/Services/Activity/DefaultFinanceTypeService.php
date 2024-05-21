<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\BaseFormCreator;
use App\IATI\Models\Activity\Activity;
use App\IATI\Repositories\Activity\ActivityRepository;
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
     * @param BaseFormCreator    $baseFormCreator
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
     * @return object
     */
    public function getActivityData($id): object
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
        $activity = $this->activityRepository->find($id);
        $deprecationStatusMap = $activity->deprecation_status_map;
        $deprecationStatusMap['default_finance_type'] = doesDefaultFinanceTypeHaveDeprecatedCode($activityDefaultFinanceType);

        return $this->activityRepository->update($id, [
            'default_finance_type'   => $activityDefaultFinanceType['code'],
            'deprecation_status_map' => $deprecationStatusMap,
        ]);
    }

    /**
     * Generates default finance type form.
     *
     * @param id
     *
     * @return Form
     * @throws \JsonException
     */
    public function formGenerator($id, $activityDefaultFieldValues, $deprecationStatusMap = []): Form
    {
        $element = getElementSchema('default_finance_type');
        $model['default_finance_type'] = $this->getDefaultFinanceTypeData($id);
        $this->baseFormCreator->url = route('admin.activity.default-finance-type.update', [$id]);

        return $this->baseFormCreator->editForm($model, $element, 'PUT', '/activity/' . $id, overRideDefaultFieldValue: $activityDefaultFieldValues, deprecationStatusMap: $deprecationStatusMap);
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
