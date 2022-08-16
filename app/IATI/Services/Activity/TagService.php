<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\ParentCollectionFormCreator;
use App\IATI\Repositories\Activity\TagRepository;
use Illuminate\Database\Eloquent\Model;
use Kris\LaravelFormBuilder\Form;

/**
 * Class TagService.
 */
class TagService
{
    /**
     * @var TagRepository
     */
    protected TagRepository $tagRepository;

    /**
     * @var ParentCollectionFormCreator
     */
    protected ParentCollectionFormCreator $parentCollectionFormCreator;

    /**
     * TagService constructor.
     *
     * @param TagRepository $tagRepository
     * @param ParentCollectionFormCreator $parentCollectionFormCreator
     */
    public function __construct(TagRepository $tagRepository, ParentCollectionFormCreator $parentCollectionFormCreator)
    {
        $this->tagRepository = $tagRepository;
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
        return $this->tagRepository->getTagData($activity_id);
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
        return $this->tagRepository->getActivityData($id);
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
        return $this->tagRepository->update($activityTag, $activity);
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
}
