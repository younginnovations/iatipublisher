<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\BaseFormCreator;
use App\IATI\Repositories\Activity\ScopeRepository;
use Illuminate\Database\Eloquent\Model;
use Kris\LaravelFormBuilder\Form;

/**
 * Class ScopeService.
 */
class ScopeService
{
    /**
     * @var ScopeRepository
     */
    protected ScopeRepository $scopeRepository;

    /**
     * @var BaseFormCreator
     */
    protected BaseFormCreator $baseFormCreator;

    /**
     * ScopeService constructor.
     *
     * @param ScopeRepository $scopeRepository
     * @param BaseFormCreator $baseFormCreator
     */
    public function __construct(ScopeRepository $scopeRepository, BaseFormCreator $baseFormCreator)
    {
        $this->scopeRepository = $scopeRepository;
        $this->baseFormCreator = $baseFormCreator;
    }

    /**
     * Returns scope data of an activity.
     *
     * @param int $activity_id
     *
     * @return int|null
     */
    public function getScopeData(int $activity_id): ?int
    {
        return $this->scopeRepository->getScopeData($activity_id);
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
        return $this->scopeRepository->getActivityData($id);
    }

    /**
     * Updates activity scope.
     *
     * @param $activityScope
     * @param $activity
     *
     * @return bool
     */
    public function update($activityScope, $activity): bool
    {
        return $this->scopeRepository->update($activityScope, $activity);
    }

    /**
     * Generates scope form.
     *
     * @param id
     *
     * @return Form
     */
    public function formGenerator($id): Form
    {
        $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
        $model['activity_scope'] = $this->getScopeData($id);
        $this->baseFormCreator->url = route('admin.activity.scope.update', [$id]);

        return $this->baseFormCreator->editForm($model, $element['activity_scope'], 'PUT', '/activity/' . $id);
    }
}
