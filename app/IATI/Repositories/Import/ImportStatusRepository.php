<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Import;

use App\IATI\Models\Import\ImportStatus;
use App\IATI\Repositories\Repository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ImportStatusRepository.
 */
class ImportStatusRepository extends Repository
{
    /**
     * Returns activity model.
     *
     * @return string
     */
    public function getModel(): string
    {
        return ImportStatus::class;
    }

    /**
     * Returns import status.
     *
     * @param $organizationId
     * @param $userId
     *
     * @return array
     */
    public function getImportStatus($organizationId, $userId): array
    {
        $status = $this->model->where('organization_id', $organizationId)->where('user_id', $userId)->first();

        return $status ? $status->toArray() : [];
    }

    /**
     * Delete import status for organization with $organizationId and $userId.
     *
     * @param $organizationId
     * @param $userId
     *
     * @return bool
     */
    public function deleteImportStatus($organizationId, $userId): bool
    {
        return (bool) $this->model->where('organization_id', $organizationId)->where('user_id', $userId)->delete();
    }

    /**
     * Create import status.
     *
     * @param $organizationId
     * @param $userId
     * @param $fileType
     * @param $template
     * @param $status
     *
     * @return Model
     */
    public function storeStatus($organizationId, $userId, $fileType, $template = 'activity', $status = 'processing'): ?Model
    {
        return $this->model->create([
            'organization_id' => $organizationId,
            'user_id' => $userId,
            'status' => $status,
            'type' => $fileType,
            'template' => $template,
        ]);
    }
}
