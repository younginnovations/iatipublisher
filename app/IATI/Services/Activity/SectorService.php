<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Models\Activity\Activity;
use App\IATI\Repositories\Activity\SectorRepository;
use App\IATI\Traits\XmlBaseElement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

/**
 * Class SectorService.
 */
class SectorService
{
    use XmlBaseElement;

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

    /**
     * Returns data in required xml array format.
     *
     * @param Activity $activity
     *
     * @return array
     */
    public function getXmlData(Activity $activity)
    {
        $activityData = [];
        $sectors = (array) $activity->sector;

        if (count($sectors)) {
            foreach ($sectors as $sector) {
                $vocabulary = Arr::get($sector, 'sector_vocabulary', null);

                switch ($vocabulary) {
                    case '1':
                        $sectorValue = Arr::get($sector, 'code', null);
                        break;
                    case '2':
                        $sectorValue = Arr::get($sector, 'category_code', null);
                        break;
                    case '7':
                        $sectorValue = Arr::get($sector, 'sdg_goal', null);
                        break;
                    case '8':
                        $sectorValue = Arr::get($sector, 'sdg_target', null);
                        break;
                    default:
                        $sectorValue = Arr::get($sector, 'text', null);
                        break;
                }

                $activityData[] = [
                    '@attributes' => [
                        'code'           => $sectorValue,
                        'percentage'     => Arr::get($sector, 'percentage', null),
                        'vocabulary'     => $vocabulary,
                        'vocabulary-uri' => Arr::get($sector, 'vocabulary_uri', null),
                    ],
                    'narrative'   => $this->buildNarrative(Arr::get($sector, 'narrative', null)),
                ];
            }
        }

        return $activityData;
    }
}
