<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\BaseFormCreator;
use App\IATI\Models\Activity\Activity;
use App\IATI\Repositories\Activity\DefaultFlowTypeRepository;
use Illuminate\Database\Eloquent\Model;
use Kris\LaravelFormBuilder\Form;

/**
 * Class DefaultFlowTypeService.
 */
class DefaultFlowTypeService
{
    /**
     * @var DefaultFlowTypeRepository
     */
    protected DefaultFlowTypeRepository $defaultFlowTypeRepository;

    /**
     * @var BaseFormCreator
     */
    protected BaseFormCreator $baseFormCreator;

    /**
     * DefaultFlowTypeService constructor.
     *
     * @param DefaultFlowTypeRepository $defaultFlowTypeRepository
     * @param BaseFormCreator $baseFormCreator
     */
    public function __construct(DefaultFlowTypeRepository $defaultFlowTypeRepository, BaseFormCreator $baseFormCreator)
    {
        $this->defaultFlowTypeRepository = $defaultFlowTypeRepository;
        $this->baseFormCreator = $baseFormCreator;
    }

    /**
     * Returns default flow type data of an activity.
     *
     * @param int $activity_id
     *
     * @return int|null
     */
    public function getDefaultFlowTypeData(int $activity_id): ?int
    {
        return $this->defaultFlowTypeRepository->getDefaultFlowTypeData($activity_id);
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
        return $this->defaultFlowTypeRepository->getActivityData($id);
    }

    /**
     * Updates activity default flow type data.
     *
     * @param $activityDefaultFlowType
     * @param $activity
     *
     * @return bool
     */
    public function update($activityDefaultFlowType, $activity): bool
    {
        return $this->defaultFlowTypeRepository->update($activityDefaultFlowType, $activity);
    }

    /**
     * Generates default flow type form.
     *
     * @param id
     *
     * @return Form
     */
    public function formGenerator($id): Form
    {
        $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
        $model['default_flow_type'] = $this->getDefaultFlowTypeData($id);
        $this->baseFormCreator->url = route('admin.activities.default-flow-type.update', [$id]);

        return $this->baseFormCreator->editForm($model, $element['default_flow_type'], 'PUT', '/activities/' . $id);
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

        if ($activity->default_flow_type) {
            $activityData = [
                '@attributes' => [
                    'code' => $activity->default_flow_type,
                ],
            ];
        }

        return $activityData;
    }
}
