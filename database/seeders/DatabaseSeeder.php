<?php

namespace Database\Seeders;

use App\IATI\Models\Activity\Activity;
use App\IATI\Models\Activity\Transaction;
use App\IATI\Models\Organization\Organization;
use App\IATI\Models\Setting\Setting;
use App\IATI\Models\User\Role;
use App\IATI\Models\User\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call([RoleTableSeeder::class]);

        if (env('APP_ENV') === 'production') {
            Role::factory()->create(['role' => 'superadmin']);
        }

        if ((env('APP_ENV') === 'local') || (env('APP_ENV') === 'staging') || (env('APP_ENV') === 'dev')) {
            $org = Organization::factory()->has(User::factory(['role_id' => app(Role::class)->getOrganizationAdminId()]))->has(Setting::factory())->create();
            $activity_attr = [
                'org_id'               => $org->id,
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
                        'sector_code'          => '72050',
                        'sector_category_code' => '',
                        'sector_text'          => '',
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
            ];
            Activity::factory()->count(25)->has(Transaction::factory())->create($activity_attr);
        }
    }
}
