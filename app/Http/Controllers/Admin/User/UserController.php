<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserProfileRequest;
use App\Http\Requests\User\UserRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\IATI\Services\Download\CsvGenerator;
use App\IATI\Services\Organization\OrganizationService;
use App\IATI\Services\User\UserService;
use Illuminate\Contracts\View\View;
use Illuminate\Database\DatabaseManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

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
     * @var CsvGenerator
     */
    protected CsvGenerator $csvGenerator;

    /**
     * @var DatabaseManager
     */
    protected DatabaseManager $db;

    /**
     * Create a new controller instance.
     *
     * @param UserService      $userService
     * @param OrganizationService      $organizationService
     * @param CsvGenerator         $csvGenerator
     * @param DatabaseManager     $db
     */
    public function __construct(UserService $userService, OrganizationService $organizationService, CSVGenerator $csvGenerator, DatabaseManager $db)
    {
        $this->userService = $userService;
        $this->organizationService = $organizationService;
        $this->csvGenerator = $csvGenerator;
        $this->db = $db;
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
            $status = getUserStatus();
            $roles = $this->userService->getRoles();
            $userRole = Auth::user()->role->role;

            return view('admin.user.index', compact('status', 'organizations', 'roles', 'userRole'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->back()->with('error', 'Error has occurred while rendering user listing page');
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
            $formData = $request->only(['full_name', 'username', 'email', 'status', 'role_id', 'password', 'password_confirmation']);

            $this->db->beginTransaction();
            $this->userService->store($formData);
            $this->db->commit();

            return response()->json(['success' => true, 'message' => 'New user successfully created.']);
        } catch (\Exception $e) {
            $this->db->rollback();
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
    public function update(UserUpdateRequest $request, $id): JsonResponse
    {
        try {
            $formData = $request->only(['full_name', 'username', 'email', 'role_id', 'password', 'password_confirmation']);

            if (empty($formData['password'])) {
                unset($formData['password'], $formData['password_confirmation']);
            }

            $this->db->beginTransaction();
            $this->userService->update($id, $formData);
            $this->db->commit();

            return response()->json(['success' => true, 'message' => 'User has been updated successfully.']);
        } catch (\Exception $e) {
            $this->db->rollback();
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'Error has occurred while updating user.']);
        }
    }

    /**
     * Delete user.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        try {
            if ($this->userService->delete($id)) {
                return response()->json(['success' => true, 'message' => 'User has been deleted successfully.']);
            }

            return response()->json(['success' => false, 'message' => 'The user cannot be deleted.']);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'Error has occurred while deleting user.']);
        }
    }

    /**
     * Get User status.
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
            $user['user_role'] = $user->role->role;
            $user['organization_name'] = $user->organization_id ? $user->organization->publisher_name : null;
            $languagePreference = getLanguagePreference();

            return view('admin.user.profile', compact('user', 'languagePreference'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.index')->with('error', 'Error while rendering setting page');
        }
    }

    /**
     * Return paginated users.
     *
     * @param Request $request
     * @param int $page
     *
     * @return JsonResponse
     */
    public function getPaginatedUsers(Request $request, int $page = 1): JsonResponse
    {
        try {
            $queryParams = $this->getQueryParams($request);
            $users = $this->userService->getPaginatedUsers($page, $queryParams);

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
        $tableConfig = getTableConfig('user');
        $accessibleRoles = array_keys($this->userService->getRoles());
        $accessibleOrg = Auth::user()->organization_id;
        $requestData = $request->all();
        $organization_id = Arr::get($requestData, 'organization', null) ? explode(',', Arr::get($requestData, 'organization')) : [];
        $roles = Arr::get($request, 'roles', null) ? explode(',', Arr::get($request, 'roles')) : [];
        $queryParams = [];

        if ($accessibleOrg) {
            $organization_id[] = $accessibleOrg;
        }

        if ($accessibleRoles) {
            $roles = empty($roles) ? $accessibleRoles : $roles;
        }

        $queryParams['organization_id'] = $organization_id;
        $queryParams['role'] = $roles;

        if (!empty($request->get('q')) || $request->get('q') === '0') {
            $queryParams['q'] = $request->get('q');
        }

        if (!empty($request->get('status')) || $request->get('status') === '0') {
            $queryParams['status'] = explode(',', $request->get('status'));
        }

        if (!empty($request->get('users')) || $request->get('users') === '0') {
            $queryParams['users'] = explode(',', $request->get('users'));
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
     * @param UserProfileRequest $request $request
     *
     * @return JsonResponse
     */
    public function updatePassword(UserProfileRequest $request): JsonResponse
    {
        try {
            $formData = $request->only(['current_password', 'password']);

            if (!Hash::check($formData['current_password'], Auth::user()->getAuthPassword())) {
                return response()->json(['success' => false, 'errors' => ['current_password' => ['Please enter correct current password']]]);
            }

            $this->userService->updatePassword(Auth::user()->id, $formData);

            return response()->json([
                'success' => true,
                'message' => 'Password updated successfully.',
            ])->withCookie('password_changed', 'Password changed successfully.');
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
     * @param UserProfileRequest $request $request
     *
     * @return JsonResponse
     * @throws \Throwable
     */
    public function updateProfile(UserProfileRequest $request): JsonResponse
    {
        try {
            $formData = $request->only(['username', 'full_name', 'email', 'language_preference']);

            $this->db->beginTransaction();
            $this->userService->update(Auth::user()->id, $formData);
            $this->db->commit();

            return response()->json([
                'success' => true,
                'message' => 'User profile updated successfully.',
            ]);
        } catch (\Exception $e) {
            $this->db->rollback();
            logger()->error($e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error occurred while updating user profile.',
            ]);
        }
    }

    /**
     * Toggle user status.
     *
     * @param $id
     *
     * @return JsonResponse
     */
    public function toggleUserStatus($id): JsonResponse
    {
        try {
            if ($this->userService->toggleUserStatus($id)) {
                return response()->json(['success' => true, 'message' => 'User status has been successfully changed.']);
            }

            return response()->json(['success' => false, 'message' => 'The status of this user cannot be changed.']);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error has occurred while trying to toggle user status',
            ]);
        }
    }

    /**
     * Download users in csv format.
     *
     * @param Request $request
     *
     * @return BinaryFileResponse|JsonResponse
     */
    public function downloadUsers(Request $request): BinaryFileResponse|JsonResponse
    {
        try {
            $headers = getUserDownloadCsvHeader();
            $queryParams = $this->getQueryParams($request);
            $users = $this->userService->getUserDownloadData($queryParams);

            return $this->csvGenerator->generateWithHeaders(generateFileName('users'), $users, $headers);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
