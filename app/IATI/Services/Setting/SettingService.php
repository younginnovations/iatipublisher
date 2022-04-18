<?php

declare(strict_types=1);

namespace App\IATI\Services\Setting;

use App\IATI\Repositories\Setting\SettingRepository;
use Illuminate\Support\Facades\Auth;

/**
 * Class Sett.
 */
class SettingService
{
    /**
     * @var SettingRepository
     */
    private $settingRepo;

    /**
     * Sett constructor.
     *
     * @param SettingRepository $settingRepo
     */
    public function __construct(SettingRepository $settingRepo)
    {
        $this->settingRepo = $settingRepo;
    }

    /**
     * Store user.
     *
     * @param array $data
     */
    public function storePublishingInfo(array $data)
    {
        return $this->settingRepo->updateSetting(Auth::user()->organization_id, [
          'organization_id' => Auth::user()->organization_id,
          'publishing_info' => json_encode([
                                'publisher_id'=> $data['publisher_id'],
                                'api_token'=> $data['api_token'],
                              ]),
        ]);
    }

    /**
     * Store user.
     *
     * @param array $data
     */
    public function storeDefaultValues(array $data)
    {
        return $this->settingRepo->updateSetting(Auth::user()->organization_id, [
          'organization_id' => Auth::user()->organization_id,
          'default_values' => json_encode([
                                'default_currency'=> $data['default_currency'],
                                'default_language'=> $data['default_language'],
                              ]),
          'activity_default_values' => json_encode([
                                    'linked_data_url' => $data['linked_data_url'],
                                    'humanitarian' => $data['humanitarian'],
                                  ]),
        ]);
    }
}
