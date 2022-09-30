<?php

declare(strict_types=1);

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\IATI\Services\Organization\OrganizationService;
use App\IATI\Services\User\UserService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class SuperAdminController.
 */
class SuperAdminController extends Controller
{
    /**
     * SuperAdminController Constructor.
     *
     * @param OrganizationService $organizationService
     * @param UserService $userService
     */
    public function __construct(public OrganizationService $organizationService, public UserService $userService)
    {
        //
    }

    /**
     * Returns superadmin page for viewing all organisations.
     *
     * @return Application|Factory|View|JsonResponse
     */
    public function listOrganizations(): View|Factory|JsonResponse|Application
    {
        try {
            return view('superadmin.organisationsList');
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'error' => 'Error has occurred while fetching organisations.']);
        }
    }

    /**
     * Returns organizations in paginated format.
     *
     * @param Request $request
     * @param int $page
     *
     * @return JsonResponse
     */
    public function getPaginatedOrganizations(Request $request, int $page = 1): JsonResponse
    {
        try {
            $organizations = $this->organizationService->getPaginatedOrganizations(
                $page,
                $this->sanitizeRequest($request)
            );

            return response()->json([
                'success' => true,
                'message' => 'Organizations fetched successfully',
                'data'    => $organizations,
            ]);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'Error occurred while fetching the data']);
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
        $tableConfig = getTableConfig('organisation');
        $queryParams = [];

        if (!empty($request->get('q'))) {
            $queryParams['q'] = $request->get('q');
        }

        if (in_array($request->get('orderBy'), $tableConfig['orderBy'], true)) {
            $queryParams['orderBy'] = $request->get('orderBy');

            if (in_array($request->get('direction'), $tableConfig['direction'], true)) {
                $queryParams['direction'] = $request->get('direction');
            }
        }

        return $queryParams;
    }

    /**
     * Allows superadmin to masquerade as a user of an organization.
     *
     * @param $userId
     *
     * @return JsonResponse
     */
    public function proxyOrganization($userId): JsonResponse
    {
        try {
            if (isSuperAdmin()) {
                $user = $this->userService->getUser($userId);

                if ($user) {
                    auth()->loginUsingId($userId);

                    return response()->json(['success' => true, 'message' => 'Proxy successful.']);
                }
            }

            return response()->json(['success' => false, 'message' => 'Error occurred while trying to proxy']);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'Error occurred while trying to proxy']);
        }
    }

    /**
     * Allows superadmin to switch back to superadmin.
     *
     * @return JsonResponse
     */
    public function switchBack(): JsonResponse
    {
        try {
            if (isSuperAdmin()) {
                $superAdmin = $this->userService->getUser(session()->get('superadmin_user_id'));

                if ($superAdmin) {
                    auth()->loginUsingId($superAdmin->id);

                    return response()->json(['success' => true, 'message' => 'Switch back successful.']);
                }
            }

            return response()->json(['success' => false, 'message' => 'Error occurred while trying to proxy']);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'Error occurred while trying to proxy']);
        }
    }
}
