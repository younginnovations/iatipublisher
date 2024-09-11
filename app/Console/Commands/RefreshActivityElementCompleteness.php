<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\IATI\Models\Activity\Activity;
use App\IATI\Services\ElementCompleteService;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\DB;

/**
 * class RefreshActivityElementCompleteness.
 */
class RefreshActivityElementCompleteness extends Command
{
    /**
     * @var string
     */
    protected $signature = 'command:RefreshActivityElementCompleteness';

    /**
     * Will refresh activity->element_status field.
     *
     * @var string
     */
    protected $description = ' Will refresh activity->element_status field.';

    /**
     * Execute the console command.
     *
     * @return void
     * @throws BindingResolutionException
     */
    public function handle(): void
    {
        /** @var ElementCompleteService $elementCompleteService */
        $elementCompleteService = app()->make(ElementCompleteService::class);

        Activity::with('transactions', 'results.indicators.periods')->latest()->chunk(100, function ($activities) use ($elementCompleteService) {
            DB::beginTransaction();
            try {
                foreach ($activities as $activity) {
                    $this->info("Started for activity: $activity->id");

                    $activityElementNames = $activity->getAttributes();
                    $elementStatus = [];

                    foreach ($activityElementNames as $element => $value) {
                        $methodName = dashesToCamelCase('is_' . $element . '_element_completed');

                        if (method_exists($elementCompleteService, $methodName)) {
                            $elementStatus[$element] = $elementCompleteService->$methodName($activity);
                        }
                    }

                    $elementStatus['result'] = $elementCompleteService->isResultElementCompleted($activity);
                    $elementStatus['transactions'] = $elementCompleteService->isTransactionsElementCompleted($activity);

                    $activity->timestamps = false;
                    $activity->updateQuietly(['element_status' => $elementStatus]);

                    $this->info("Completed for activity: $activity->id");
                    $this->info('---------------------------------------');
                }

                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();
                $this->error($e->getMessage());
            }
        });
    }
}
