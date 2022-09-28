<?php

namespace Database\Seeders;

use App\IATI\Models\Activity\Activity;
use Illuminate\Database\Seeder;

class ActivityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Activity::create(
            [
                'iati_identifier'      => [
                    'activity_identifier'  => 'SYRZ000041',
                ],
                'title'                => [
                    [
                        'narrative' => 'DGGF Track 3',
                        'language'  => 'en',
                    ],
                ],
                'description'          => [
                    [
                        'type'      => 1,
                        'narrative' => [
                            [
                                'narrative' => 'Education and psychosocial support to children in Aleppo Governorate',
                                'language'  => '',
                            ],
                        ],
                    ],
                ],
                'activity_date'        => [
                    [
                        'date'      => '2016-10-18',
                        'type'      => '2',
                        'narrative' => [
                            [
                                'narrative' => '',
                                'language'  => '',
                            ],
                        ],
                    ],
                    [
                        'date'      => '2016-12-02',
                        'type'      => '4',
                        'narrative' => [
                            [
                                'narrative' => '',
                                'language'  => '',
                            ],
                        ],
                    ],
                ],
                'status'               => 'draft',
                'sector'               => [
                    [
                        'sector_vocabulary'    => 1,
                        'vocabulary_uri'       => '',
                        'code'          => '72050',
                        'category_code' => '',
                        'text'          => '',
                        'percentage'           => '',
                        'narrative'            => [
                            [
                                'narrative' => '',
                                'language'  => '',
                            ],
                        ],
                    ],
                ],
                'budget'               => [
                    [
                        'budget_type'  => '1',
                        'status'       => '2',
                        'period_start' => [
                            [
                                'date' => '2016-10-18',
                            ],
                        ],
                        'period_end'   => [
                            [
                                'date' => '2016-12-02',
                            ],
                        ],
                        'value'        => [
                            [
                                'amount'     => '35754',
                                'currency'   => 'GBP',
                                'value_date' => '2016-11-18',
                            ],
                        ],
                    ],
                ],
                'default_field_values' => [
                    'linked_data_uri'            => '',
                    'default_language'           => 'en',
                    'default_currency'           => 'GBP',
                    'default_hierarchy'          => '1',
                    'default_collaboration_type' => '',
                    'default_flow_type'          => '',
                    'default_finance_type'       => '',
                    'default_aid_type'           => '',
                    'default_tied_status'        => '',
                    'humanitarian'               => '1',
                ],
                'org_id'               => 1,
            ]
        );
    }
}
