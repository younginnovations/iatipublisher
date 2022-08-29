<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\ParentCollectionFormCreator;
use App\IATI\Models\Activity\Activity;
use App\IATI\Repositories\Activity\TagRepository;
use App\IATI\Traits\XmlBaseElement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Kris\LaravelFormBuilder\Form;

/**
 * Class TagService.
 */
class TagService
{
    use XmlBaseElement;

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
        $element = getElementSchema('tag');
        $model['tag'] = $this->getTagData($id);
        $this->parentCollectionFormCreator->url = route('admin.activities.tag.update', [$id]);

        return $this->parentCollectionFormCreator->editForm($model, $element, 'PUT', '/activities/' . $id);
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
        $tags = (array) $activity->tag;

        if (count($tags)) {
            foreach ($tags as $tag) {
                $vocabulary = Arr::get($tag, 'tag_vocabulary', null);

                switch ($vocabulary) {
                    case '2':
                        $tagValue = Arr::get($tag, 'goals_tag_code', null);
                        break;
                    case '3':
                        $tagValue = Arr::get($tag, 'targets_tag_code', null);
                        break;
                    default:
                        $tagValue = Arr::get($tag, 'tag_text', null);
                        break;
                }

                $activityData[] = [
                    '@attributes' => [
                        'code'           => $tagValue,
                        'vocabulary'     => $vocabulary,
                        'vocabulary-uri' => Arr::get($tag, 'vocabulary_uri', null),
                    ],
                    'narrative'   => $this->buildNarrative(Arr::get($tag, 'narrative', null)),
                ];
            }
        }

        return $activityData;
    }
}
