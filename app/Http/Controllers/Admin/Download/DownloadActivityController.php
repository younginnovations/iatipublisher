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
            $activityIds = $request->get('activities') ?
                json_decode($request->get('activities'), true, 512, JSON_THROW_ON_ERROR) : [];

            if (is_array($activityIds) && !empty($activityIds)) {
                $activities = $this->downloadActivityService->getActivitiesToDownload($activityIds);

                if (!count($activities)) {
                    return response()->json(['success' => false, 'message' => 'No activities selected.']);
                }

                $csvData = $this->downloadActivityService->getCsvData($activities);
                $headers = $this->downloadActivityService->getCsvHeaderArray('Activity', 'other_fields_transaction');

                return $this->csvGenerator->generateWithHeaders('activities', $csvData, $headers);
            }

            return response()->json(['success' => false, 'message' => 'No activities selected.']);
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
            $activityIds = $request->get('activities') ?
                json_decode($request->get('activities'), true, 512, JSON_THROW_ON_ERROR) : [];

            if (is_array($activityIds) && !empty($activityIds)) {
                $activities = $this->downloadActivityService->getActivitiesToDownload($activityIds);

                if (!count($activities)) {
                    return response()->json(['success' => false, 'message' => 'No activities selected.']);
                }

                $mergedContent = $this->downloadActivityService->getCombinedXmlFile($activities);

                if (!$download && !$this->xmlServiceProvider->isValidAgainstSchema($mergedContent)) {
                    return response()->json(['success' => false, 'message' => json_encode(libxml_get_errors(), JSON_THROW_ON_ERROR)]);
                }

                return response($mergedContent)
                    ->withHeaders([
                        'Content-Type' => 'text/xml',
                        'Cache-Control' => 'public',
                        'Content-Description' => 'File Transfer',
                        'Content-Disposition' => 'attachment; filename=' . 'success' . '.xml',
                        'Content-Transfer-Encoding' => 'binary',
                    ]);
            }

            return response()->json(['success' => false, 'message' => 'No activities selected.']);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'Error has occurred while downloading activity csv.']);
        }
    }
}
