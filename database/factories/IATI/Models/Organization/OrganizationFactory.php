<?php

namespace Database\Factories\IATI\Models\Organization;

use App\IATI\Models\Organization\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @extends Factory<Model>
 */
class OrganizationFactory extends Factory
{
    protected $model = Organization::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'publisher_id'        => env('IATI_YIPL_PUBLISHER_ID') . Str::random(2),
            'publisher_name'      => env('IATI_YIPL_PUBLISHER_NAME') . Str::random(2),
            'publisher_type'      => 10,
            'country'             => 'NP',
            'registration_agency' => env('IATI_YIPL_REGISTRATION_AGENCY') . Str::random(2),
            'registration_number' => env('IATI_YIPL_REGISTRATION_NUMBER') . Str::random(2),
            'identifier'          => env('IATI_YIPL_IDENTIFIER') . Str::random(2),
            'iati_status'         => 'pending',
            'status'              => 'draft',
        ];
    }
}
