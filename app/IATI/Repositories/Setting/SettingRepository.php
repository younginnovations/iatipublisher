<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Setting;

use App\IATI\Models\Setting\Setting;
use App\IATI\Repositories\Repository;

/**
 * Class SettingRepository.
 */
class SettingRepository extends Repository
{
    public function getModel():string
    {
        return Setting::class;
    }

    public function updateSetting($id, $data)
    {
        return $this->model->updateOrCreate(['organization_id' => $id], $data);
    }
}
