<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Class RoleTableSeeder.
 */
class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            ['role' => 'admin', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
