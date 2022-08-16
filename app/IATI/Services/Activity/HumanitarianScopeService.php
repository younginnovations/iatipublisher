<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\ParentCollectionFormCreator;
use App\IATI\Repositories\Activity\HumanitarianScopeRepository;
use Illuminate\Database\Eloquent\Model;
use Kris\LaravelFormBuilder\Form;

/**
 * Class HumanitarianScopeService.
 */
class HumanitarianScopeService
{
    /**
     * @var HumanitarianScopeRepository
     */
    protected HumanitarianScopeRepository $humanitarianScopeRepository;

    /**
     * @var ParentCollectionFormCreator
     */
    protected ParentCollectionFormCreator $parentCollectionFormCreator;

    /**
     * HumanitarianScopeService constructor.
     *
     * @param HumanitarianScopeRepository $humanitarianScopeRepository
     * @param ParentCollectionFormCreator $parentCollectionFormCreator
     */
    public function __construct(HumanitarianScopeRepository $humanitarianScopeRepository, ParentCollectionFormCreator $parentCollectionFormCreator)
    {
        $this->humanitarianScopeRepository = $humanitarianScopeRepository;
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
        return $this->humanitarianScopeRepository->getHumanitarianScopeData($activity_id);
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
        return $this->humanitarianScopeRepository->getActivityData($id);
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
        return $this->humanitarianScopeRepository->update($activityHumanitarianScope, $activity);
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
}
