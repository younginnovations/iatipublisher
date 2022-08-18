<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\ParentCollectionFormCreator;
use App\IATI\Repositories\Activity\ActivityRepository;
use Kris\LaravelFormBuilder\Form;

/**
 * Class TagService.
 */
class TagService
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
     * TagService constructor.
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
     * Returns tag data of an activity.
     *
     * @param int $activity_id
     *
     * @return array|null
     */
    public function getTagData(int $activity_id): ?array
    {
        return $this->activityRepository->find($activity_id)->tag;
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
     * Updates activity tag.
     *
     * @param $activityTag
     * @param $activity
     *
     * @return bool
     */
    public function update($activityTag, $activity): bool
    {
        return $this->activityRepository->update($activity->id, ['tag' => $this->sanitizeTagData($activityTag)]);
    }

    /**
     * Generates tag form.
     *
     * @param id
     *
     * @return Form
     */
    public function formGenerator($id): Form
    {
        $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
        $model['tag'] = $this->getTagData($id);
        $this->parentCollectionFormCreator->url = route('admin.activity.tag.update', [$id]);

        return $this->parentCollectionFormCreator->editForm($model, $element['tag'], 'PUT', '/activity/' . $id);
    }

    /**
     * Sanitizes tag data.
     *
     * @param $activityTag
     *
     * @return array
     */
    public function sanitizeTagData($activityTag): array
    {
        foreach ($activityTag['tag'] as $key => $tag) {
            $activityTag['tag'][$key]['narrative'] = array_values($tag['narrative']);
        }

        return array_values($activityTag['tag']);
    }
}
