<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\BaseFormCreator;
use App\IATI\Repositories\Activity\StatusRepository;
use Illuminate\Database\Eloquent\Model;
use Kris\LaravelFormBuilder\Form;

/**
 * Class StatusService.
 */
class StatusService
{
    /**
     * @var StatusRepository
     */
    protected StatusRepository $statusRepository;

    /**
     * @var BaseFormCreator
     */
    protected BaseFormCreator $baseFormCreator;

    /**
     * StatusService constructor.
     *
     * @param StatusRepository $statusRepository
     * @param BaseFormCreator $baseFormCreator
     */
    public function __construct(StatusRepository $statusRepository, BaseFormCreator $baseFormCreator)
    {
        $this->statusRepository = $statusRepository;
        $this->baseFormCreator = $baseFormCreator;
    }

    /**
     * Returns status data of an activity.
     *
     * @param int $activity_id
     *
     * @return int|null
     */
    public function getStatusData(int $activity_id): ?int
    {
        return $this->statusRepository->getStatusData($activity_id);
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
        return $this->statusRepository->getActivityData($id);
    }

    /**
     * Updates activity status.
     *
     * @param $activityStatus
     * @param $activity
     *
     * @return bool
     */
    public function update($activityStatus, $activity): bool
    {
        return $this->statusRepository->update($activityStatus, $activity);
    }

    /**
     * Generates budget form.
     *
     * @param id
     *
     * @return Form
     */
    public function formGenerator($id): Form
    {
        $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
        $model['activity_status'] = $this->getStatusData($id);
        $this->baseFormCreator->url = route('admin.activities.status.update', [$id]);

        return $this->baseFormCreator->editForm($model, $element['activity_status'], 'PUT', '/activities/' . $id);
    }
}
