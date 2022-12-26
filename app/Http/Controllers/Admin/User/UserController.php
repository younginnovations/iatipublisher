<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserProfileRequest;
use App\IATI\Models\User\User;
use App\IATI\Services\User\UserService;
use Illuminate\Contracts\View\View;
use Illuminate\Database\DatabaseManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
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
     * @var DatabaseManager
     */
    protected DatabaseManager $db;

    /**
     * Create a new controller instance.
     *
     * @param UserService      $userService
     * @param Log                 $logger
     * @param DatabaseManager     $db
     */
    public function __construct(UserService $userService, Log $logger, DatabaseManager $db)
    {
        $this->userService = $userService;
        $this->db = $db;
        $this->logger = $logger;
    }

    public function index()
    {
        try {
            $users = $this->userService->getAllUser();

            return view('admin.user.index', compact('users'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.index')->with('error', 'Error has occurred while rendering user listing page');
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

            $this->userService->updatePassword($formData);

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
}
