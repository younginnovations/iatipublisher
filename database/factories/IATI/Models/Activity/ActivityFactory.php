<?php

namespace Database\Factories\IATI\Models\Activity;

use App\IATI\Models\Activity\Activity;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Model>
 */
class ActivityFactory extends Factory
{
    protected $model = Activity::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'identifier' => [
                'activity_identifier'   => 'SYRZ000041',
                'iati_identifier_text'  => 'CZ-ICO-25755277-SYRZ000041',
            ],
            'title' => [
              [
                  'narrative'           => 'DGGF Track 3',
                  'en'                  => 'en',
              ],
            ],
            'org_id'    => 1,
        ];
    }
}
