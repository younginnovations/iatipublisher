<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\IATI\Models\User\Role;
use App\IATI\Models\User\User;
use Illuminate\Console\Command;

/**
 * Class CreateSuperAdmin.
 */
class CreateSuperAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:superadmin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a Super Admin user';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        User::create([
            'username'  => 'superadmin',
            'full_name' => 'superadmin',
            'email'     => 'superadmin@gmail.com',
            'address'   => 'kathmandu',
            'is_active' => true,
            'password'  => bcrypt('password'),
            'role_id'   => app(Role::class)->getSuperAdminId(),
        ]);
    }
}
