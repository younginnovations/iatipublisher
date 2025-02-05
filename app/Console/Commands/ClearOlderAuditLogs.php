<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * @class ClearOlderAuditLogs
 *
 * Used in app/Console/Kernel.php. Scheduled to on the first of every month.
 */
class ClearOlderAuditLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:ClearOlderAuditLogs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear audit logs older than one month. See issue: https://github.com/IATI/iatipublisher/issues/1456';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        DB::beginTransaction();

        try {
            $date = Carbon::now()->subMonth();

            DB::table('audits')->where('created_at', '<', $date)->delete();

            logger()->info('Successfully cleared audit logs older than one month.');

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            logger()->error('Error clearing audit logs: ' . $e->getMessage());
        }
    }
}
