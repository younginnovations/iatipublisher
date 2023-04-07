<?php

declare(strict_types=1);

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\IATI\Services\Activity\ActivityService;
use App\IATI\Services\Organization\OrganizationService;
use App\IATI\Services\User\UserService;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
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
     * @param ActivityService $activityService
     */
    public function __construct(public OrganizationService $organizationService, public UserService $userService, public ActivityService $activityService)
    {
        //
    }

    /**
     * Returns super-admin page for viewing all organisations.
     *
     * @return Application|Factory|View|JsonResponse
     */
    public function listOrganizations(): View | Factory | JsonResponse | Application
    {
        try {
            return view('superadmin.organisationsList');
        } catch (Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(
                ['success' => false, 'error' => 'Error has occurred while fetching organisations.']
            );
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
            logger($organizations);
//            $organizations = $this->setProperUpdatedAtForListingPage($organizations);//

            return response()->json([
                'success' => true,
                'message' => 'Organizations fetched successfully',
                'data'    => $organizations,
            ]);
        } catch (Exception $e) {
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
        } catch (Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'Error occurred while trying to proxy']);
        }
    }

    /**
     * Returns System Version UI.
     *
     * @return View|Factory|JsonResponse|Application
     */
    public function listSystemVersion(): View | Factory | JsonResponse | Application
    {
        try {
            $composerPackageDetails = json_decode(file_get_contents('../app_versions/composer_package_versions.json'));

            $phpDependencies = $composerPackageDetails->package_details->installed ?? '';
            $nodeDependencies = json_decode(file_get_contents('../app_versions/npm_package_versions.json'), true) ?? '';
            $version = json_decode(file_get_contents('../app_versions/current_versions.json')) ?? '';
            $latestVersion = json_decode(file_get_contents('../app_versions/latest_versions.json')) ?? '';

            $version->composer = $composerPackageDetails->composer_version;

            return view(
                'superadmin.systemVersion',
                compact(
                    'phpDependencies',
                    'nodeDependencies',
                    'version',
                    'latestVersion'
                )
            );
        } catch (Exception $e) {
            logger()->error($e->getMessage());

            return  redirect('listOrganizations')->with('error', 'Failed opening System Version page.');
        }
    }

    private function setProperUpdatedAtForListingPage(?LengthAwarePaginator $organizations): ?LengthAwarePaginator
    {
//        foreach ($organizations as $organization) {
//            $organization->updated_at = $organization->recentlyChangedActivity->updated_at;
//        }

        return $organizations;
    }
}
