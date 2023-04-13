<?php

namespace App\Console\Commands;

use App\IATI\Models\Activity\Indicator;
use App\IATI\Models\Activity\Period;
use App\IATI\Models\Activity\Result;
use DB;
use Illuminate\Console\Command;

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

            Result::whereNull('result_code')->get()->each->save();
            Indicator::whereNull('indicator_code')->get()->each->save();
            Period::whereNull('period_code')->get()->each->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            logger()->error($e);
        }
    }
}
