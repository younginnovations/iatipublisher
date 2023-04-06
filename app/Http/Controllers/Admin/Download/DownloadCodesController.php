<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Download;

use App\Http\Controllers\Controller;
use App\IATI\Services\Audit\AuditService;
use App\IATI\Services\Download\CodesExport;
use App\IATI\Services\Download\DownloadCodeService;
use App\XmlImporter\Foundation\Support\Providers\XmlServiceProvider;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * Class DownloadCodesController.
 */
class DownloadCodesController extends Controller
{
    protected DownloadCodeService $downloadCodeService;

    /**
     * @var XmlServiceProvider
     */
    protected XmlServiceProvider $xmlServiceProvider;

    /**
     * @var AuditService
     */
    protected AuditService $auditService;

    /**
     * DownloadCodesController Constructor.
     *
     * @param DownloadCodeService $downloadCodeService
     * @param XmlServiceProvider $xmlServiceProvider
     * @param AuditService $auditService
     */
    public function __construct(
        DownloadCodeService $downloadCodeService,
        XmlServiceProvider $xmlServiceProvider,
        AuditService $auditService
    ) {
        $this->downloadCodeService = $downloadCodeService;
        $this->xmlServiceProvider = $xmlServiceProvider;
        $this->auditService = $auditService;
    }

    /**
     * Downloads selected activities in csv format.
     *
     * @param Request $request
     *
     * @return BinaryFileResponse|JsonResponse
     */
    public function downloadCodes(Request $request): BinaryFileResponse|JsonResponse
    {
        try {
            $activityIds = ($request->get('activities') && $request->get('activities') !== 'all') ?
            json_decode($request->get('activities'), true, 512, JSON_THROW_ON_ERROR) : [];
            // $filename = $this->downloadCodeService->getOrganizationPublisherId();
            // $activities =[];

            // if (request()->get('activities') === 'all') {
            //     $activities = $this->downloadCodeService->getAllActivitiesToDownload($this->sanitizeRequest($request));
            // } elseif (is_array($activityIds) && !empty($activityIds)) {
            //     $activities = $this->downloadCodeService->getActivitiesToDownload($activityIds);
            // }

            // $excelData = $this->downloadCodeService->getCsvData($activities);
            // if (!isset($activities) || !count($activities)) {
            //     return response()->json(['success' => false, 'message' => 'No activities selected.']);
            // }

            // $this->auditService->auditEvent($activities, 'download', 'codes');

            $codeData = $this->downloadCodeService->getActivitiesToDownload($activityIds);

            $filename = 'test.xls';

            return Excel::download(new CodesExport($codeData), $filename);
            // return $this->csvGenerator->generateWithHeaders(getTimeStampedText($filename), $excelData);
        } catch (\Exception $e) {
            dd($e);
            // logger()->error($e);
            logger()->error($e->getMessage());
            // $this->auditService->auditEvent(null, 'download', 'csv');

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
}
