<?php

namespace Database\Factories\IATI\Models\Setting;

use App\IATI\Models\Setting\Setting;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;

/**
 * @extends Factory<Model>
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
                'publisher_id'           => env('IATI_YIPL_PUBLISHER_ID'),
                'publisher_verification' => true,
                'api_token'              => env('IATI_API_KEY'),
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
