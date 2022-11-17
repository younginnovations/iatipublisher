<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\IATI\Services\Activity\ActivityService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;

/**
 * Class ActivityController.
 */
class ActivityController extends Controller
{
    private ActivityService $activityService;

    /**
     * @param ActivityService $activityService
     */
    public function __construct(ActivityService $activityService)
    {
        $this->activityService = $activityService;
    }

    /**
     * @param $id
     * @param $element
     *
     * @return Response|Application|ResponseFactory
     */
    public function deleteElement($id, $element): Response|Application|ResponseFactory
    {
        try {
            if (!$this->activityService->deleteElement($id, $element)) {
                return response(['status'=>false, 'message' => 'Error has occurred while deleting activity element.']);
            }

            Session::put('success', 'Activity title deleted successfully.');

            return response(['status'=>true, 'message' => 'Activity title deleted successfully.']);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response(['status'=>false, 'message' => 'Error has occurred while deleting activity element.']);
        }
    }
}
