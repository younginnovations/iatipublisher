<?php

declare(strict_types=1);

namespace App\IATI\Services\ImportActivityError;

use App\IATI\Repositories\Import\ImportActivityErrorRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ImportActivityErrorervice.
 */
class ImportActivityErrorService
{
    /**
     * @var ImportActivityErrorRepository
     */
    protected ImportActivityErrorRepository $importActivityErrorRepository;

    /**
     * ActivityValidatorService Constructor.
     *
     * @param ImportActivityErrorRepository $importActivityErrorRepository
     */
    public function __construct(ImportActivityErrorRepository $importActivityErrorRepository)
    {
        $this->importActivityErrorRepository = $importActivityErrorRepository;
    }

    /**
     * Creates or updates updates error.
     *
     * @param $activity_id
     * @param $error
     *
     * @return Model|bool
     */
    public function updateOrCreateError($activity_id, $error): Model|bool
    {
        return $this->importActivityErrorRepository->updateOrCreateError($activity_id, $error);
    }

    /**
     * Returns import activity error.
     *
     * @param $activityId
     *
     * @return Model|null
     */
    public function getImportActivityError($activityId): ?Model
    {
        return $this->importActivityErrorRepository->getImportActivityError($activityId);
    }

    /**
     * Delete Upload Error having $activityId.
     *
     * @param mixed $activityId
     *
     * @return bool
     */
    public function deleteImportError($activityId) : bool
    {
        return $this->importActivityErrorRepository->deleteImportError($activityId);
    }
}
