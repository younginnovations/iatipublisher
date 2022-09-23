<?php

namespace Database\Factories\IATI\Models\Organization;

use App\IATI\Models\Organization\Organization;
use App\Model;
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
            'publisher_id'        => 'ztest',
            'publisher_name'      => Str::random(10),
            'publisher_type'      => 'government',
            'country'             => 'NP-SWO',
            'registration_agency' => 'AF-COA',
            'registration_number' => '5',
            'identifier'          => Str::random(10),
            'iati_status'         => 'pending',
            'status'              => 'draft',
        ];
    }
}
