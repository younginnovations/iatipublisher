<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\IATI\Repositories\Activity\ActivityRepository;
use App\IATI\Repositories\Organization\OrganizationRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

/*
 * Class FillReportingOrgInOrganizationLevel.
 */
class FillReportingOrgInOrganizationLevel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:FillReportingOrgInOrganizationLevel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fills reporting org data for data older than March-10, 2023';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        try {
            DB::beginTransaction();
            $reportingOrgTemplate = [
                [
                    'ref'=>'',
                    'type'=>'',
                    'secondary_reporter'=>'',
                    'narrative'=>[],
                ],
            ];
            $organizations = app()->make(OrganizationRepository::class)->all();
            $activityRepository = app()->make(ActivityRepository::class);

            foreach ($organizations as $organization) {
                $organization = $this->applyTemplate($reportingOrgTemplate, $organization);
                $organization->updateOrInsert(
                    ['id' => $organization->id],
                    [
                        'reporting_org' => json_encode($organization->reporting_org),
                        'status'        => 'draft',
                    ]
                );

                $reportingOrg = $organization->reporting_org[0];
                $activityModel = (new ($activityRepository->getModel()));

                $activityModel->whereNull('reporting_org')->update(['reporting_org'=>$organization->reporting_org]);
                $activityRepository->syncReportingOrg($organization->id, $reportingOrg);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e);
        }
    }

    /**
     * Apply template and fill data in template.
     *
     * @param $template
     * @param $organization
     *
     * @return mixed
     */
    public function applyTemplate($template, $organization): mixed
    {
        $reportingOrg = $organization->reporting_org;
        $manipulatedReportingOrg = $template;

        foreach ($template[0] as $key => $item) {
            if (($key === 'narrative') && isset($reportingOrg[0]['narrative'])) {
                if (is_array($reportingOrg[0]['narrative']) || is_object($reportingOrg[0]['narrative'])) {
                    foreach ((array) $reportingOrg[0]['narrative'] as $index =>$narrative) {
                        if ($narrative['narrative']) {
                            $manipulatedReportingOrg[0]['narrative'][$index]['narrative'] = $narrative['narrative'];
                            $manipulatedReportingOrg[0]['narrative'][$index]['language'] = $narrative['language'] ?? '';
                        }
                    }
                } else {
                    $manipulatedReportingOrg[0]['narrative'] = [['narrative'=>'', 'language'=>'']];
                }
            } else {
                $manipulatedReportingOrg[0][$key] = $key === 'ref' ? $organization->identifier : ($reportingOrg[0][$key] ?? '');
            }
        }

        $organization->reporting_org = $manipulatedReportingOrg;

        return $organization;
    }
}
