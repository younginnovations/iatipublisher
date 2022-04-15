<?php

declare(strict_types=1);

namespace App\IATI\Services\Setting;

use App\IATI\Repositories\Setting\SettingRepository;

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
    public function store(array $data)
    {
        $this->settingRepo->store([
        'organization_id' => $data['organization_id'],
        'publishing_info' => [
          'publisher_id'=> $data['publisher_id'],
          'api_token'=> $data['api_token'],
        ],
        'default_values' => [
          'default_currency'=> $data['default_currency'],
          'default_language'=> $data['default_language'],
        ],
        'activity_default_values' => [
          'linked_data_url' => $data['linked_data_url'],
          'humanitarian' => $data['humanitarian'],
        ],
        ]);

        return $this->settingRepo->store($data);
    }

    /**
     * Stores the user that exists in IATI.
     *
     * @param array $data
     */
    public function update(int $id, array $data)
    {
        //   $this->settingRepo->update($id, [
      //   'organization_id' => $data['organization_id'],
      //   'default_currency' => $data['default_currency'],
      //   'default_currency' => $data['default_currency'],
      //   'default_language' => $data['default_language'],
      //   'linked_data_url' => $data['linked_data_url'],
      //   'humanitarian' => $data['humanitarian'],
      // ]);
    }
}
