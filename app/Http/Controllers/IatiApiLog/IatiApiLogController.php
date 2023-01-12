<?php

declare(strict_types=1);

namespace App\Http\Controllers\IatiApiLog;

use App\Http\Controllers\Controller;
use App\IATI\Services\IatiApiLog\IatiApiLogService;
use Exception;
use Illuminate\Http\Request;

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
        return view('admin.log.api.index');
    }

    /**
     * Returns data from api log datatables.
     *
     * @param Request $request
     *
     * @return JsonResponse|\Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function getData(Request $request)
    {
        try {
            $filters = $request->all();
            $logs = $this->iatiApiLog->getFilteredLog($filters);

            $json_data = [
                'draw'              => intval($request->input('draw')),
                'recordsTotal'      => $logs['count'],
                'recordsFiltered'   => $logs['filteredCount'],
                'data'              => $logs['data'],
            ];

            return $json_data;
        } catch (Exception $e) {
            logger()->error($e);

            return response()->json([
                'draw'            => 1,
                'recordsTotal'    => 0,
                'recordsFiltered' => 0,
                'data'            => [],
                'error'           => trans('message.error_occured'),
            ], 500);
        }
    }
}
