<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Validator;

use App\IATI\Models\Validator\IATIValidatorResponse;
use App\IATI\Repositories\Repository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ActivityValidatorRepository.
 */
class ActivityValidatorResponseRepository extends Repository
{
    /**
     * Returns activity model.
     *
     * @return string
     */
    public function getModel(): string
    {
        return IATIValidatorResponse::class;
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
        return $this->model->updateOrCreate(
            ['activity_id' => $activity_id],
            ['response' => $response]
        );
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
        return $this->model->where('activity_id', $activityId)->first();
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
        $validatorResponse = $this->model->where('activity_id', $activityId)->first();

        if ($validatorResponse) {
            return $validatorResponse->delete();
        }

        return false;
    }
}
