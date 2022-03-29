<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'username' => 'admin',
            'full_name' => 'admin',
            'email' => 'admin@gmail.com',
            'organization_id' => 1,
            'address' => 'kathmandu',
            'is_active' => true,
            'password' => Hash::make('password'),
        ]);
    }
}
