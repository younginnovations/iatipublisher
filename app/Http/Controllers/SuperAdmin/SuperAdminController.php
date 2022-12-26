<?php

declare(strict_types=1);

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\IATI\Services\Organization\OrganizationService;
use App\IATI\Services\User\UserService;
use Exception;
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
    public function listOrganizations(): View | Factory | JsonResponse | Application
    {
        try {
            return view('superadmin.organisationsList');
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'error' => trans('responses.error_has_occurred', ['event'=>trans('events.fetching'), 'suffix'=>trans('elements_common.organisations')])]);
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
                'message' => ucfirst(trans('responses.event_successfully', ['prefix'=>trans('elements_common.organisations'), 'event'=>trans('events.fetched')])),
                'data'    => $organizations,
            ]);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => trans('responses.error_has_occurred', ['event'=>trans('events.fetching'), 'suffix'=>trans('responses.the_data')])]);
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

                    return response()->json(['success' => true, 'message' => trans('responses.proxy_successful')]);
                }
            }

            return response()->json(['success' => false, 'message' => trans('responses.error_has_occurred', ['event'=>trans('events.trying_to'), 'suffix'=>trans('buttons.proxy')])]);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => trans('responses.error_has_occurred', ['event'=>trans('events.trying_to'), 'suffix'=>trans('buttons.proxy')])]);
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

            return  redirect('listOrganizations')->with('error', trans('requests.failed_opening_system_version_page'));
        }
    }
}
