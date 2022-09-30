<?php

namespace Database\Factories\IATI\Models\Organization;

use App\IATI\Models\Organization\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;

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
            'publisher_id'        => env('IATI_YIPL_PUBLISHER_ID'),
            'publisher_name'      => env('IATI_YIPL_PUBLISHER_NAME'),
            'publisher_type'      => 'government',
            'country'             => 'NP-SWO',
            'registration_agency' => 'AF-COA',
            'registration_number' => '5',
            'identifier'          => env('IATI_YIPL_IDENTIFIER'),
            'iati_status'         => 'pending',
            'status'              => 'draft',
        ];
    }
}
