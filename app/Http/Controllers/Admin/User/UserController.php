<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\IATI\Models\User\User;
use App\IATI\Services\User\UserService;
use Illuminate\Database\DatabaseManager;
use Illuminate\Http\JsonResponse;
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
}
