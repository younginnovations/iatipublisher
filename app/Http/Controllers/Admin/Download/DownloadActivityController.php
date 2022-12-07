<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Download;

use App\Http\Controllers\Controller;
use App\IATI\Services\Download\CsvGenerator;
use App\IATI\Services\Download\DownloadActivityService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
     * DownloadActivityController Constructor.
     *
     * @param DownloadActivityService $downloadActivityService
     * @param CsvGenerator $csvGenerator
     */
    public function __construct(
        DownloadActivityService $downloadActivityService,
        CsvGenerator $csvGenerator
    ) {
        $this->downloadActivityService = $downloadActivityService;
        $this->csvGenerator = $csvGenerator;
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
}
