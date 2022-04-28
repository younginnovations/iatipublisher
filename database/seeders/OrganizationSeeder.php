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
            'publisher_name' => 'test',
            'publisher_type' => 'government',
            'identifier' => Str::random(5),
            'address' => 'Kathmandu',
            'iati_status' => 'pending',
        ]);
    }
}
