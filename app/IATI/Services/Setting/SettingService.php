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
            'publishing_info' => [
                'publisher_id' => Auth::user()->organization->publisher_id,
                'api_token' => $data['api_token'],
                'publisher_verification' => $data['publisher_verification'],
                'token_verification' => $data['token_verification'],
            ],
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
            'default_values'          => [
                'default_currency' => isset($data['default_currency']) ? $data['default_currency'] : '',
                'default_language' => $data['default_language'],
            ],
            'activity_default_values' => [
                'hierarchy' => isset($data['hierarchy']) ? $data['hierarchy'] : 1,
                'humanitarian' => isset($data['humanitarian']) ? $data['humanitarian'] : 'yes',
                'budget_not_provided' => isset($data['budget_not_provided']) ? $data['budget_not_provided'] : '',
            ],
        ]);
    }

    /**
     * Return array containing status of default and publisher information.
     *
     * @return array
     */
    public function getStatus(): array
    {
        $setting = $this->getSetting();

        return [
            'default_status'   => $setting && $this->defaultSettingsCompleted($setting->default_values, $setting->activity_default_values),
            'publisher_status' => $setting && $setting['publishing_info'] ? ($setting['publishing_info']['api_token'] && $setting['publishing_info']['token_verification'] ? true : false) : false,
            'token_status' => $setting['publishing_info']['token_verification'],
        ];
    }

    /**
     * Checks if default settings is completed or not.
     *
     * @param $default_values
     * @param $activity_default_values
     *
     * @return bool
     */
    public function defaultSettingsCompleted($default_values, $activity_default_values): bool
    {
        if (!$default_values || !$activity_default_values) {
            return false;
        }

        unset($activity_default_values['budget_not_provided']);

        return !in_array(null, array_values($default_values), true) &&
               !in_array('', array_values($default_values), true) &&
               !in_array(null, array_values($activity_default_values), true) &&
               !in_array('', array_values($activity_default_values), true);
    }
}
