<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Activity;

use App\IATI\Repositories\Repository;
use App\ValidationStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

/**
 * Class ValidationStatusRepository.
 */
class ValidationStatusRepository extends Repository
{
    /**
     * Returns ValidationStatus Model.
     *
     * @return string
     */
    public function getModel(): string
    {
        return ValidationStatus::class;
    }

    /**
     * Returns Activity validation status.
     *
     * @param int $activityId
     * @param int $userId
     *
     * @return array
     */
    public function getValidationStatus(int $activityId, int $userId): array
    {
        $status = $this->model->where('activity_id', $activityId)->where('user_id', $userId)->first();

        return $status ? $status->toArray() : [];
    }

    /**
     * Delete validation progress status.
     *
     * @param int $activityId
     * @param int $userId
     *
     * @return bool
     */
    public function deleteValidationStatus(int $activityId, int $userId)
    {
        return (bool) $this->model->where('activity_id', $activityId)->where('user_id', $userId)->delete();
    }

    /**
     * Updates the validation status.
     *
     * @param int $activityId
     * @param int $userId
     * @param string $status
     * @param array $response
     *
     * @return int
     */
    public function updateValidationStatus(int $activityId, int $userId, string $status = 'processing', array $response = []): int
    {
        return $this->model->where('user_id', $userId)
            ->where('activity_id', $activityId)
            ->update([
                'user_id'       =>  $userId,
                'activity_id'   =>  $activityId,
                'status'        =>  $status,
                'response'      =>  !empty($response) ? json_encode($response) : null,
            ]);
    }

    /**
     * Stores the validation status.
     *
     * @param int $activityId
     * @param int $userId
     * @param string $status
     * @param array $response
     *
     * @return Builder|Model
     */
    public function storeValidationStatus(int $activityId, int $userId, string $status = 'processing', array $response = []): Model|Builder
    {
        return $this->model->create([
            'user_id'       =>  $userId,
            'activity_id'   =>  $activityId,
            'status'        =>  $status,
            'response'      =>  !empty($response) ? json_encode($response) : null,
        ]);
    }

    /**
     * Returns activity status.
     *
     * @param array $activityIds
     *
     * @return array
     */
    public function getActivitiesValidationStatus(array $activityIds): array
    {
        $allCompleted = true;

        $response = [];
        $response['status'] = 'processing';
        $response['total'] = count($activityIds);
        $response['complete_count'] = 0;
        $response['failed_count'] = 0;
        $response['activities'] = [];

        $activities = $this->model->with('activity')->whereIn('activity_id', $activityIds)->get();

        if ($activities->count()) {
            $result = [];

            foreach ($activities as $activity) {
                $act = $activity->activity->title;
                $result[$activity->activity_id] = [
                    'title'  => Arr::get($act, '0.narrative', ''),
                    'status' => $activity->status,
                ];

                if ($activity->status !== 'completed') {
                    $allCompleted = false;
                }

                if ($activity->status === 'failed') {
                    $response['failed_count']++;
                }

                if ($activity->status === 'completed') {
                    $response['complete_count']++;
                }
            }

            if ($allCompleted) {
                $response['status'] = 'completed';
            } elseif ($response['failed_count'] + $response['complete_count'] === $response['total']) {
                $response['status'] = 'completed';
            }

            $response['activities'] = $result;

            return $response;
        }

        return $response;
    }

    /**
     * Get Activity Validation Responses.
     *
     * @param array $activityIds
     *
     * @return array
     */
    public function getActivitiesValidationResponse(array $activityIds): array
    {
        return $this->model->whereIn('activity_id', $activityIds)
            ->get()
            ->pluck('response')
            ->toArray();
    }

    /**
     * Count ongoing process.
     *
     * @return array
     */
    public function checkOngoingValidationStatus(): array
    {
        return $this->model->with('activity')->where('user_id', auth()->user()->id)
                            ->whereIn('status', ['processing', 'completed'])
                            ->get()
                            ->pluck('activity.default_title_narrative', 'activity_id')
                            ->toArray();
    }

    /**
     * Count ongoing process.
     *
     * @return int
     */
    public function checkPreviousValidationStatusPending(): int
    {
        return $this->model->where('user_id', auth()->user()->id)
                           ->count();
    }

    /**
     * Deletes validation responses.
     *
     * @return int
     */
    public function deleteValidationResponses(): int
    {
        return $this->model->where('user_id', auth()->user()->id)
                           ->delete();
    }
}
