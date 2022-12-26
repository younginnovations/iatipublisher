<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserProfileRequest;
use App\Http\Requests\User\UserRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\IATI\Services\Audit\AuditService;
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
     * @var AuditService
     */
    protected AuditService $auditService;

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
     * @param UserService $userService
     * @param OrganizationService $organizationService
     * @param AuditService $auditService
     * @param CsvGenerator $csvGenerator
     * @param DatabaseManager $db
     */
    public function __construct(UserService $userService, OrganizationService $organizationService, AuditService $auditService, CSVGenerator $csvGenerator, DatabaseManager $db)
    {
        $this->userService = $userService;
        $this->organizationService = $organizationService;
        $this->auditService = $auditService;
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

            return redirect()->back()->with('error', trans('responses.error_has_occurred_page', ['event'=>trans('events.rendering'), ':suffix'=>trans('user.user_listing')]));
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

            return response()->json(['success' => true, 'message' => trans('responses.event_successfully', ['event'=>trans('events.created'), 'prefix'=>trans('user.new_user')])]);
        } catch (\Exception $e) {
            $this->db->rollback();
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => trans('responses.error_has_occurred', ['event'=>trans('events.creating'), ':suffix'=>lcfirst(trans('user.user'))])]);
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

            return response()->json(['success' => true, 'message' => trans('responses.event_successfully', ['event'=>trans('events.updated'), 'prefix'=>trans('user.user')])]);
        } catch (\Exception $e) {
            $this->db->rollback();
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => trans('responses.error_has_occurred', ['event'=>trans('events.updating'), ':suffix'=>lcfirst(trans('user.user'))])]);
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
                return response()->json(['success' => true, 'message' => trans('responses.event_successfully', ['event'=>trans('events.deleted'), 'prefix'=>trans('user.user')])]);
            }

            return response()->json(['success' => false, 'message' => trans('user.cannot_be_deleted')]);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => trans('responses.error_has_occurred', ['event'=>trans('events.deleting'), ':suffix'=>lcfirst(trans('user.user'))])]);
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
                'message' => ucfirst(trans('responses.event_successfully', ['prefix'=>trans('responses.user_status'), 'event'=>trans('events.retrieved')])),
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
                'message' => ucfirst(trans('responses.event_successfully', ['prefix'=>trans('responses.verification_email'), 'event'=>trans('events.sent')])),
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

            return redirect()->route('admin.activities.index')->with('error', trans('responses.error_has_occurred_page', ['event'=>trans('events.rendering'), ':suffix'=>lcfirst(trans('settings.settings_label'))]));
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
                'message' => trans('user.paginated_users_fetched'),
                'data' => $users,
            ]);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json([
                'success' => false,
                'message' => trans('user.error_occurred_while'),
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
                return response()->json(['success' => false, 'errors' => ['current_password' => [trans('register.correct_current')]]]);
            }

            $this->userService->updatePassword(Auth::user()->id, $formData);

            return response()->json([
                'success' => true,
                'message' => trans('responses.event_successfully', ['event'=>trans('events.updated'), 'prefix'=>trans('register.password.label')]),
            ]);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json([
                'success' => false,
                'message' => trans('responses.error_has_occurred', ['event'=>trans('events.updating'), ':suffix'=>lcfirst(trans('register.password.label'))]),
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
            session()->put('locale', Arr::get($formData, 'language_preference', 'en'));
            app()->setLocale(Arr::get($formData, 'language_preference', 'en'));

            return response()->json([
                'success' => true,
                'message' => trans('responses.event_successfully', ['event'=>trans('events.updated'), 'prefix'=>trans('user.user_profile')]),
            ]);
        } catch (\Exception $e) {
            $this->db->rollback();
            logger()->error($e->getMessage());

            return response()->json([
                'success' => false,
                'message' => trans('responses.error_has_occurred', ['event'=>trans('events.updating'), ':suffix'=>lcfirst(trans('user.user_profile'))]),
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
            $user = $this->userService->getUser($id);

            if ($this->userService->toggleUserStatus($id)) {
                return response()->json(['success' => true, 'message' => $user->status
                    ? trans('responses.event_successfully', ['event'=>trans('events.deactivated'), 'prefix'=>trans('user.user')])
                    : trans('responses.event_successfully', ['event'=>trans('events.activated'), 'prefix'=>trans('user.user')]), ]);
            }

            return response()->json(['success' => false, 'message' => trans('user.status_cannot_be_changed')]);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json([
                'success' => false,
                'message' => trans('responses.error_has_occurred', ['event'=>trans('events.toggle'), ':suffix'=>lcfirst(trans('responses.user_status'))]),
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
            $headers = getUserCsvHeader();
            $queryParams = $this->getQueryParams($request);
            $users = $this->userService->getUserDownloadData($queryParams);

            $this->auditService->auditEvent($users, 'download');

            return $this->csvGenerator->generateWithHeaders(getTimeStampedText('users'), $users->toArray(), $headers);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());
            $this->auditService->auditEvent(null, 'download');

            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
