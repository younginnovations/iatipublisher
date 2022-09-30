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
            'publishing_info'         => [
                'publisher_id'           => 'yipl',
                'publisher_verification' => true,
                'api_token'              => 'test',
                'token_verification'     => true,
            ],
            'default_values'          => [
                'default_currency' => 'USD',
                'default_language' => 'en',
            ],
            'activity_default_values' => [
                'hierarchy'           => '2',
                'budget_not_provided' => 'test',
                'humanitarian'        => 'no',
            ],
        ];
    }
}
