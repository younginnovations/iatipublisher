<?php

declare(strict_types=1);

namespace App\IATI\Services\ImportActivity;

use App\IATI\Repositories\Activity\ActivityRepository;
use App\IATI\Repositories\Activity\IndicatorRepository;
use App\IATI\Repositories\Activity\PeriodRepository;
use App\IATI\Repositories\Activity\ResultRepository;
use App\IATI\Repositories\Activity\TransactionRepository;
use App\IATI\Repositories\Import\ImportActivityErrorRepository;
use App\IATI\Repositories\Import\ImportStatusRepository;
use App\XlsImporter\Events\XlsWasUploaded;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class XmlImportManager.
 */
class ImportXlsService
{
    /**
     * Temporary Xml file storage location.
     */
    public string $xls_file_storage_path;

    /**
     * Temporary Xml data storage location.
     */
    public string $xls_data_storage_path;

    /**
     * @var ActivityRepository
     */
    protected ActivityRepository $activityRepository;

    /**
     * @var TransactionRepository
     */
    protected TransactionRepository $transactionRepository;

    /**
     * @var ResultRepository
     */
    protected ResultRepository $resultRepository;

    /**
     * @var PeriodRepository
     */
    protected PeriodRepository $periodRepository;

    /**
     * @var IndicatorRepository
     */
    protected IndicatorRepository $indicatorRepository;

    /**
     * @var ImportActivityErrorRepository
     */
    protected ImportActivityErrorRepository $importActivityErrorRepo;

    /**
     * @var ImportStatusRepository
     */
    protected ImportStatusRepository $importStatusRepo;

    /**
     * XmlImportManager constructor.
     *
     * @param ActivityRepository    $activityRepository
     * @param TransactionRepository $transactionRepository
     * @param ResultRepository      $resultRepository
     * @param PeriodRepository      $periodRepository
     * @param IndicatorRepository   $indicatorRepository
     * @param ImportActivityErrorRepository  $importActivityErrorRepo
     * @param ImportStatusRepository  $importStatusRepo
     * @param XmlService            $xmlService
     */
    public function __construct(
        ActivityRepository $activityRepository,
        TransactionRepository $transactionRepository,
        ResultRepository $resultRepository,
        PeriodRepository $periodRepository,
        IndicatorRepository $indicatorRepository,
        ImportActivityErrorRepository $importActivityErrorRepo,
        ImportStatusRepository $importStatusRepo
    ) {
        $this->transactionRepository = $transactionRepository;
        $this->activityRepository = $activityRepository;
        $this->resultRepository = $resultRepository;
        $this->indicatorRepository = $indicatorRepository;
        $this->importActivityErrorRepo = $importActivityErrorRepo;
        $this->importStatusRepo = $importStatusRepo;
        $this->periodRepository = $periodRepository;
        $this->xls_file_storage_path = env('XLS_FILE_STORAGE_PATH', 'XlsImporter/file');
        $this->xls_data_storage_path = env('XLS_DATA_STORAGE_PATH', 'XlsImporter/tmp');
    }

    /**
     * Temporarily store the uploaded Xml file.
     *
     * @param UploadedFile $file
     *
     * @return bool
     */
    public function store(UploadedFile $file): bool
    {
        try {
            awsDeleteDirectory(sprintf('%s/%s/%s', $this->xls_file_storage_path, Auth::user()->organization_id, Auth::user()->id));

            return awsUploadFile(sprintf('%s/%s/%s/%s', $this->xls_file_storage_path, Auth::user()->organization_id, Auth::user()->id, $file->getClientOriginalName()), $file->getContent());
        } catch (Exception $exception) {
            logger()->error(
                sprintf('Error uploading Xls file due to %s', $exception->getMessage()),
                [
                    'trace' => $exception->getTraceAsString(),
                    'user' => auth()->user()->id,
                ]
            );

            return false;
        }
    }

    /**
     * Create Valid activities.
     *
     * @param $activities
     * @param $xlsType
     *
     * @return bool
     * @throws \JsonException
     */
    public function create($activities, $xlsType): bool
    {
        $userId = Auth::user()->id;
        $organizationId = Auth::user()->organization->id;
        $contents = json_decode(awsGetFile(sprintf('%s/%s/%s/%s', $this->xls_data_storage_path, $organizationId, $userId, 'valid.json')), false, 512, 0);

        if ($xlsType === 'activitites') {
            foreach ($activities as $value) {
                $activity = unsetErrorFields($contents[$value]);
                $activityData = Arr::get($activity, 'data', []);
                $organizationId = Auth::user()->organization->id;

                if (Arr::get($activity, 'existence', false) || $this->activityRepository->getActivityWithIdentifier($organizationId, Arr::get($activityData, 'iati_identifier.activity_identifier'))) {
                    $oldActivity = $this->activityRepository->getActivityWithIdentifier($organizationId, Arr::get($activityData, 'iati_identifier.activity_identifier'));

                    $this->activityRepository->update($oldActivity->id, $activityData);
                    $this->transactionRepository->deleteTransaction($oldActivity->id);
                    $this->resultRepository->deleteResult($oldActivity->id);
                    $this->saveTransactions(Arr::get($activityData, 'transactions'), $oldActivity->id);
                    $this->saveResults(Arr::get($activityData, 'result'), $oldActivity->id);

                    if (!empty($activity['errors'])) {
                        $this->importActivityErrorRepo->updateOrCreateError($oldActivity->id, $activity['errors']);
                    } else {
                        $this->importActivityErrorRepo->deleteImportError($oldActivity->id);
                    }
                } else {
                    $activityData['org_id'] = $organizationId;
                    $storeActivity = $this->activityRepository->store($activityData);

                    $this->saveTransactions(Arr::get($activityData, 'transactions'), $storeActivity->id);
                    $this->saveResults(Arr::get($activityData, 'result'), $storeActivity->id);

                    if (!empty($activity['errors'])) {
                        $this->importActivityErrorRepo->updateOrCreateError($storeActivity->id, $activity['errors']);
                    }
                }
            }
        } elseif ($xlsType === 'result') {
            $identifiers = $this->dbIatiIdentifiers($organizationId, 'activity');

            foreach ($activities as $value) {
                $activity = unsetErrorFields($contents[$value]);
                $resultData = Arr::get($activity, 'data', []);
                $organizationId = Auth::user()->organization->id;
                $existenceId = Arr::get($activity, 'existence', false);
                $parentIdentifier = Arr::get($activity, 'parentIdentifier', false);

                if ($existenceId) {
                    $this->resultRepository->update($existenceId, ['indicator' => $resultData]);
                } else {
                    $this->resultRepository->store(['indicator' => $resultData, 'activity_id' => $identifiers[$parentIdentifier]]);
                }
            }
        } elseif ($xlsType === 'indicator') {
            $identifiers = $this->dbIatiIdentifiers($organizationId, 'result');

            foreach ($activities as $value) {
                $activity = unsetErrorFields($contents[$value]);
                $indicatorData = Arr::get($activity, 'data', []);
                $organizationId = Auth::user()->organization->id;
                $existenceId = Arr::get($activity, 'existence', false);
                $parentIdentifier = Arr::get($activity, 'parentIdentifier', false);

                if ($existenceId) {
                    $this->indicatorRepository->update($existenceId, ['indicator' => $indicatorData]);
                } else {
                    dd($identifiers, $parentIdentifier);
                    $this->indicatorRepository->store(['indicator' => $indicatorData, 'result_id' => $identifiers[$parentIdentifier]]);
                }
            }
        } elseif ($xlsType === 'period') {
            $identifiers = $this->dbIatiIdentifiers($organizationId, 'indicator');

            foreach ($activities as $value) {
                $activity = unsetErrorFields($contents[$value]);
                $periodData = Arr::get($activity, 'data', []);
                $organizationId = Auth::user()->organization->id;
                $existenceId = Arr::get($activity, 'existence', false);
                $parentIdentifier = Arr::get($activity, 'parentIdentifier', false);

                if ($existenceId) {
                    $this->periodRepository->update($existenceId, ['period' => $periodData]);
                } else {
                    $this->periodRepository->store(['period' => $periodData, 'indicator_id' => $identifiers[$parentIdentifier]]);
                }
            }
        }

        return true;
    }

    /**
     * Save transaction of mapped activity in database.
     *
     * @param $transactions
     * @param $activityId
     *
     * @return $this
     */
    protected function saveTransactions($transactions, $activityId): static
    {
        $transactionList = [];

        if ($transactions) {
            foreach ($transactions as $transaction) {
                $transactionList[] = [
                    'activity_id' => $activityId,
                    'transaction' => json_encode($transaction),
                ];
            }

            $this->transactionRepository->upsert($transactionList, 'id');
        }

        return $this;
    }

    /**
     * Save result of mapped activity in database.
     *
     * @param $results
     * @param $activityId
     *
     * @return $this
     */
    protected function saveResults($results, $activityId): static
    {
        if ($results) {
            $resultWithoutIndicator = [];

            foreach ($results as $result) {
                $result = (array) $result;
                $indicators = Arr::get($result, 'indicator', []);
                unset($result['indicator']);

                if (!empty($indicators)) {
                    $savedResult = $this->resultRepository->store([
                        'activity_id' => $activityId,
                        'result' => $result,
                    ]);

                    foreach ($indicators as $indicator) {
                        $indicator = (array) $indicator;
                        $periods = Arr::get($indicator, 'period', []);
                        $tempPeriod = [];
                        unset($indicator['period']);

                        $savedIndicator = $this->indicatorRepository->store([
                            'result_id' => $savedResult['id'],
                            'indicator' => $indicator,
                        ]);

                        if (!empty($periods)) {
                            foreach ($periods as $period) {
                                $tempPeriod[] = [
                                    'period' => $period,
                                ];
                            }

                            $savedIndicator->periods()->createMany($tempPeriod);
                        }
                    }
                } else {
                    $resultWithoutIndicator[] = [
                        'activity_id' => $activityId,
                        'result' => json_encode($result),
                    ];
                }
            }

            $this->resultRepository->upsert($resultWithoutIndicator, 'id');
        }

        return $this;
    }

    /**
     * @param $filename
     * @param $userId
     * @param $orgId
     * @param $xlsType
     *
     * @return void
     * @throws \JsonException
     */
    public function startImport($filename, $userId, $orgId, $xlsType): void
    {
        awsDeleteDirectory(sprintf('%s/%s/%s', $this->xls_data_storage_path, $orgId, $userId));
        awsUploadFile(sprintf('%s/%s/%s/%s', $this->xls_data_storage_path, $orgId, $userId, 'status.json'), json_encode(['success' => true, 'message' => 'Started'], JSON_THROW_ON_ERROR));
        $status = $this->importStatusRepo->storeStatus($orgId, $userId, 'xls', $xlsType);

        $this->fireXmlUploadEvent($filename, $userId, $orgId, $xlsType);
        $this->importStatusRepo->update($status->id, ['status' => 'completed']);
    }

    /**
     * Fire the XmlWasUploaded event.
     *
     * @param $filename
     * @param $userId
     * @param $organizationId
     * @param $xlsType
     *
     * @return void
     */
    protected function fireXmlUploadEvent($filename, $userId, $organizationId, $xlsType): void
    {
        $iatiIdentifiers = $this->dbIatiIdentifiers($organizationId, $xlsType);
        $orgRef = Auth::user()->organization->identifier;

        Event::dispatch(new XlsWasUploaded($filename, $userId, $organizationId, $orgRef, $iatiIdentifiers, $xlsType));
    }

    /**
     * Returns array of iati identifiers and codes present in the activities, result, indicator and period of the organisation.
     *
     * @param $org_id
     * @param $xlsType
     *
     * @return array
     */
    public function dbIatiIdentifiers($org_id, $type): array
    {
        $identifier = [];

        switch ($type) {
            case 'activity':
                $identifier = $this->getActivityIdentifier($org_id, $type);
                break;
            case 'result':
                $identifier = $this->getResultIdentifier($org_id, $type);
                break;
            case 'indicator':
                $identifier = $this->getIndicatorIdentifier($org_id, $type);
                break;
            case 'period':
                $identifier = $this->getPeriodIdentifier($org_id, $type);
                break;
        }

        return $identifier;
    }

    /**
     * Return activity identifier.
     *
     * @param $org_id
     * @param $type
     *
     * @return array
     */
    public function getActivityIdentifier($org_id, $type): array
    {
        $identifier = [];
        $activities = $this->activityRepository->getActivityIdentifiers($org_id);

        foreach ($activities as $activity) {
            $identifier[$activity->identifier] = $activity->id;
        }

        return $identifier;
    }

    /**
     * Return result identifier.
     *
     * @param $org_id
     * @param $type
     *
     * @return array
     */
    public function getResultIdentifier($org_id, $type): array
    {
        $identifier = [];
        $activities = $this->activityRepository->getActivityIdentifiers($org_id);

        foreach ($activities as $activity) {
            $results = $activity->results;

            foreach ($results as $result) {
                $identifier[sprintf('%s_%s', $activity->identifier, $result->result_code)] = $result->id;
            }
        }

        return $identifier;
    }

    /**
     * Return indicator identifier.
     *
     * @param $org_id
     * @param $type
     *
     * @return array
     */
    public function getIndicatorIdentifier($org_id, $type): array
    {
        $identifier = [];
        $activities = $this->activityRepository->getActivityIdentifiers($org_id);

        foreach ($activities as $activity) {
            $results = $activity->results;

            foreach ($results as $result) {
                $indicators = $result->indicators;

                foreach ($indicators as $indicator) {
                    $identifier[sprintf('%s_%s_%s', $activity->identifier, $result->result_code, $indicator->indicator_code)] = $indicator->id;
                }
            }
        }

        return $identifier;
    }

    /**
     * Return period identifier.
     *
     * @param $org_id
     * @param $type
     *
     * @return array
     */
    public function getPeriodIdentifier($org_id, $type): array
    {
        $identifier = [];
        $activities = $this->activityRepository->getActivityIdentifiers($org_id);

        foreach ($activities as $activity) {
            $results = $activity->results;

            foreach ($results as $result) {
                $indicators = $result->indicators;

                foreach ($indicators as $indicator) {
                    $periods = $indicator->periods;

                    foreach ($periods as $period) {
                        $identifier[sprintf('%s_%s_%s_%s', $activity->identifier, $result->result_code, $indicator->indicator_code, $period->period_code)] = $indicator->id;
                    }
                }
            }
        }

        return $identifier;
    }

    /**
     * Returns import status.
     *
     * @return array
     */
    public function getImportStatus(): array
    {
        return $this->importStatusRepo->getImportStatus(Auth::user()->organization->id, Auth::user()->id);
    }

    /**
     * Deletes import status.
     *
     * @return bool
     */
    public function deleteImportStatus(): bool
    {
        return $this->importStatusRepo->deleteImportStatus(Auth::user()->organization->id, Auth::user()->id);
    }

    public function getAwsXlsData($filename)
    {
        try {
            $contents = awsGetFile(sprintf('%s/%s/%s/%s', $this->xls_data_storage_path, Auth::user()->organization_id, Auth::user()->id, $filename));

            if ($contents) {
                return json_decode($contents, false, 512, JSON_THROW_ON_ERROR);
            }

            return false;
        } catch (Exception $exception) {
            logger()->error(
                sprintf('Error due to %s', $exception->getMessage()),
                [
                    'trace' => $exception->getTraceAsString(),
                    'user_id' => auth()->user()->id,
                    'filename' => $filename,
                ]
            );

            return null;
        }
    }
}
