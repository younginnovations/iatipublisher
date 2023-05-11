<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Download;

use App\Http\Controllers\Controller;
use App\IATI\Services\Audit\AuditService;
use App\IATI\Services\Download\CsvGenerator;
use App\IATI\Services\Download\DownloadActivityService;
use App\IATI\Services\Download\DownloadXlsService;
use App\Jobs\ExportXlsJob;
use App\Jobs\XlsExportMailJob;
use App\Jobs\ZipXlsFileJob;
use App\XmlImporter\Foundation\Support\Providers\XmlServiceProvider;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * Class DownloadActivityController.
 */
class DownloadActivityController extends Controller
{
    /**
     * @var DownloadActivityService
     */
    protected DownloadActivityService $downloadActivityService;

    /**
     * @var DownloadXlsService
     */
    protected DownloadXlsService $downloadXlsService;

    /**
     * @var CsvGenerator
     */
    protected CsvGenerator $csvGenerator;

    /**
     * @var XmlServiceProvider
     */
    protected XmlServiceProvider $xmlServiceProvider;

    /**
     * @var AuditService
     */
    protected AuditService $auditService;

    /**
     * DownloadActivityController Constructor.
     *
     * @param DownloadActivityService $downloadActivityService
     * @param CsvGenerator $csvGenerator
     * @param XmlServiceProvider $xmlServiceProvider
     * @param AuditService $auditService
     */
    public function __construct(
        DownloadActivityService $downloadActivityService,
        CsvGenerator $csvGenerator,
        XmlServiceProvider $xmlServiceProvider,
        AuditService $auditService,
        DownloadXlsService $downloadXlsService,
    ) {
        $this->downloadActivityService = $downloadActivityService;
        $this->csvGenerator = $csvGenerator;
        $this->xmlServiceProvider = $xmlServiceProvider;
        $this->auditService = $auditService;
        $this->downloadXlsService = $downloadXlsService;
    }

    /**
     * Downloads selected activities in csv format.
     *
     * @param Request $request
     *
     * @return BinaryFileResponse|JsonResponse
     */
    public function downloadActivityCsv(Request $request): BinaryFileResponse|JsonResponse
    {
        try {
            $activityIds = ($request->get('activities') && $request->get('activities') !== 'all') ?
                json_decode($request->get('activities'), true, 512, JSON_THROW_ON_ERROR) : [];
            $headers = $this->downloadActivityService->getCsvHeaderArray('Activity', 'other_fields_transaction');
            $filename = $this->downloadActivityService->getOrganizationPublisherId();

            if (request()->get('activities') === 'all') {
                $activities = $this->downloadActivityService->getAllActivitiesToDownload($this->sanitizeRequest($request));
            } elseif (is_array($activityIds) && !empty($activityIds)) {
                $activities = $this->downloadActivityService->getActivitiesToDownload($activityIds);
            }

            if (!isset($activities) || !count($activities)) {
                return response()->json(['success' => false, 'message' => 'No activities selected.']);
            }

            $csvData = $this->downloadActivityService->getCsvData($activities);

            $this->auditService->auditEvent($activities, 'download', 'csv');

            return $this->csvGenerator->generateWithHeaders(getTimeStampedText($filename), $csvData, $headers);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());
            $this->auditService->auditEvent(null, 'download', 'csv');

            return response()->json(['success' => false, 'message' => 'Error has occurred while downloading activity csv.']);
        }
    }

    /**
     * Prepare selected activities in xls format.
     *
     * @param Request $request
     *
     * @return BinaryFileResponse|JsonResponse
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface|\Throwable
     */
    public function prepareActivityXls(Request $request):  BinaryFileResponse|JsonResponse
    {
        try {
            $userId = auth()->user()->id;
            $awsStatusFile = awsGetFile("Xls/$userId/status.json");

            if (!empty($awsStatusFile) && json_decode($awsStatusFile, true, 512, JSON_THROW_ON_ERROR)['message'] === 'Processing') {
                return response()->json(['success' => false, 'message' => 'Previous Download on process']);
            }

            $activityIds = ($request->get('activities') && $request->get('activities') !== 'all') ?
                json_decode($request->get('activities'), true, 512, JSON_THROW_ON_ERROR) : [];

            if (request()->get('activities') === 'all') {
                $activities = $this->downloadActivityService->getAllActivitiesQueryToDownload($this->sanitizeRequest($request), auth()->user());
            } elseif (!empty($activityIds)) {
                $activities = $this->downloadActivityService->getActivitiesQueryToDownload($activityIds, auth()->user());
            }

            if (!isset($activities) || !$activities->count()) {
                return response()->json(['success' => false, 'message' => 'No activities selected.']);
            }

            $this->clearPreviousXlsFilesOnS3($userId);

            $this->downloadXlsService->storeStatus($userId);
            awsUploadFile("Xls/$userId/status.json", json_encode(['success' => true, 'message' => 'Processing'], JSON_THROW_ON_ERROR));
            $this->processXlsExportJobs($request);

            return response()->json(['success' => true, 'message' => 'Xls Export on process.']);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());
            $this->downloadXlsService->deleteDownloadStatus(auth()->user()->id);
            $this->cancelXlsDownload();

            return response()->json(['success' => false, 'message' => 'Error has occurred while downloading activity Xls.']);
        }
    }

    /**
     * Exports xls in queue.
     *
     * @param $request
     *
     * @return void
     */
    public function processXlsExportJobs($request): void
    {
        ExportXlsJob::withChain([
            new ZipXlsFileJob(auth()->user()->id),
           new XlsExportMailJob(auth()->user()->email, auth()->user()->username, auth()->user()->id),
        ])->dispatch($request->all(), auth()->user()->toArray());
    }

    /**
     * Downloads xls zip file from aws s3.
     *
     * @param Request $request
     *
     * @return bool|int
     */
    public function downloadActivityXls(Request $request): bool|int
    {
        $userId = auth()->user()->id;

        if (!$request->hasValidSignature()) {
            abort(403);
        }

        $temporaryUrl = awsUrl("Xls/$userId/xlsFiles.zip");
        header('Content-Disposition: attachment; filename=xlsFiles.zip');
        header('Content-Type: application/zip');
        $this->downloadXlsService->deleteDownloadStatus($userId);

        return readfile($temporaryUrl);
    }

    /**
     * Download api to check the progress of a xls export.
     *
     * @return JsonResponse
     */
    public function xlsDownloadInProgressStatus(): JsonResponse
    {
        try {
            [$status, $fileCount, $url] = $this->downloadXlsService->getDownloadStatus();

            return response()->json(['success' => true, 'message' => 'Download status accessed successfully', 'status' => $status, 'file_count' => $fileCount, 'url' => $url ?? null]);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'Error has occured while trying to check download status']);
        }
    }

    /**
     * Checks if the status is completed
     * if completed then do not upload cancel json else upload.
     *
     *
     * @return JsonResponse|void
     */
    public function cancelXlsDownload()
    {
        try {
            $userId = auth()->user()->id;
            $status = $this->downloadXlsService->getDownloadStatus();
            $this->downloadXlsService->deleteDownloadStatus($userId);
            $this->clearPreviousXlsFilesOnS3($userId);

            if ($status->status !== 'completed') {
                awsUploadFile("Xls/$userId/cancelStatus.json", json_encode(['success' => true, 'message' => 'Cancelled'], JSON_THROW_ON_ERROR));
            }

            return response()->json(['success' => true, 'message' => 'Cancelled Successfully']);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());
        }
    }

    /**
     * Downloads selected activities in xml format.
     *
     * @param Request $request
     * @param bool $download
     *
     * @return Response|JsonResponse
     */
    public function downloadActivityXml(Request $request, bool $download = false): Response|JsonResponse
    {
        try {
            $activityIds = ($request->get('activities') && $request->get('activities') !== 'all') ?
                json_decode($request->get('activities'), true, 512, JSON_THROW_ON_ERROR) : [];
            $filename = $this->downloadActivityService->getOrganizationPublisherId();

            if (request()->get('activities') === 'all') {
                $activities = $this->downloadActivityService->getAllActivitiesToDownload($this->sanitizeRequest($request));
            } elseif (is_array($activityIds) && !empty($activityIds)) {
                $activities = $this->downloadActivityService->getActivitiesToDownload($activityIds);
            }

            if (!isset($activities) || !count($activities)) {
                return response()->json(['success' => false, 'message' => 'No activities selected.']);
            }

            $mergedContent = $this->downloadActivityService->getCombinedXmlFile($activities);

            if (!$download && !$this->xmlServiceProvider->isValidAgainstSchema($mergedContent)) {
                return response()->json(['success' => false, 'xml_error' => true, 'message' => json_encode(libxml_get_errors(), JSON_THROW_ON_ERROR)]);
            }

            $this->auditService->auditEvent($activities, 'download', 'xml');

            return response($mergedContent)
                ->withHeaders([
                    'Content-Type' => 'text/xml',
                    'Cache-Control' => 'public',
                    'Content-Description' => 'File Transfer',
                    'Content-Disposition' => 'attachment; filename=' . getTimeStampedText($filename) . '.xml',
                    'Content-Transfer-Encoding' => 'binary',
                ]);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());
            $this->auditService->auditEvent(null, 'download', 'xml');

            return response()->json(['success' => false, 'message' => 'Error has occurred while downloading activity csv.']);
        }
    }

    /**
     * Sanitizes the request for removing code injections.
     *
     * @param $request
     *
     * @return array
     */
    public function sanitizeRequest($request): array
    {
        $tableConfig = getTableConfig('activity');
        $queryParams = [];

        if (!empty($request->get('q')) || $request->get('q') === '0') {
            $queryParams['query'] = $request->get('q');
        }

        if (in_array($request->get('orderBy'), $tableConfig['orderBy'], true)) {
            $queryParams['orderBy'] = $request->get('orderBy');

            if (in_array($request->get('direction'), $tableConfig['direction'], true)) {
                $queryParams['direction'] = $request->get('direction');
            }
        }

        return $queryParams;
    }

    public function clearPreviousXlsFilesOnS3($userId): void
    {
        awsDeleteFile("Xls/$userId/xlsFiles.zip");
        awsDeleteFile("Xls/$userId/status.json");
        awsDeleteFile("Xls/$userId/cancelStatus.json");
    }
}
