<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\IATI\Models\User\User;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

/**
 * class Issue1419FillFullnameAndEmailInAuditLog.
 *
 * Issue link : https://github.com/iati/iatipublisher/issues/1419
 */
class Issue1419FillFullnameAndEmailInAuditLog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:Issue1419FillFullnameAndEmailInAuditFor';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fill fullname and email field for all existing data.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        try {
            DB::beginTransaction();

            $allUserIds = User::all()->pluck('id')->toArray();

            $this->info('Audit records updated started.');

            foreach ($allUserIds as $userId) {
                if ($userId) {
                    $user = User::find($userId);
                    $email = $user->email;
                    $fullname = $user->full_name;

                    DB::statement(
                        'UPDATE audits SET full_name = ?, email = ? WHERE user_id = ?',
                        [$fullname, $email, $userId]
                    );
                }
            }

            $this->info('Audit records updated completed.');

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            logger()->error($e);
        }
    }
}
