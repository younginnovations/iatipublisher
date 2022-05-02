<?php

namespace Database\Factories\IATI\Models\Setting;

use App\IATI\Models\Setting\Setting;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Model>
 */
class SettingFactory extends Factory
{
    protected $model = Setting::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'organization_id' => 1,
            'publishing_info' => json_encode([
                'publisher_id' => 'yipl',
                'publisher_verification' => true,
                'api_token' => 'test',
                'token_verification' => true,
            ]),
            'default_values'  => json_encode([
                'default_currency' => 'BND',
                'default_language' => 'ae',
            ]),
            'activity_default_values'  => json_encode([
                'hierarchy' => '2',
                'linked_data_url' => 'test',
                'humanitarian' => 'no',
            ]),
        ];
    }
}
