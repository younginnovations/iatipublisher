<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\BaseFormCreator;
use App\IATI\Models\Activity\Activity;
use App\IATI\Repositories\Activity\RelatedActivityRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Kris\LaravelFormBuilder\Form;

/**
 * Class RelatedActivityService.
 */
class RelatedActivityService
{
    /**
     * @var RelatedActivityRepository
     */
    protected RelatedActivityRepository $relatedActivityRepository;

    /**
     * @var BaseFormCreator
     */
    protected BaseFormCreator $baseFormCreator;

    /**
     * RelatedActivityService constructor.
     *
     * @param RelatedActivityRepository $relatedActivityRepository
     * @param BaseFormCreator $baseFormCreator
     */
    public function __construct(RelatedActivityRepository $relatedActivityRepository, BaseFormCreator $baseFormCreator)
    {
        $this->relatedActivityRepository = $relatedActivityRepository;
        $this->baseFormCreator = $baseFormCreator;
    }

    /**
     * Returns related activity data of an activity.
     *
     * @param int $activity_id
     *
     * @return array|null
     */
    public function getRelatedActivityData(int $activity_id): ?array
    {
        return $this->relatedActivityRepository->getRelatedActivityData($activity_id);
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
        return $this->relatedActivityRepository->getActivityData($id);
    }

    /**
     * Updates activity related activity.
     *
     * @param $activityRelatedActivity
     * @param $activity
     *
     * @return bool
     */
    public function update($activityRelatedActivity, $activity): bool
    {
        return $this->relatedActivityRepository->update($activityRelatedActivity, $activity);
    }

    /**
     * Generates related activity form.
     *
     * @param id
     *
     * @return Form
     */
    public function formGenerator($id): Form
    {
        $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
        $model['related_activity'] = $this->getRelatedActivityData($id);
        $this->baseFormCreator->url = route('admin.activities.related-activity.update', [$id]);

        return $this->baseFormCreator->editForm($model, $element['related_activity'], 'PUT', '/activities/' . $id);
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
        $relatedActivities = (array) $activity->related_activity;

        if (count($relatedActivities)) {
            foreach ($relatedActivities as $relatedActivity) {
                $activityData[] = [
                    '@attributes' => [
                        'ref'  => Arr::get($relatedActivity, 'activity_identifier', null),
                        'type' => Arr::get($relatedActivity, 'relationship_type', null),
                    ],
                ];
            }
        }

        return $activityData;
    }
}
