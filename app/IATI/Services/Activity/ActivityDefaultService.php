<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Repositories\Activity\ActivityRepository;

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
                'humanitarian'        => $data['humanitarian'] ?? '1',
                'budget_not_provided' => $data['budget_not_provided'] ?? '',
            ],
        ];

        if (isset($data['budget_not_provided'])) {
            if ($data['budget_not_provided'] === '1') {
                $activity = $this->activityRepository->find($activityId);
                $elementStatus['element_status'] = $activity->element_status;
                $elementStatus['element_status']['budget'] = true;
                $defaultFieldValues = array_merge($defaultFieldValues, $elementStatus);
            }
        }

        return $this->activityRepository->update($activityId, $defaultFieldValues);
    }
}
