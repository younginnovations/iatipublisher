<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Download;

use App\Http\Controllers\Controller;
use App\IATI\Services\Download\CsvGenerator;
use App\IATI\Services\Download\DownloadActivityService;
use App\XmlImporter\Foundation\Support\Providers\XmlServiceProvider;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
     * @var CsvGenerator
     */
    protected CsvGenerator $csvGenerator;

    /**
     * @var XmlServiceProvider
     */
    protected XmlServiceProvider $xmlServiceProvider;

    /**
     * DownloadActivityController Constructor.
     *
     * @param DownloadActivityService $downloadActivityService
     * @param CsvGenerator $csvGenerator
     * @param XmlServiceProvider $xmlServiceProvider
     */
    public function __construct(
        DownloadActivityService $downloadActivityService,
        CsvGenerator $csvGenerator,
        XmlServiceProvider $xmlServiceProvider
    ) {
        $this->downloadActivityService = $downloadActivityService;
        $this->csvGenerator = $csvGenerator;
        $this->xmlServiceProvider = $xmlServiceProvider;
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
            $filename = $this->downloadActivityService->getDownloadFilename($this->downloadActivityService->getOrganizationPublisherId());

            if (request()->get('activities') === 'all') {
                $activities = $this->downloadActivityService->getAllActivitiesToDownload($this->sanitizeRequest($request));
            } elseif (is_array($activityIds) && !empty($activityIds)) {
                $activities = $this->downloadActivityService->getActivitiesToDownload($activityIds);
            }

            if (!isset($activities) || !count($activities)) {
                return response()->json(['success' => false, 'message' => 'No activities selected.']);
            }

            $csvData = $this->downloadActivityService->getCsvData($activities);

            return $this->csvGenerator->generateWithHeaders($filename, $csvData, $headers);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'Error has occurred while downloading activity csv.']);
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
            $filename = $this->downloadActivityService->getDownloadFilename($this->downloadActivityService->getOrganizationPublisherId());

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

            return response($mergedContent)
                ->withHeaders([
                    'Content-Type' => 'text/xml',
                    'Cache-Control' => 'public',
                    'Content-Description' => 'File Transfer',
                    'Content-Disposition' => 'attachment; filename=' . $filename . '.xml',
                    'Content-Transfer-Encoding' => 'binary',
                ]);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

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
