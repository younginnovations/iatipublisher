<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Download;

use App\IATI\Models\Download\DownloadStatus;
use App\IATI\Repositories\Repository;
use Illuminate\Database\Eloquent\Builder;
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

    /**
     * Resets download status back to starting point.
     *
     * @param $userId
     * @param $fileType
     *
     * @return array|null
     */
    public function resetDownloadStatus($userId, $fileType): ?array
    {
        $status = $this->model->where('user_id', $userId)->where('type', $fileType)->first();

        if (!empty($status)) {
            $status->update(['file_count' => 0, 'status' => 'processing']);

            return $status->selected_activities ?? null;
        }

        return null;
    }

    /**
     * Returns download status.
     *
     * @param $userId
     * @param $fileType
     *
     * @return Builder|Model|null
     */
    public function getDownloadStatusObject($userId, $fileType): Model|Builder|null
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
     * @param $selected_activities
     * @param string $status
     *
     * @return Model|null
     */
    public function storeStatus($userId, $fileType, $selected_activities, string $status = 'processing'): ?Model
    {
        return $this->model->updateOrCreate(['user_id' => $userId], [
            'user_id' => $userId,
            'status' => $status,
            'type' => $fileType,
            'file_count' => 0,
            'selected_activities' => $selected_activities ?? null,
        ]);
    }

    /**
     * Increments file count after every file generates.
     *
     * @param $userId
     * @param $fileType
     *
     * @return void
     */
    public function incrementFileCount($userId, $fileType): void
    {
        $status = $this->model->where('user_id', $userId)->where('type', $fileType)->first();

        if (!empty($status) && $status->file_count < 4) {
            $status->increment('file_count');
        }
    }

    /**
     * Updates download process of a user.
     *
     * @param $userId
     * @param $data
     *
     * @return bool
     */
    public function updateDownloadStatus($userId, $data): bool
    {
        return (bool) $this->model->where('user_id', $userId)->update($data);
    }
}
