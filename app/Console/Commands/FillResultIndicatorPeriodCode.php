<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\IATI\Models\Activity\Indicator;
use App\IATI\Models\Activity\Period;
use App\IATI\Models\Activity\Result;
use DB;
use Illuminate\Console\Command;

/**
 * Class FillResultIndicatorPeriodCode.
 */
class FillResultIndicatorPeriodCode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:fillCode';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fill code in pre-existing result, indicator and period';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        try {
            DB::beginTransaction();

            $results = Result::whereNull('result_code')->get();
            $indicators = Indicator::whereNull('indicator_code')->get();
            $periods = Period::whereNull('period_code')->get();

            foreach ($results as $result) {
                $result->result_code = $result->id . time();
                $result->timestamps = false;
                $result->saveQuietly(['touch' => false]);
            }

            foreach ($indicators as $indicator) {
                $indicator->indicator_code = $indicator->id . time();
                $indicator->timestamps = false;
                $indicator->saveQuietly(['touch' => false]);
            }

            foreach ($periods as $period) {
                $period->period_code = $period->id . time();
                $period->timestamps = false;
                $period->saveQuietly(['touch' => false]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            logger()->error($e);
        }
    }
}
