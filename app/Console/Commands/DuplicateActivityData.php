<?php

namespace App\Console\Commands;

use App\IATI\Models\Activity\Activity;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

/**
 * Class DuplicateActivityData.
 */
class DuplicateActivityData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'duplicate:activity-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Duplicates activity data';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $activity_id = $this->ask('Insert activity id to duplicate');
            $no_of_iterations = $this->ask('Insert number of iterations');

            DB::beginTransaction();
            $activity = Activity::where('id', $activity_id)->with(['transactions', 'results.indicators.periods'])->first();

            for ($i = 1; $i <= $no_of_iterations; $i++) {
                $this->info('Duplicating activity no ' . $i);
                $newActivity = $activity->replicate();
                $newActivity->title = $this->getTitleData($activity->title, $i);
                $newActivity->iati_identifier = $this->getIatiIdentifier($activity->iati_identifier, $i);
                $newActivity->push();

                $this->duplicateTransactions($newActivity, $activity->transactions);
                $this->duplicateResults($newActivity, $activity->results);
                $this->info('Duplicated activity no ' . $i);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e);

            $this->error($e->getMessage());
        }
    }

    public function getIatiIdentifier($oldIdentifier, $amount)
    {
        $newIdentifier = $oldIdentifier;
        $newIdentifier['activity_identifier'] = $this->getIncrementedData($oldIdentifier['activity_identifier'], $amount);
        $newIdentifier['iati_identifier_text'] = $this->getIncrementedData($oldIdentifier['iati_identifier_text'], $amount);

        return $newIdentifier;
    }

    public function getTitleData($oldTitle, $amount)
    {
        $newTitle = $oldTitle;
        $newTitle[0]['narrative'] = $this->getIncrementedData($oldTitle[0]['narrative'], $amount);

        return $newTitle;
    }

    public function getIncrementedData($data, $amount)
    {
        $array = explode('-', $data);
        $array[array_key_last($array)] = (int) $array[array_key_last($array)] + $amount;

        return implode('-', $array);
    }

    public function duplicateTransactions($newActivity, $oldTransactions)
    {
        foreach ($oldTransactions as $transaction) {
            $this->info('Duplicating transaction ' . $transaction->id);
            $newTransaction = $transaction->replicate();
            $newTransaction->activity_id = $newActivity->id;
            $newTransaction->save();
            $this->info('Duplicated transaction ' . $transaction->id);
        }
    }

    public function duplicateResults($newActivity, $oldResults)
    {
//        $count = 0;

        foreach ($oldResults as $result) {
//            if ($count <= 5) {
            $this->info('Duplicating result ' . $result->id);
            $newResult = $result->replicate();
            $newResult->activity_id = $newActivity->id;
            $newResult->save();

            $this->duplicateIndicators($newResult, $result->indicators);
            $this->info('Duplicated result ' . $result->id);
//                $count++;
//            }
        }
    }

    public function duplicateIndicators($newResult, $oldIndicators)
    {
        foreach ($oldIndicators as $indicator) {
            $this->info('Duplicating indicator ' . $indicator->id);
            $newIndicator = $indicator->replicate();
            $newIndicator->result_id = $newResult->id;
            $newIndicator->save();

            $this->duplicatePeriods($newIndicator, $indicator->periods);
            $this->info('Duplicated indicator ' . $indicator->id);
        }
    }

    public function duplicatePeriods($newIndicator, $oldPeriods)
    {
        foreach ($oldPeriods as $period) {
            $this->info('Duplicating period ' . $period->id);
            $newPeriod = $period->replicate();
            $newPeriod->indicator_id = $newIndicator->id;
            $newPeriod->save();
            $this->info('Duplicated period ' . $period->id);
        }
    }
}
