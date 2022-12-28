<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserProfileRequest;
use App\Http\Requests\User\UserRequest;
use App\IATI\Services\Organization\OrganizationService;
use App\IATI\Services\User\UserService;
use Illuminate\Contracts\View\View;
use Illuminate\Database\DatabaseManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

/**
 * Class UserController.
 */
class UserController extends Controller
{
    /**
     * @var UserService
     */
    protected UserService $userService;

    /**
     * @var OrganizationService
     */
    protected OrganizationService $organizationService;

    /**
     * @var DatabaseManager
     */
    protected DatabaseManager $db;

    /**
     * Create a new controller instance.
     *
     * @param UserService      $userService
     * @param OrganizationService      $organizationService
     * @param Log                 $logger
     * @param DatabaseManager     $db
     */
    public function __construct(UserService $userService, OrganizationService $organizationService, Log $logger, DatabaseManager $db)
    {
        $this->userService = $userService;
        $this->organizationService = $organizationService;
        $this->db = $db;
        $this->logger = $logger;
    }

    /**
     * Renders user listing page.
     *
     * @return View|RedirectResponse
     */
    public function index(): View|RedirectResponse
    {
        try {
            $organizations = $this->organizationService->pluckAllOrganizations();
            $status = [1 => 'Active', 0 => 'Inactive'];
            $roles = [
                '1' => 'general_user',
                '2' => 'admin',
                '3' => 'superadmin',
            ];

            return view('admin.user.index', compact('status', 'organizations', 'roles'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.index')->with('error', 'Error has occurred while rendering user listing page');
        }
    }

    /**
     * Stores user.
     *
     * @param $request
     *
     * @return JsonResponse
     */
    public function store(UserRequest $request): JsonResponse
    {
        try {
            $formData = $request->only(['full_name', 'username', 'email', 'status', 'role', 'password', 'password_confirmation']);
            $formData['organization_id'] = Auth::user()->organization_id;

            $this->userService->store($formData);

            return response()->json(['success' => true, 'message' => 'New user successfully created.']);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'Error has occurred while creating user.']);
        }
    }

    /**
     * Updates user.
     *
     * @param $request
     *
     * @return JsonResponse
     */
    public function update(UserRequest $request, $id): JsonResponse
    {
        try {
            $formData = $request->only(['full_name', 'username', 'email', 'status', 'role', 'password', 'password_confirmation']);

            $this->userService->update($id, $formData);

            return response()->json(['success' => true, 'message' => 'User has been updated successfully.']);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'Error has occurred while updating user.']);
        }
    }

    public function delete($id): JsonResponse
    {
        try {
            $this->userService->delete($id);

            return response()->json(['success' => true, 'message' => 'User has been deleted successfully.']);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'Error has occurred while deleting user.']);
        }
    }

    /**
     * Get User status.
     *
     * @param array $data
     *
     * @return JsonResponse
     */
    public function getUserVerificationStatus(): JsonResponse
    {
        try {
            $status = $this->userService->getStatus();

            return response()->json([
                'success' => true,
                'message' => 'User status successfully retrieved.',
                'data' => ['account_verified' => $status],
            ]);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Get User status.
     *
     * @param array $data
     *
     * @return JsonResponse
     */
    public function resendVerificationEmail(): JsonResponse
    {
        try {
            $this->userService->resendVerificationEmail();

            return response()->json([
                'success' => true,
                'message' => 'Verification email successfully sent.',
            ]);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Show user profile.
     *
     * @return View|RedirectResponse
     */
    public function showUserProfile(): View|RedirectResponse
    {
        try {
            $user = Auth::user();

            return view('admin.user.profile', compact('user'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.index')->with('error', 'Error while rendering setting page');
        }
    }

    public function getPaginatedUsers(Request $request, int $page = 1): JsonResponse
    {
        try {
            $queryParams = $this->getQueryParams($request);
            $users = $this->userService->getPaginatedUsers($page, []);

            return response()->json([
                'success' => true,
                'message' => 'Paginated users fetch successfully.',
                'data' => $users,
            ]);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error occurred while trying to get paginated user.',
            ]);
        }
    }

    /**
     * Get queryParams.
     *
     * @param $request
     *
     * @return array
     */
    public function getQueryParams($request): array
    {
        $tableConfig = getTableConfig('activity');
        $queryParams = [];

        if (!empty($request->get('q')) || $request->get('q') === '0') {
            $queryParams['query'] = $request->get('q');
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
     * Update user password.
     *
     * @param request
     *
     * @return JsonResponse
     */
    public function updatePassword(UserProfileRequest $request): JsonResponse
    {
        try {
            $formData = $request->only(['current_password', 'password']);

            if (Hash::check($formData['current_password'], Auth::user()->getAuthPassword())) {
                return response()->json(['success' => false, 'message' => 'Please enter correct current password']);
            }

            $this->userService->update(Auth::user()->id, $formData);

            return response()->json([
                'success' => true,
                'message' => 'Password updated successfully.',
            ]);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error occurred while updating password.',
            ]);
        }
    }

    /**
     * Update user profile.
     *
     * @param request
     *
     * @return JsonResponse
     */
    public function updateProfile(UserProfileRequest $request): JsonResponse
    {
        try {
            $formData = $request->only(['username', 'full_name', 'email']);

            $this->userService->updateProfile($formData);

            return response()->json([
                'success' => true,
                'message' => 'User profile updated successfully.',
            ]);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error occurred while updating user profile.',
            ]);
        }
    }

    public function toggleUserStatus($id) : JsonResponse
    {
        try {
            $this->userService->toggleUserStatus($id);

            return response()->json(['success'=>true, 'message'=> 'User status has been successfully changed.']);
        } catch(\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json([
                'success' =>false,
                'message' => 'Error has occurred while trying to toggle user status',
            ]);
        }
    }
}
