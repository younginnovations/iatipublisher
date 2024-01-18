<?php

namespace App\Console\Commands;

use App\IATI\Models\Organization\Organization;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use PHPUnit\Exception;

class FillDataForIssue1343Changes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:FillDataForIssue1343Changes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fills activity identifier data for activity and organization for change related to issue #1343';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            DB::beginTransaction();
            $this->info('Filling data for Issue 1343 changes...');
            $organizations = Organization::all();

            foreach ($organizations as $organization) {
                $orgActivities = $organization->allActivities;

                foreach ($orgActivities as $activity) {
                    $activityIdentifier = $activity->iati_identifier['activity_identifier'];
                    $organizationIdentifier = $organization->identifier;

                    $iatiIdentifier = [
                        'activity_identifier'             => $activityIdentifier,
                        'iati_identifier_text'            => $organizationIdentifier . '-' . $activityIdentifier,
                        'present_organization_identifier' => $organizationIdentifier,
                        'updated_at'                      => $activity->created_at,
                    ];

                    $hasEverBeenPublished = $activity->linked_to_iati;

                    $activity->timestamps = false;
                    $activity->updateQuietly(['iati_identifier' => $iatiIdentifier, 'has_ever_been_published' => $hasEverBeenPublished]);
                }
            }

            DB::commit();
            $this->info('Data filled successfully.');
        } catch(Exception $e) {
            DB::rollback();
            logger()->info($e);
        }
    }
}
