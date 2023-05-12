<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Download;

use App\IATI\Models\Download\DownloadStatus;
use App\IATI\Repositories\Repository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class XlsDownloadStatusRepository.
 */
class XlsDownloadStatusRepository extends Repository
{
    /**
     * Returns download status model.
     *
     * @return string
     */
    public function getModel(): string
    {
        return DownloadStatus::class;
    }

    /**
     * Returns download status.
     *
     * @param $userId
     * @param $fileType
     *
     * @return array|null
     */
    public function getDownloadStatus($userId, $fileType): ?array
    {
        $status = $this->model->where('user_id', $userId)->where('type', $fileType)->first();

        return [$status->status ?? null, $status->file_count ?? 0, $status->url ?? null];
    }

    public function getDownloadStatusObject($userId, $fileType)
    {
        return $this->model->where('user_id', $userId)->where('type', $fileType)->first();
    }

    /**
     * Delete download status of user after completion.
     *
     * @param $userId
     *
     * @return bool
     */
    public function deleteDownloadStatus($userId): bool
    {
        return (bool) $this->model->where('user_id', $userId)->delete();
    }

    /**
     * Create download status.
     *
     * @param $userId
     * @param $fileType
     * @param string $status
     *
     * @return Model|null
     */
    public function storeStatus($userId, $fileType, string $status = 'processing'): ?Model
    {
        return $this->model->create([
            'user_id' => $userId,
            'status' => $status,
            'type' => $fileType,
            'file_count' => 0,
//            'url' => route('admin.activities.download-xls'),
        ]);
    }

    /**
     * Increments file count after every file generates.
     *
     * @param $userId
     * @param $fileType
     *
     * @return false|int
     */
    public function incrementFileCount($userId, $fileType)
    {
        $status = $this->model->where('user_id', $userId)->where('type', $fileType)->first();

        return $status->increment('file_count');
    }

    public function updateDownloadStatus($userId, $data)
    {
        return (bool) $this->model->where('user_id', $userId)->update($data);
    }
}
