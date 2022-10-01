<?php

namespace Database\Seeders;

use Database\Seeders\Fakers\ActivityTableFaker;
use Database\Seeders\Fakers\OrganizationTableFaker;
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

        if (app()->environment('production')) {
            $this->call([UserTableSeeder::class]);
        }

        if (app()->environment(['local', 'staging', 'dev'])) {
            $this->call(
                [
                OrganizationTableFaker::class,
                ActivityTableFaker::class, ]
            );
        }
    }
}
