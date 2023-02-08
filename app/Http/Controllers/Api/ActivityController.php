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
    /**
     * @var ActivityService
     */
    private ActivityService $activityService;

    /**
     * @param ActivityService $activityService
     */
    public function __construct(ActivityService $activityService)
    {
        $this->activityService = $activityService;
    }

    /**
     * Deletes activity element.
     *
     * @param $id
     * @param $element
     *
     * @return Response|Application|ResponseFactory
     */
    public function deleteElement($id, $element): Response|Application|ResponseFactory
    {
        try {
            if (!$this->activityService->deleteElement($id, $element)) {
                return response(['status' => false, 'message' => 'Error has occurred while deleting activity element.']);
            }

            $message = sprintf('The %s element deleted successfully.', str_replace('_', '-', $element));
            Session::put('success', $message);

            return response(['status' => true, 'message' => $message]);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response(['status' => false, 'message' => 'Error has occurred while deleting activity element.']);
        }
    }
}
