<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\IATI\Models\Activity\Activity;
use App\IATI\Services\ElementCompleteService;
use Illuminate\Console\Command;
use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * Class MakeResultCompleteCommand.
 */
class MakeResultCompleteCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'result:complete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make result element complete if all value populated';

    /**
     * Execute the console command.
     *
     * @return void
     *
     * @throws BindingResolutionException
     */
    public function handle(): void
    {
        $elementCompleteService = app()->make(ElementCompleteService::class);
        Activity::query()->chunkById(10, function ($activities) use ($elementCompleteService) {
            foreach ($activities as $activity) {
                if (count($activity->results)) {
                    $activityObj = $activity;
                    $elementStatus = $activityObj->element_status;
                    $elementStatus['result'] = $elementCompleteService->isResultElementCompleted($activityObj);
                    $activityObj->element_status = $elementStatus;
                    $activityObj->complete_percentage = $elementCompleteService->calculateCompletePercentage($activityObj->element_status);
                    $activityObj->saveQuietly();
                    $this->info('Activity: ' . $activity->id);
                }
            }
        });
    }
}
