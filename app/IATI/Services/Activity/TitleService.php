<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\BaseFormCreator;
use App\IATI\Models\Activity\Activity;
use App\IATI\Repositories\Activity\TitleRepository;
use App\IATI\Traits\XmlBaseElement;
use Illuminate\Database\Eloquent\Model;
use Kris\LaravelFormBuilder\Form;

/**
 * Class TitleService.
 */
class TitleService
{
    use XmlBaseElement;

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
     * @return array|null
     */
    public function getTitleData(int $activity_id): ?array
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
        $element = getElementSchema('title');
        $model['narrative'] = $this->getTitleData($id);
        $this->baseFormCreator->url = route('admin.activities.title.update', [$id]);

        return $this->baseFormCreator->editForm($model, $element, 'PUT', '/activities/' . $id);
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
