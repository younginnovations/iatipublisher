<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
            'username'  => 'yipl_user',
            'email'     => 'yipl_user@gmail.com',
            'full_name' => 'Young Innovations',
            'address'   => 'Mahalaxmisthan, Lalitpur',
            'is_active' => true,
            'role_id'   => 1,
            'password' => '$2y$10$fBoForhr0zI7L/iZB7paFeZBjtln6.2JH5g/9GJPKh5jAuLsf32Aq',
        ]);
    }
}
