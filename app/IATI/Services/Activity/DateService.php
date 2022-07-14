<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\ParentCollectionFormCreator;
use App\IATI\Models\Activity\Activity;
use App\IATI\Repositories\Activity\DateRepository;
use App\IATI\Traits\XmlBaseElement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Kris\LaravelFormBuilder\Form;

/**
 * Class DateService.
 */
class DateService
{
    use XmlBaseElement;
    /**
     * @var DateRepository
     */
    protected DateRepository $dateRepository;

    /**
     * @var ParentCollectionFormCreator
     */
    protected ParentCollectionFormCreator $parentCollectionFormCreator;

    /**
     * DateService constructor.
     *
     * @param DateRepository $dateRepository
     * @param ParentCollectionFormCreator $parentCollectionFormCreator
     */
    public function __construct(DateRepository $dateRepository, ParentCollectionFormCreator $parentCollectionFormCreator)
    {
        $this->dateRepository = $dateRepository;
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
        return $this->dateRepository->getDateData($activity_id);
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
        return $this->dateRepository->getActivityData($id);
    }

    /**
     * Updates activity date.
     *
     * @param $activityDate
     * @param $activity
     *
     * @return bool
     */
    public function update($activityDate, $activity): bool
    {
        return $this->dateRepository->update($activityDate, $activity);
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
        $this->parentCollectionFormCreator->url = route('admin.activities.date.update', [$id]);

        return $this->parentCollectionFormCreator->editForm($model, $element['activity_date'], 'PUT', '/activities/' . $id);
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
