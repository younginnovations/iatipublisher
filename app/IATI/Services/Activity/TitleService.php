<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\BaseFormCreator;
use App\IATI\Repositories\Activity\ActivityRepository;
use Kris\LaravelFormBuilder\Form;

/**
 * Class TitleService.
 */
class TitleService
{
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
     * @return array
     */
    public function getTitleData(int $activity_id): array
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
     * @param $activityTitle
     * @param $activity
     *
     * @return bool
     */
    public function update($activityTitle, $activity): bool
    {
        return $this->activityRepository->update($activity->id, ['title' => array_values($activityTitle['narrative'])]);
    }

    /**
     * Generates title form.
     *
     * @param $id
     *
     * @return Form
     */
    public function formGenerator($id): Form
    {
        $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
        $model['narrative'] = $this->getTitleData($id);
        $this->baseFormCreator->url = route('admin.activity.title.update', [$id]);

        return $this->baseFormCreator->editForm($model, $element['title'], 'PUT', '/activity/' . $id);
    }
}
