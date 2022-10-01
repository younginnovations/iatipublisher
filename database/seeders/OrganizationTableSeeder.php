<?php

namespace Database\Seeders;

use App\IATI\Models\Organization\Organization;
use Illuminate\Database\Seeder;

/**
 * Class UserTableSeeder.
 */
class OrganizationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $org = Organization::factory()->make([
            'publisher_id'=>'YIPL-Super',
            'publisher_name'=>'Younginnovations',
            'identifier'=>'NP-SWC-123', ])->toArray();

        Organization::firstOrCreate($org, $org);
    }
}
