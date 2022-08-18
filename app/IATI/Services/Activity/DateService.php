<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\ParentCollectionFormCreator;
use App\IATI\Repositories\Activity\ActivityRepository;
use Illuminate\Database\Eloquent\Model;
use Kris\LaravelFormBuilder\Form;

/**
 * Class DateService.
 */
class DateService
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
     * DateService constructor.
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
     * Returns date data of an activity.
     *
     * @param int $activity_id
     *
     * @return array|null
     */
    public function getDateData(int $activity_id): ?array
    {
        return $this->activityRepository->find($activity_id)->activity_date;
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
     * Updates activity date.
     *
     * @param $id
     * @param $activityDate
     *
     * @return bool
     */
    public function update($id, $activityDate): bool
    {
        foreach ($activityDate['activity_date'] as $key => $activity_date) {
            $activityDate['activity_date'][$key]['narrative'] = array_values($activity_date['narrative']);
        }

        return $this->activityRepository->update($id, ['activity_date' => array_values($activityDate['activity_date'])]);
    }

    /**
     * Generates date form.
     *
     * @param id
     *
     * @return Form
     */
    public function formGenerator($id): Form
    {
        $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
        $model['activity_date'] = $this->getDateData($id);
        $this->parentCollectionFormCreator->url = route('admin.activity.date.update', [$id]);

        return $this->parentCollectionFormCreator->editForm($model, $element['activity_date'], 'PUT', '/activity/' . $id);
    }
}
