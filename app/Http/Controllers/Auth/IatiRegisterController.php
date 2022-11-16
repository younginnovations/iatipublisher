<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\IATI\Models\User\Role;
use App\IATI\Services\Organization\OrganizationService;
use App\IATI\Services\User\UserService;
use App\Providers\RouteServiceProvider;
use Exception;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\DatabaseManager;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

/**
 * Class RegisterController.
 */
class IatiRegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected string $redirectTo = RouteServiceProvider::HOME;

    protected OrganizationService $organizationService;
    protected UserService $userService;
    protected Log $logger;
    protected DatabaseManager $db;

    /**
     * Controller constructor.
     *
     * @param OrganizationService $organizationService
     * @param UserService         $userService
     * @param Log                 $logger
     * @param DatabaseManager     $db
     */
    public function __construct(OrganizationService $organizationService, UserService $userService, Log $logger, DatabaseManager $db)
    {
        $this->organizationService = $organizationService;
        $this->userService = $userService;
        $this->logger = $logger;
        $this->db = $db;

        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($data, [
            'username'              => ['required', 'string', 'max:255', 'unique:users,username'],
            'full_name'             => ['required', 'string', 'max:255'],
            'email'                 => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'contact_email'         => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'publisher_id'          => ['required', 'string', 'max:255', 'unique:organizations,publisher_id'],
            'publisher_name'        => ['required', 'string', 'max:255', 'unique:organizations,publisher_name'],
            'identifier'            => ['required', 'string', 'max:255', 'unique:organizations,identifier'],
            'password'              => ['required', 'string', 'min:6', 'confirmed'],
            'password_confirmation' => ['required', 'string', 'min:6'],
        ]);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse|void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function verifyPublisher(Request $request): JsonResponse|\GuzzleHttp\Exception\GuzzleException
    {
        try {
            $postData = $request->all();
            $request['password'] = isset($request['password']) && $request['password'] ? decryptString($request['password'], env('MIX_ENCRYPTION_KEY')) : '';
            $request['password_confirmation'] = isset($request['password_confirmation']) && $request['password_confirmation'] ? decryptString($request['password_confirmation'], env('MIX_ENCRYPTION_KEY')) : '';

            $validator = Validator::make($postData, [
                'publisher_id'        => ['required', 'string', 'max:255', 'unique:organizations,publisher_id'],
                'publisher_name'      => ['required', 'string', 'max:255', 'unique:organizations,publisher_name'],
                'identifier'          => ['required', 'string', 'max:255', 'unique:organizations,identifier'],
                'registration_agency' => ['required'],
                'registration_number' => ['required'],
                'publisher_type'      => ['required'],
                'license_id'        => ['required'],
                'description'         => ['sometimes'],
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()]);
            }

            $publisherCheck = $this->userService->checkPublisher($postData, false);

            if (!empty($publisherCheck)) {
                return response()->json([
                    'success'         => false,
                    'publisher_error' => true,
                    'errors'          => $publisherCheck,
                ]);
            }

            return response()->json(['success' => true, 'message' => 'Publisher verified successfully', 'data' => $publisherCheck]);
        } catch (ClientException $e) {
            logger()->error($e->getMessage());

            return response()->json(
                [
                    'success' => false,
                    'errors'  => [
                        'publisher_name' => ['Publisher Name doesn\'t match your IATI Registry information'],
                        'publisher_id'   => ['Publisher ID doesn\'t match with your IATI Registry information'],
                    ],
                ]
            );
        } catch (Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'error' => 'Error has occurred while verifying the publisher.']);
        }
    }

    /**
     * Handle a registration request for the application.
     *
     * @param Request $request
     *
     * @return RedirectResponse|JsonResponse
     * @throws \JsonException
     * @throws \Throwable
     */
    public function verifyContactInfo(Request $request): JsonResponse|RedirectResponse
    {
        try {
            $request['password'] = isset($request['password']) && $request['password'] ? decryptString($request['password'], env('MIX_ENCRYPTION_KEY')) : '';
            $request['password_confirmation'] = isset($request['password_confirmation']) && $request['password_confirmation'] ? decryptString($request['password_confirmation'], env('MIX_ENCRYPTION_KEY')) : '';

            $validator = Validator::make($request->all(), [
                'contact_email' => ['required', 'string', 'email', 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix', 'max:255', 'unique:users,email'],
                'website' => ['nullable', 'url'],
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()]);
            }

            return response()->json(['success' => true, 'message' => 'Contact info successfully verified']);
        } catch (Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => true, 'message' => 'Error occurred while verifying contact info']);
        }
    }

    /**
     * Handle a registration request for the application.
     *
     * @param Request $request
     *
     * @return RedirectResponse|JsonResponse
     * @throws \JsonException
     * @throws \Throwable
     */
    public function verifyAdditionalInfo(Request $request): JsonResponse|RedirectResponse
    {
        try {
            $request['password'] = isset($request['password']) && $request['password'] ? decryptString($request['password'], env('MIX_ENCRYPTION_KEY')) : '';
            $request['password_confirmation'] = isset($request['password_confirmation']) && $request['password_confirmation'] ? decryptString($request['password_confirmation'], env('MIX_ENCRYPTION_KEY')) : '';

            $validator = Validator::make($request->all(), [
                'source' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()]);
            }

            return response()->json(['success' => true, 'message' => 'Additional Information successfully verified.']);
        } catch (Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => true, 'message' => 'Error occurred while verifying additional info.']);
        }
    }

    /**
     * Handle a registration request for the application.
     *
     * @param Request $request
     *
     * @return RedirectResponse|JsonResponse
     * @throws \JsonException
     * @throws \Throwable
     */
    public function register(Request $request): JsonResponse|RedirectResponse
    {
        try {
            $request['password'] = isset($request['password']) && $request['password'] ? decryptString($request['password'], env('MIX_ENCRYPTION_KEY')) : '';
            $request['password_confirmation'] = isset($request['password_confirmation']) && $request['password_confirmation'] ? decryptString($request['password_confirmation'], env('MIX_ENCRYPTION_KEY')) : '';
            $postData = $request->all();

            $validator = Validator::make($request->all(), [
                'username'              => ['required', 'max:255', 'string', 'regex:/^[A-Za-z]([0-9A-Za-z _])*$/', 'unique:users,username'],
                'full_name'             => ['required', 'string', 'max:255'],
                'email'                 => ['required', 'string', 'email', 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix', 'max:255', 'unique:users,email'],
                'publisher_id'          => ['required', 'string', 'max:255', 'unique:organizations,publisher_id'],
                'password'              => ['required', 'string', 'min:6', 'max:255', 'confirmed'],
                'password_confirmation' => ['required', 'string', 'min:6', 'max:255'],
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()]);
            }

            $publisherCheck = $this->userService->checkPublisher($postData, false);
            $userCheck = $this->userService->checkUser($postData, false);

            if (!empty($publisherCheck) || !empty($userCheck)) {
                return response()->json([
                    'success'         => false,
                    'errors'          => array_merge($publisherCheck, $userCheck),
                ]);
            }

            $user = $this->create($postData);
            event(new Registered($user));
            Session::put('role_id', app(Role::class)->getOrganizationAdminId());

            return response()->json(['success' => true, 'message' => 'User registered successfully']);
        } catch (Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'User registered successfully']);
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     *
     * @return array
     * @throws \Throwable
     */
    protected function create(array $data): array
    {
        try {
            $this->db->beginTransaction();
            $api_token = [];
            $publisher = [];
            $user = [];

            $iati_user = $this->userService->createUserInRegistry($data);

            if (Arr::get($iati_user, 'success', false)) {
                $api_token = $this->userService->createAPItoken($data['username']);

                if (Arr::get($api_token, 'success', false)) {
                    $publisher = $this->userService->createPublisherInRegistry($data, $api_token['token']);
                    $data['token'] = $api_token['token'];
                }

                if ($iati_user['success'] && $api_token['success'] && $publisher['success']) {
                    $user = $this->userService->registerNewUser($data);
                } else {
                    return [
                        'success' => false,
                        'errors' => array_merge(
                            $this->userService->mapError('user', $iati_user['error'] ?? []),
                            $api_token['error'] ?? [],
                            $this->userService->mapError('publisher', $publisher['error'] ?? [])
                        ),
                    ];
                }
            }

            $this->db->commit();

            return ['success' => true, 'user' => $user];
        } catch (\Exception $e) {
            logger()->error($e->getMessage());
        }
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm(): \Illuminate\View\View
    {
        try {
            $types = [
                'country' => getCodeListArray('Country', 'OrganizationArray'),
                'registrationAgency' => getCodeListArray('OrganizationRegistrationAgency', 'OrganizationArray'),
                'publisherType' => getCodeList('PublisherType', 'Activity'),
                'dataLicense' => getCodeList('DataLicense', 'Activity'),
                'source' => getCodeList('Source', 'Activity'),
            ];

            return view('web.iati_register', compact('types'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return view('web.welcome');
        }
    }
}
