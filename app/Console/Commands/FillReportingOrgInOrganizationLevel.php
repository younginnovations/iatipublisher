<?php

namespace App\Console\Commands;

use App\IATI\Repositories\Activity\ActivityRepository;
use App\IATI\Repositories\Organization\OrganizationRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

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
            $data = [];

            foreach ($organizations as $organization) {
                $organization = $this->applyTemplate($reportingOrgTemplate, $organization);
                $data[] = [
                    'id'            => $organization->id,
                    'reporting_org' => $organization->reporting_org,
                ];
            }

            $this->upsert($data, ['id']);

            DB::table('activities')->where('reporting_org', null)->update(['reporting_org'=>$reportingOrgTemplate]);
            $activityRepository = app()->make(ActivityRepository::class);

            foreach ($organizations as $index => $organization) {
                $reportingOrg = $data[$index]['reporting_org'][0];
                $activityRepository->syncReportingOrg($data[$index]['id'], $reportingOrg);
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
            if ($key === 'narrative') {
                if (isset($reportingOrg[0]['narrative'])) {
                    foreach ($reportingOrg[0]['narrative'] as $index =>$narrative) {
                        if ($narrative['narrative']) {
                            $manipulatedReportingOrg[0]['narrative'][$index]['narrative'] = $narrative['narrative'];
                            $manipulatedReportingOrg[0]['narrative'][$index]['language'] = $narrative['language'] ?? '';
                        }
                    }
                }
            } else {
                $manipulatedReportingOrg[0][$key] = $key === 'ref' ? $organization->identifier : ($reportingOrg[0][$key] ?? '');
            }
        }

        $organization->reporting_org = $manipulatedReportingOrg;

        return $organization;
    }

    /**
     * Upserts rows.
     *
     * @param $data
     * @param $uniqueKeys
     *
     * @return void
     */
    public function upsert($data, $uniqueKeys): void
    {
        foreach ($data as $record) {
            $id = $record['id'];
            $reportingOrg = $record['reporting_org'];

            DB::table('organizations')
                ->updateOrInsert(
                    [$uniqueKeys[0] => $id],
                    [
                      'reporting_org' => json_encode($reportingOrg),
                      'status'        => 'draft',
                    ]
                );
        }
    }
}
