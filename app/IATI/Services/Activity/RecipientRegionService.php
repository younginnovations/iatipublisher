<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Repositories\Activity\RecipientRegionRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RecipientRegionService.
 */
class RecipientRegionService
{
    /**
     * @var RecipientRegionRepository
     */
    protected RecipientRegionRepository $recipientRegionRepository;

    /**
     * RecipientRegionService constructor.
     *
     * @param RecipientRegionRepository $recipientRegionRepository
     */
    public function __construct(RecipientRegionRepository $recipientRegionRepository)
    {
        $this->recipientRegionRepository = $recipientRegionRepository;
    }

    /**
     * Returns recipient region data of an activity.
     *
     * @param int $activity_id
     *
     * @return array|null
     */
    public function getRecipientRegionData(int $activity_id): ?array
    {
        return $this->recipientRegionRepository->getRecipientRegionData($activity_id);
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
        return $this->recipientRegionRepository->getActivityData($id);
    }

    /**
     * Updates activity recipient region.
     *
     * @param $activityRecipientRegion
     * @param $activity
     *
     * @return bool
     */
    public function update($activityRecipientRegion, $activity): bool
    {
        return $this->recipientRegionRepository->update($activityRecipientRegion, $activity);
    }
}
