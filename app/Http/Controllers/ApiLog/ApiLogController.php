<?php

declare(strict_types=1);

namespace App\Http\Controllers\ApiLog;

use App\Http\Controllers\Controller;
use App\IATI\Services\ApiLog\ApiLogService;
use Exception;
use Illuminate\Http\JsonResponse;

/**
 * Class ApiLogController.
 */
class ApiLogController extends Controller
{
    /**
     * @var ApiLogService
     */
    protected $apiLog;

    /**
     * ApiLogController constructor.
     *
     * @param IatiApiLogService $apiLog
     */
    public function __construct(ApiLogService $apiLog)
    {
        $this->apiLog = $apiLog;
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
            return response()->json(['success' => true, 'message' => $this->apiLog->getAllApiLogs()]);
        } catch (Exception $e) {
            logger()->error($e->getMessage());

            return response()->json([
               'success' => false,
               'message' => trans('requests.error_has_occured_while_trying_to_fetch_iati_api_log'),
            ]);
        }
    }
}
