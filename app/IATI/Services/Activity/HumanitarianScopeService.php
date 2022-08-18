<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\ParentCollectionFormCreator;
use App\IATI\Repositories\Activity\ActivityRepository;
use Kris\LaravelFormBuilder\Form;

/**
 * Class HumanitarianScopeService.
 */
class HumanitarianScopeService
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
     * HumanitarianScopeService constructor.
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
     * Returns humanitarian scope data of an activity.
     *
     * @param int $activity_id
     *
     * @return array|null
     */
    public function getHumanitarianScopeData(int $activity_id): ?array
    {
        return $this->activityRepository->find($activity_id)->humanitarian_scope;
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
     * Updates activity humanitarian scope.
     *
     * @param $activityHumanitarianScope
     * @param $activity
     *
     * @return bool
     */
    public function update($activityHumanitarianScope, $activity): bool
    {
        return $this->activityRepository->update($activity->id, ['humanitarian_scope' => $this->sanitizeHumanitarianScopeData($activityHumanitarianScope)]);
    }

    /**
     * Generates humanitarian scope form.
     *
     * @param id
     *
     * @return Form
     */
    public function formGenerator($id): Form
    {
        $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
        $model['humanitarian_scope'] = $this->getHumanitarianScopeData($id);
        $this->parentCollectionFormCreator->url = route('admin.activity.humanitarian-scope.update', [$id]);

        return $this->parentCollectionFormCreator->editForm($model, $element['humanitarian_scope'], 'PUT', '/activity/' . $id);
    }

    /**
     * Sanitizes humanitarian scope data.
     *
     * @param $activityHumanitarianScope
     *
     * @return array
     */
    public function sanitizeHumanitarianScopeData($activityHumanitarianScope): array
    {
        foreach ($activityHumanitarianScope['humanitarian_scope'] as $key => $humanitarian_scope) {
            $activityHumanitarianScope['humanitarian_scope'][$key]['narrative'] = array_values($humanitarian_scope['narrative']);
        }

        return array_values($activityHumanitarianScope['humanitarian_scope']);
    }
}
