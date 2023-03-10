<?php

declare(strict_types=1);

namespace App\IATI\Repositories\ImportActivityError;

use App\IATI\Models\ImportActivityError\ImportActivityError;
use App\IATI\Repositories\Repository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ImportActivityErrorRepository.
 */
class ImportActivityErrorRepository extends Repository
{
    /**
     * Returns activity model.
     *
     * @return string
     */
    public function getModel(): string
    {
        return ImportActivityError::class;
    }

    /**
     * Creates or updates activity errors found during import.
     *
     * @param $activity_id
     * @param $error
     *
     * @return Model|bool
     */
    public function updateOrCreateError($activity_id, $error): Model|bool
    {
        return $this->model->updateOrCreate(
            ['activity_id' => $activity_id],
            ['error' => $error]
        );
    }

    /**
     * Returns errors.
     *
     * @param $activityId
     *
     * @return Model|null
     */
    public function getImportActivityError($activityId): ?Model
    {
        return $this->model->where('activity_id', $activityId)->first();
    }

    /**
     * Delete import error of activity with $activityId.
     *
     * @param $activityId
     *
     * @return bool
     */
    public function deleteImportError($activityId): bool
    {
        return (bool) $this->model->where('activity_id', $activityId)->delete();
    }
}
