<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\BaseFormCreator;
use App\IATI\Repositories\Activity\ActivityRepository;
use Illuminate\Database\Eloquent\Model;
use Kris\LaravelFormBuilder\Form;

/**
 * Class DefaultAidTypeService.
 */
class DefaultAidTypeService
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
     * DefaultAidTypeService constructor.
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
     * Returns default aid type data of an activity.
     *
     * @param int $activity_id
     *
     * @return array|null
     */
    public function getDefaultAidTypeData(int $activity_id): ?array
    {
        return $this->activityRepository->find($activity_id)->default_aid_type;
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
     * Updates activity default aid type.
     *
     * @param $id
     * @param $activityDefaultAidType
     *
     * @return bool
     */
    public function update($id, $activityDefaultAidType): bool
    {
        return $this->activityRepository->update($id, ['default_aid_type' => array_values($activityDefaultAidType['default_aid_type'])]);
    }

    /**
     * Generates default aid type.
     *
     * @param id
     *
     * @return Form
     */
    public function formGenerator($id): Form
    {
        $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
        $model['default_aid_type'] = $this->getDefaultAidTypeData($id);
        $this->baseFormCreator->url = route('admin.activity.default-aid-type.update', [$id]);

        return $this->baseFormCreator->editForm($model, $element['default_aid_type'], 'PUT', '/activity/' . $id);
    }
}
