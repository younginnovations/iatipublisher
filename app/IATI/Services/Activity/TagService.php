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
 * Class TagService.
 */
class TagService
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
     * TagService constructor.
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
     * @param $id
     * @param $activityTag
     *
     * @return bool
     */
    public function update($id, $activityTag): bool
    {
        return $this->activityRepository->update($id, ['tag' => $this->sanitizeTagData($activityTag)]);
    }

    /**
     * Generates tag form.
     *
     * @param id
     *
     * @return Form
     * @throws \JsonException
     */
    public function formGenerator($id, $activityDefaultFieldValues): Form
    {
        $element = getElementSchema('tag');
        $model['tag'] = $this->getTagData($id);
        $this->parentCollectionFormCreator->url = route('admin.activity.tag.update', [$id]);

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
