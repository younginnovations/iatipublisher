<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Repositories\Activity\ActivityRepository;
use Illuminate\Support\Arr;

/**
 * Class ActivityDefaultService.
 */
class ActivityDefaultService
{
    /**
     * ActivityDefaultService constructor.
     *
     * @param ActivityRepository $activityRepository
     */
    public function __construct(public ActivityRepository $activityRepository)
    {
        //
    }

    /**
     * Returns activity default field values.
     *
     * @param $activityId
     *
     * @return null|array
     */
    public function getActivityDefaultValues($activityId): ?array
    {
        return $this->activityRepository->find($activityId)->default_field_values;
    }

    /**
     * Updates activity default values.
     *
     * @param array $data
     * @param $activityId
     *
     * @return bool
     */
    public function updateActivityDefaultValues($activityId, array $data): bool
    {
        $defaultFieldValues = [
            'default_field_values' => [
                'default_currency'    => $data['default_currency'] ?? '',
                'default_language'    => $data['default_language'] ?? '',
                'hierarchy'           => $data['hierarchy'] ?? 1,
                'humanitarian'        => Arr::get($data, 'humanitarian'),
                'budget_not_provided' => $data['budget_not_provided'] ?? '',
            ],
        ];

        if (isset($data['budget_not_provided']) && $data['budget_not_provided'] === '1') {
            $activity = $this->activityRepository->find($activityId);
            $elementStatus = $activity->element_status;
            $elementStatus['budget'] = true;
            $defaultFieldValues['element_status'] = $elementStatus;
        }

        return $this->activityRepository->update($activityId, $defaultFieldValues);
    }
}
