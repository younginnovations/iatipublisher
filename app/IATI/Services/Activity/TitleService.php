<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\BaseFormCreator;
use App\IATI\Models\Activity\Activity;
use App\IATI\Repositories\Activity\ActivityRepository;
use App\IATI\Traits\XmlBaseElement;
use Kris\LaravelFormBuilder\Form;

/**
 * Class TitleService.
 */
class TitleService
{
    use XmlBaseElement;

    /**
     * @var ActivityRepository
     */
    protected ActivityRepository $activityRepository;

    /**
     * @var BaseFormCreator
     */
    protected BaseFormCreator $baseFormCreator;

    /**
     * TitleService constructor.
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
     * Returns title data of an activity.
     *
     * @param int $activity_id
     *
     * @return array|null
     */
    public function getTitleData(int $activity_id): ?array
    {
        return $this->activityRepository->find($activity_id)->title;
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
     * Updates activity title.
     *
     * @param $id
     * @param $activityTitle
     *
     * @return bool
     */
    public function update($id, $activityTitle): bool
    {
        $activity = $this->activityRepository->find($id);
        $deprecationStatusMap = $activity->deprecation_status_map;
        $deprecationStatusMap['title'] = doesTitleHaveDeprecatedCode($activityTitle);

        return $this->activityRepository->update($id, [
            'title'                  => $activityTitle['narrative'],
            'deprecation_status_map' => $deprecationStatusMap,
        ]);
    }

    /**
     * Generates title form.
     *
     * @param $id
     *
     * @return Form
     * @throws \JsonException
     */
    public function formGenerator($id, $activityDefaultFieldValues, $deprecationStatusMap = []): Form
    {
        $element = getElementSchema('title');
        $model['narrative'] = $this->getTitleData($id);
        $this->baseFormCreator->url = route('admin.activity.title.update', [$id]);

        return $this->baseFormCreator->editForm($model, $element, 'PUT', '/activity/' . $id, overRideDefaultFieldValue: $activityDefaultFieldValues, deprecationStatusMap: $deprecationStatusMap);
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
        $titles = (array) $activity->title;
        $activityData = [];

        if (count($titles)) {
            $activityData[] = [
                'narrative' => $this->buildNarrative($titles),
            ];
        }

        return $activityData;
    }
}
