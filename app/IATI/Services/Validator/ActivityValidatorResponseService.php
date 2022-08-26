<?php

declare(strict_types=1);

namespace App\IATI\Services\Validator;

use App\IATI\Repositories\Validator\ActivityValidatorResponseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ActivityValidatorResponseService.
 */
class ActivityValidatorResponseService
{
    /**
     * @var ActivityValidatorResponseRepository
     */
    protected ActivityValidatorResponseRepository $activityValidatorResponseRepository;

    /**
     * ActivityValidatorService Constructor.
     *
     * @param ActivityValidatorResponseRepository $activityValidatorResponseRepository
     */
    public function __construct(ActivityValidatorResponseRepository $activityValidatorResponseRepository)
    {
        $this->activityValidatorResponseRepository = $activityValidatorResponseRepository;
    }

    /**
     * Creates or updates validator response.
     *
     * @param $activity_id
     * @param $response
     *
     * @return Model|bool
     */
    public function updateOrCreateResponse($activity_id, $response): Model|bool
    {
        return $this->activityValidatorResponseRepository->updateOrCreateResponse($activity_id, $response);
    }

    /**
     * Returns validator response object.
     *
     * @param $activityId
     *
     * @return Model|null
     */
    public function getValidatorResponse($activityId): ?Model
    {
        return $this->activityValidatorResponseRepository->getValidatorResponse($activityId);
    }

    /**
     * Deletes the validator response of the unpublished activity.
     *
     * @param $activityId
     *
     * @return bool
     */
    public function deleteValidatorResponse($activityId): bool
    {
        return $this->activityValidatorResponseRepository->deleteValidatorResponse($activityId);
    }
}
