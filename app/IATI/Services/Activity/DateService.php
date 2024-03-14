<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\ParentCollectionFormCreator;
use App\IATI\Models\Activity\Activity;
use App\IATI\Repositories\Activity\ActivityRepository;
use App\IATI\Traits\XmlBaseElement;
use Illuminate\Support\Arr;
use Kris\LaravelFormBuilder\Form;

/**
 * Class DateService.
 */
class DateService
{
    use XmlBaseElement;

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
     * @param ActivityRepository          $activityRepository
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
     * @return object
     */
    public function getActivityData($id): object
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
     * @throws \JsonException
     */
    public function formGenerator($id, $activityDefaultFieldValues): Form
    {
        $element = getElementSchema('activity_date');
        $model['activity_date'] = $this->getDateData($id);
        $this->parentCollectionFormCreator->url = route('admin.activity.date.update', [$id]);

        return $this->parentCollectionFormCreator->editForm($model, $element, 'PUT', '/activity/' . $id, $activityDefaultFieldValues);
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
        $activityDate = (array) $activity->activity_date;

        if (count($activityDate)) {
            foreach ($activityDate as $ActivityDate) {
                $activityData[] = [
                    '@attributes' => [
                        'type'     => Arr::get($ActivityDate, 'type', null),
                        'iso-date' => Arr::get($ActivityDate, 'date', null),
                    ],
                    'narrative'   => $this->buildNarrative(Arr::get($ActivityDate, 'narrative', null)),
                ];
            }
        }

        return $activityData;
    }
}
