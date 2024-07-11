<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\IATI\Models\Activity\Activity;
use App\IATI\Models\Activity\Indicator;
use App\IATI\Models\Activity\Period;
use App\IATI\Models\Activity\Result;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class Issue1407CheckUseOfUpdatedIatiCodelists extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:Issue1407CheckUseOfUpdatedIatiCodelists';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh deprecation list for data prior to this change.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $dataModelMappedToHelperMidfix = [
            'activity'  => Activity::class,
            'result'    => Result::class,
            'indicator' => Indicator::class,
            'period'    => Period::class,
        ];

        $AttributesMappedToHelperMidfix = [
            'activity'    => [
                'id',
                'iati_identifier',
                'other_identifier',
                'title',
                'description',
                'activity_status',
                'status',
                'activity_date',
                'contact_info',
                'activity_scope',
                'participating_org',
                'recipient_country',
                'recipient_region',
                'location',
                'sector',
                'country_budget_items',
                'humanitarian_scope',
                'policy_marker',
                'collaboration_type',
                'default_flow_type',
                'default_finance_type',
                'default_aid_type',
                'default_tied_status',
                'budget',
                'planned_disbursement',
                'capital_spend',
                'document_link',
                'related_activity',
                'legacy_data',
                'conditions',
                'org_id',
                'default_field_values',
                'tag',
                'reporting_org',
            ],
            'result'      => ['id', 'result'],
            'indicator'   => ['id', 'indicator'],
            'period'      => ['id', 'period'],
            'transaction' => ['id', 'transaction'],
        ];

        try {
            DB::beginTransaction();

            foreach ($dataModelMappedToHelperMidfix as $key => $model) {
                $columns = $AttributesMappedToHelperMidfix[$key];

                $model::select($columns)->chunkById(10, function ($chunkedRecords) use ($model, $key) {
                    foreach ($chunkedRecords as $record) {
                        $this->info("Processing {$model} ID: {$record->id}");

                        $record->timestamps = false;

                        if ($key === 'activity') {
                            $element = $record->toArray();
                        } else {
                            $element = Arr::get($record->toArray(), $key, []);
                        }

                        /** Call helper here */
                        $helperFunctionName = 'refresh' . ucfirst($key) . 'DeprecationStatusMap';

                        if (is_callable($helperFunctionName)) {
                            $record->updateQuietly(
                                ['deprecation_status_map' => call_user_func($helperFunctionName, $element)],
                                ['touch' => false]
                            );
                        }
                    }
                });
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            logger()->error($e);
        }
    }
}
