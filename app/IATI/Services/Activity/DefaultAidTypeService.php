<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\BaseFormCreator;
use App\IATI\Repositories\Activity\DefaultAidTypeRepository;
use Illuminate\Database\Eloquent\Model;
use Kris\LaravelFormBuilder\Form;

/**
 * Class DefaultAidTypeService.
 */
class DefaultAidTypeService
{
    /**
     * @var DefaultAidTypeRepository
     */
    protected DefaultAidTypeRepository $defaultAidTypeRepository;

    /**
     * @var BaseFormCreator
     */
    protected BaseFormCreator $baseFormCreator;

    /**
     * DefaultAidTypeService constructor.
     *
     * @param DefaultAidTypeRepository $defaultAidTypeRepository
     * @param BaseFormCreator $baseFormCreator
     */
    public function __construct(DefaultAidTypeRepository $defaultAidTypeRepository, BaseFormCreator $baseFormCreator)
    {
        $this->defaultAidTypeRepository = $defaultAidTypeRepository;
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
        return $this->defaultAidTypeRepository->getDefaultAidTypeData($activity_id);
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
        return $this->defaultAidTypeRepository->getActivityData($id);
    }

    /**
     * Updates activity default aid type.
     *
     * @param $activityDefaultAidType
     * @param $activity
     *
     * @return bool
     */
    public function update($activityDefaultAidType, $activity): bool
    {
        return $this->defaultAidTypeRepository->update($activityDefaultAidType, $activity);
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
        $this->baseFormCreator->url = route('admin.activities.default-aid-type.update', [$id]);

        return $this->baseFormCreator->editForm($model, $element['default_aid_type'], 'PUT', '/activities/' . $id);
    }
}
