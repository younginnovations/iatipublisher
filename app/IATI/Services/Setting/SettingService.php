<?php

declare(strict_types=1);

namespace App\IATI\Services\Setting;

use App\IATI\Models\Setting\Setting;
use App\IATI\Repositories\Setting\SettingRepository;
use Illuminate\Support\Facades\Auth;

/**
 * Class SettingService.
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
     *
     * @return Setting
     */
    public function getSetting(): ?Setting
    {
        return $this->settingRepo->findByOrganization(Auth::user()->organization_id);
    }

    /**
     * Store publishing info.
     *
     * @param array $data
     *
     * @return Setting
     */
    public function storePublishingInfo(array $data): Setting
    {
        return $this->settingRepo->updateSetting(Auth::user()->organization_id, [
            'organization_id' => Auth::user()->organization_id,
            'publishing_info' => json_encode([
                'publisher_id' => Auth::user()->organization->publisher_id,
                'api_token' => $data['api_token'],
                'publisher_verification' => $data['publisher_verification'],
                'token_verification' => $data['token_verification'],
            ]),
        ]);
    }

    /**
     * Store default values.
     *
     * @param array $data
     *
     * @return Setting
     */
    public function storeDefaultValues(array $data): Setting
    {
        return $this->settingRepo->updateSetting(Auth::user()->organization_id, [
            'organization_id'         => Auth::user()->organization_id,
            'default_values'          => json_encode([
                'default_currency' => isset($data['default_currency']) ? $data['default_currency'] : '',
                'default_language' => $data['default_language'],
            ]),
            'activity_default_values' => json_encode([
                'hierarchy' => isset($data['hierarchy']) ? $data['hierarchy'] : 1,
                'linked_data_url' => $data['linked_data_url'],
                'humanitarian' => $data['humanitarian'],
            ]),
        ]);
    }
}
