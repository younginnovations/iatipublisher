<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\IatiActivity;
use App\IATI\Repositories\Activity\TitleRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TitleService.
 */
class TitleService
{
    /**
     * @var TitleRepository
     */
    protected $titleRepository;

    /**
     * TitleService constructor.
     *
     * @param IatiActivity $iatiActivity
     */
    public function __construct(IatiActivity $iatiActivity)
    {
        $this->titleRepository = $iatiActivity->getTitle()->getRepository();
    }

    /**
     * Returns title data of an activity.
     * @param int $activity_id
     * @return array
     */
    public function getTitleData(int $activity_id): array
    {
        return $this->titleRepository->getTitleData($activity_id);
    }

    /**
     * Returns activity object.
     * @param $id
     * @return Model
     */
    public function getActivityData($id): Model
    {
        return $this->titleRepository->getActivityData($id);
    }

    /**
     * Updates activity title.
     * @param $activityTitle
     * @param $activityData
     * @return bool
     */
    public function update($activityTitle, $activity): bool
    {
        $activity->title = $activityTitle['narrative'];

        return $activity->save();
    }
}
