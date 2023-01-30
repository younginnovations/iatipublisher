<?php

declare(strict_types=1);

namespace App\Http\Controllers\IatiApiLog;

use App\Http\Controllers\Controller;
use App\IATI\Services\IatiApiLog\IatiApiLogService;
use Exception;
use Illuminate\Http\JsonResponse;

/**
 * Class iatiApiLogController.
 */
class IatiApiLogController extends Controller
{
    /**
     * @var IatiiatiApiLogService
     */
    protected $iatiApiLog;

    /**
     * iatiApiLogController constructor.
     *
     * @param IatiiatiApiLogService $iatiApiLog
     */
    public function __construct(IatiApiLogService $iatiApiLog)
    {
        $this->iatiApiLog = $iatiApiLog;
    }

    /**
     * Renders api log listing page.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function index()
    {
        //
    }

    /**
     * Returns data from api log datatables.
     *
     * @return JsonResponse
     * @throws \Throwable
     */
    public function getData(): JsonResponse
    {
        try {
            return response()->json(['success' => true, 'message' => $this->iatiApiLog->getAllApiLogs()]);
        } catch (Exception $e) {
            logger()->error($e);

            return response()->json([
               'success' => false,
               'message' => 'Error has occurred while fetching iati api log',
            ]);
        }
    }
}
