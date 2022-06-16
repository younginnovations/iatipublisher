<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Repositories\Activity\OtherIdentifierRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OtherIdentifierService.
 */
class OtherIdentifierService
{
    /**
     * @var otherIdentifierRepository
     */
    protected OtherIdentifierRepository $otherIdentifierRepository;

    /**
     * OtherIdentifierService constructor.
     *
     * @param OtherIdentifierRepository $otherIdentifierRepository
     */
    public function __construct(OtherIdentifierRepository $otherIdentifierRepository)
    {
        $this->otherIdentifierRepository = $otherIdentifierRepository;
    }

    /**
     * Returns other identifier data of an activity.
     *
     * @param int $activity_id
     *
     * @return array|null
     */
    public function getOtherIdentifierData(int $activity_id): ?array
    {
        return $this->otherIdentifierRepository->getOtherIdentifierData($activity_id);
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
        return $this->otherIdentifierRepository->getActivityData($id);
    }

    /**
     * Updates activity condition.
     *
     * @param $activityCondition
     * @param $activity
     *
     * @return bool
     */
    public function update($activityCondition, $activity): bool
    {
        return $this->otherIdentifierRepository->update($activityCondition, $activity);
    }
}
