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
     * @throws \JsonException
     */
    public function definition(): array
    {
        return [
            'publisher_id'        => env('IATI_YIPL_PUBLISHER_ID'),
            'publisher_name'      => env('IATI_YIPL_PUBLISHER_NAME'),
            'publisher_type'      => 10,
            'country'             => 'NP',
            'registration_agency' => env('IATI_YIPL_REGISTRATION_AGENCY'),
            'registration_number' => env('IATI_YIPL_REGISTRATION_NUMBER'),
            'identifier'          => env('IATI_YIPL_IDENTIFIER'),
            'iati_status'         => 'pending',
            'status'              => 'draft',
        ];
    }

    /**
     * @return Factory
     */
    public function reportingOrg(): Factory
    {
        $reporting_org = [
            [
                'ref' => 'org-ref-1',
                'type' => '70',
                'secondary_reporter' => null,
                'narrative' => [
                    [
                        'narrative' => 'organization narrative',
                        'language' => 'ae',
                    ],
                ],
            ],
        ];

        return $this->state(function () use ($reporting_org) {
            return [
                'reporting_org' => $reporting_org,
            ];
        });
    }
}
