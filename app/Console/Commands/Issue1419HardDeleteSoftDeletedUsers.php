<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\IATI\Models\User\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

/**
 * class Issue1419HardDeleteSoftDeletedUsers.
 *
 * Issue link : https://github.com/younginnovations/iatipublisher/issues/1419
 */
class Issue1419HardDeleteSoftDeletedUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:Issue1419HardDeleteSoftDeletedUsersFor';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove all soft deleted users.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        try {
            DB::beginTransaction();
            $softDeletedUsers = User::where('deleted_at', '!=', null)->get();

            if ($softDeletedUsers->isEmpty()) {
                $this->info('No soft-deleted users found.');

                return;
            }

            $this->info('Purging soft-deleted users...');

            foreach ($softDeletedUsers as $user) {
                $user->forceDelete(); // Permanently delete soft-deleted user
            }
            $this->info('Soft-deleted users purged successfully.');
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            logger()->error($e);
        }
    }
}
