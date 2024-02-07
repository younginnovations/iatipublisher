<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\IATI\Elements\Xml\XmlGenerator;
use App\IATI\Models\Activity\Activity;
use App\IATI\Models\Organization\Organization;
use Illuminate\Console\Command;

/**
 * This command implements changes to fix the bug raised in issue 1363.
 * See issue: https://github.com/younginnovations/iatipublisher/issues/1363.
 *
 * [!!WARNING!!] This is a one time use command.
 *
 * This command does the following:
 * - Fetch all activities published on and after Dec-18. (Dec-18 is the date branch 1269 was merged and sent to production.)
 * - Unpublish all activities from registry.
 * - Generate new single xmls for each activity and store them to s3.
 * - Fix merged xml that is published to registry:
 *      - Remove bugged activity nodes.
 *      - Append fixed activity node.
 * - Publish merged xml to registry.
 *
 * @class FixPublishedXmlsForIssue1363Changes
 */
class FixPublishedXmlsForIssue1363Changes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:FixPublishedXmlsForIssue1363Changes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command implements changes to fix the bug raised in issue 1363.';

    public function __construct(protected XmlGenerator $xmlGenerator)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            // TODO: Confirm list of affected activities and uncomment thi block.
            //            $activitiesMappedToOrgId = Activity::where('status', 'published')
            //                ->where('linked_to_iati', true)
            //                ->where('updated_at', '>=', '2023-12-18')
            //                ->orderBy('org_id')
            //                ->get()
            //                ->groupBy('org_id');
            // Specifically picked activity ids for testingscript.
            $activitiesMappedToOrgId = Activity::whereIn('id', [4717, 4772, 4727])->orderBy('org_id')->get()->groupBy('org_id');

            foreach ($activitiesMappedToOrgId as $orgId => $activities) {
                if ($orgId === 251) {
                    $organization = Organization::find($orgId);
                    $settings = $organization->settings;

                    try {
                        $message = "Attempting to generate merged file for OrgId: $orgId at: " . now();
                        logger($message);
                        $this->info($message);

                        $this->xmlGenerator->generateActivitiesXml($activities, $settings, $organization, false);
                    } catch (\Exception $e) {
                        $message = "Merged xml file generation failed for OrgId: $orgId  generated at: " . now();
                        logger($message);
                        logger()->error($e);
                        $this->info($message);

                        continue;
                    }

                    $message = "Merged xml file for OrgId: $orgId  generated at: " . now();
                    logger($message);
                    $this->info($message);
                }
            }
        } catch (\Exception $e) {
            logger()->error($e);
        }
    }
}
