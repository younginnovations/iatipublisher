<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::table('organizations')->insert([
            'publisher_id' => Str::random(5),
            'publisher_name' => 'yipl',
            'publisher_type' => 'government',
            'country' => 'IN',
            'registration_agency' => 'AF-COA',
            'registration_number' => '5',
            'identifier' => Str::random(5),
            'status' => 'verified',
        ]);
    }
}
