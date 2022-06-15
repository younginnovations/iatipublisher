<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Repositories\Activity\TagRepository;
use Illuminate\Database\Eloquent\Model;

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
     * TagService constructor.
     *
     * @param TagRepository $tagRepository
     */
    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
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
}
