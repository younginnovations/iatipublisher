<?php

namespace App\Console\Commands;

use App\IATI\Models\Activity\Activity;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

/**
 * Class DeleteTargetActualData.
 */
class DeleteTargetActualData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:target-actual-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes the extra target and actual data for an activity.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        try {
            $activity = Activity::where('id', 953)->with('results.indicators.periods')->first();

            DB::beginTransaction();

            foreach ($activity->results as $result) {
                foreach ($result->indicators as $indicator) {
                    foreach ($indicator->periods as $period) {
                        $this->info("Updating period: $period->id");
                        $newData = $period->period;
                        $newData['target'] = [$newData['target'][0]];
                        $newData['actual'] = [$newData['actual'][0]];
                        $period->period = $newData;
                        $period->save();
                        $this->info("Updated period: $period->id");
                    }
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e);

            $this->error($e->getMessage());
        }
    }
}
