<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Repositories\Activity\SectorRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SectorService.
 */
class SectorService
{
    /**
     * @var SectorRepository
     */
    protected SectorRepository $sectorRepository;

    /**
     * SectorService constructor.
     *
     * @param SectorRepository $sectorRepository
     */
    public function __construct(SectorRepository $sectorRepository)
    {
        $this->sectorRepository = $sectorRepository;
    }

    /**
     * Returns sector data of an activity.
     *
     * @param int $activity_id
     *
     * @return array|null
     */
    public function getSectorData(int $activity_id): ?array
    {
        return $this->sectorRepository->getSectorData($activity_id);
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
        return $this->sectorRepository->getActivityData($id);
    }

    /**
     * Updates activity sector.
     *
     * @param $sectorActivity
     * @param $activity
     *
     * @return bool
     */
    public function update($sectorActivity, $activity): bool
    {
        return $this->sectorRepository->update($sectorActivity, $activity);
    }
}
