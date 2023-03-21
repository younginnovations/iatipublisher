<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Repositories\Activity\ActivitySnapshotRepository;

/**
 * Class ActivitySnapshotService.
 */
class ActivitySnapshotService
{
    /**
     * @var ActivitySnapshotRepository
     */
    protected ActivitySnapshotRepository $activitySnapshotRepository;

    /**
     * @var TransactionService
     */
    protected TransactionService $transactionService;

    /**
     * @var ResultService
     */
    protected ResultService $resultService;

    /**
     * @var ActivityService
     */
    protected ActivityService $activityService;

    /**
     * @var ActivityPublishedService
     */
    protected ActivityPublishedService $activityPublishedService;

    /**
     * ActivitySnapshotService constructor.
     *
     * @param ActivitySnapshotRepository $activitySnapshotRepository
     * @param TransactionService $transactionService
     * @param ResultService $resultService
     * @param ActivityService $activityService
     * @param ActivityPublishedService $activityPublishedService
     */
    public function __construct(
        ActivitySnapshotRepository $activitySnapshotRepository,
        TransactionService $transactionService,
        ResultService $resultService,
        ActivityService $activityService,
        ActivityPublishedService $activityPublishedService
    ) {
        $this->activitySnapshotRepository = $activitySnapshotRepository;
        $this->transactionService = $transactionService;
        $this->resultService = $resultService;
        $this->activityService = $activityService;
        $this->activityPublishedService = $activityPublishedService;
    }

    /**
     * Creates or updates an activity snapshot.
     *
     * @param $activity
     *
     * @return mixed
     */
    public function createOrUpdateActivitySnapshot($activity): mixed
    {
        $activityTransactions = $this->transactionService->getActivityTransactions($activity->id)->toArray();
        $activityResults = $this->resultService->getActivityResultsWithIndicatorsAndPeriods($activity->id)->toArray();
        $activityData = $this->activityService->getActivity($activity->id)->toArray();
        unset($activityData['id'], $activityData['status'], $activityData['org_id'], $activityData['is_published'], $activityData['title_element_completed']);
        $activityData['transactions'] = $activityTransactions;
        $activityData['results'] = $activityResults;
        $filename = $this->activityPublishedService->getActivityPublished($activity->org_id)->filename;

        return $this->activitySnapshotRepository->createOrUpdateActivitySnapshot(
            $activity->org_id,
            $activity,
            $activityData,
            $filename
        );
    }

    /**
     * Inserts multiple Activity snapshots.
     *
     * @param $snapshots
     *
     * @return bool
     */
    public function insert($snapshots): bool
    {
        return $this->activitySnapshotRepository->insert($snapshots);
    }
}
