<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Models\Activity\Activity;
use App\IATI\Repositories\Activity\DescriptionRepository;
use App\IATI\Traits\XmlBaseElement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

/**
 * Class DescriptionService.
 */
class DescriptionService
{
    use XmlBaseElement;

    /**
     * @var DescriptionRepository
     */
    protected DescriptionRepository $descriptionRepository;

    /**
     * DescriptionService constructor.
     *
     * @param DescriptionRepository $descriptionRepository
     */
    public function __construct(DescriptionRepository $descriptionRepository)
    {
        $this->descriptionRepository = $descriptionRepository;
    }

    /**
     * Returns description data of an activity.
     *
     * @param int $activity_id
     *
     * @return array|null
     */
    public function getDescriptionData(int $activity_id): ?array
    {
        return $this->descriptionRepository->getDescriptionData($activity_id);
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
        return $this->descriptionRepository->getActivityData($id);
    }

    /**
     * Updates activity description.
     *
     * @param $descriptionActivity
     * @param $activity
     *
     * @return bool
     */
    public function update($descriptionActivity, $activity): bool
    {
        return $this->descriptionRepository->update($descriptionActivity, $activity);
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
        $descriptions = (array) $activity->description;

        if (count($descriptions)) {
            foreach ($descriptions as $description) {
                $activityData[] = [
                    '@attributes' => [
                        'type' => Arr::get($description, 'type', null),
                    ],
                    'narrative'   => $this->buildNarrative(Arr::get($description, 'narrative', null)),
                ];
            }
        }

        return $activityData;
    }
}
