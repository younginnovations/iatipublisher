<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Setting;

use App\IATI\Models\Setting\Setting;
use App\IATI\Repositories\Repository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SettingRepository.
 */
class SettingRepository extends Repository
{
    /**
     * Get model name with namespace.
     *
     * @return string
     */
    public function getModel(): string
    {
        return Setting::class;
    }

    /**
     * Create or Update specific setting.
     *
     * @param array $data
     * @param       $id
     *
     * @return Model
     */
    public function updateSetting($id, $data): Model
    {
        return $this->model->updateOrCreate(['organization_id' => $id], $data);
    }

    /**
     * Find setting with organization id.
     *
     * @param $id
     *
     * @return Model
     */
    public function findByOrganization($id): ?Model
    {
        return $this->model->where('organization_id', $id)->first();
    }
}
