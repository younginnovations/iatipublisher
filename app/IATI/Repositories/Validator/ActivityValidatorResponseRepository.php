<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Validator;

use App\IATI\Models\Validator\IATIValidatorResponse;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ActivityValidatorRepository.
 */
class ActivityValidatorResponseRepository
{
    /**
     * @var IATIValidatorResponse
     */
    protected IATIValidatorResponse $activityValidatorResponse;

    /**
     * ActivityValidatorRepository Constructor.
     *
     * @param IATIValidatorResponse $activityValidatorResponse
     */
    public function __construct(IATIValidatorResponse $activityValidatorResponse)
    {
        $this->activityValidatorResponse = $activityValidatorResponse;
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
        return $this->activityValidatorResponse->updateOrCreate(
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
        return $this->activityValidatorResponse->where('activity_id', $activityId)->first();
    }
}
