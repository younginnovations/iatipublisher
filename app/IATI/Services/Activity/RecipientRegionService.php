<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Models\Activity\Activity;
use App\IATI\Repositories\Activity\RecipientRegionRepository;
use App\IATI\Traits\XmlBaseElement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

/**
 * Class RecipientRegionService.
 */
class RecipientRegionService
{
    use XmlBaseElement;

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
        $recipientRegions = (array) $activity->recipient_region;

        if (count($recipientRegions)) {
            foreach ($recipientRegions as $recipientRegion) {
                $vocabulary = Arr::get($recipientRegion, 'region_vocabulary', null);

                switch ($vocabulary) {
                    case '1':
                        $code = Arr::get($recipientRegion, 'region_code', null);
                        break;

                    case '2':
                    case '99':
                        $code = Arr::get($recipientRegion, 'custom_code', null);
                        break;

                    default:
                        $code = Arr::get($recipientRegion, 'custom_code', null);
                }

                $activityData[] = [
                    '@attributes' => [
                        'code'           => $code,
                        'percentage'     => Arr::get($recipientRegion, 'percentage', null),
                        'vocabulary'     => $vocabulary,
                        'vocabulary-uri' => Arr::get($recipientRegion, 'vocabulary_uri', null),
                    ],
                    'narrative'   => $this->buildNarrative(Arr::get($recipientRegion, 'narrative', [])),
                ];
            }
        }

        return $activityData;
    }
}
