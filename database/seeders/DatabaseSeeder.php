<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if ((env('APP_ENV') == 'local') || (env('APP_ENV') == 'staging') || (env('APP_ENV') == 'dev')) {
            $this->call([
                RoleTableSeeder::class,
                OrganizationSeeder::class,
                UserSeeder::class,
                ActivityTableSeeder::class,
            ]);
        }
    }
}
