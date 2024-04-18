<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\IATI\Models\Audit\Audit;
use App\IATI\Models\User\User;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

/**
 * class Issue1419FillFullnameAndEmailInAuditLog.
 *
 * Issue link : https://github.com/younginnovations/iatipublisher/issues/1419
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
            $allUserIdsUsedInAudit = Audit::all()->pluck('user_id');
            $allUserIdsUsedInAudit = array_values(array_unique($allUserIdsUsedInAudit->toArray()));
            $allUserIdsUsedInAudit = array_values(array_filter($allUserIdsUsedInAudit, static function ($value) {
                return $value !== null;
            }));

            $fullnameMappedToId = User::whereIn('id', $allUserIdsUsedInAudit)->pluck('full_name', 'id')->toArray();
            $emailMappedToId = User::whereIn('id', $allUserIdsUsedInAudit)->pluck('email', 'id')->toArray();

            $insertValuesMappedToId = [];

            $this->info('Required data fetched.');

            foreach ($allUserIdsUsedInAudit as $id) {
                if ($id && in_array($id, $allUserIds, true)) {
                    $insertValuesMappedToId[$id] = [
                        'full_name' => $fullnameMappedToId[$id],
                        'email' => $emailMappedToId[$id],
                    ];
                }
            }

            $this->info('Required data parsed.');

            foreach ($insertValuesMappedToId as $userId => $values) {
                Audit::where('user_id', $userId)->update($values);
                $this->info("Audit record for user_id: $userId completed.");
            }

            $this->info('Audit records updated successfully.');

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            logger()->error($e);
        }
    }
}
