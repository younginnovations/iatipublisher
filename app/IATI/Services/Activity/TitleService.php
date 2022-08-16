<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\BaseFormCreator;
use App\IATI\Repositories\Activity\TitleRepository;
use Illuminate\Database\Eloquent\Model;
use Kris\LaravelFormBuilder\Form;

/**
 * Class TitleService.
 */
class TitleService
{
    /**
     * @var TitleRepository
     */
    protected TitleRepository $titleRepository;

    /**
     * @var BaseFormCreator
     */
    protected BaseFormCreator $baseFormCreator;

    /**
     * TitleService constructor.
     *
     * @param TitleRepository $titleRepository
     */
    public function __construct(TitleRepository $titleRepository, BaseFormCreator $baseFormCreator)
    {
        $this->titleRepository = $titleRepository;
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
        return $this->titleRepository->getTitleData($activity_id);
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
        return $this->titleRepository->getActivityData($id);
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
        $activity->title = array_values($activityTitle['narrative']);

        return $activity->save();
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
