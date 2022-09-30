<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\IATI\Models\User\Role;
use App\IATI\Services\Organization\OrganizationService;
use App\IATI\Services\User\UserService;
use App\Providers\RouteServiceProvider;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

/**
 * Class RegisterController.
 */
class RegisterController extends Controller
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
            'publisher_id'          => ['required', 'string', 'max:255', 'unique:organizations,publisher_id'],
            'publisher_name'        => ['required', 'string', 'max:255', 'unique:organizations,publisher_name'],
            'identifier'            => ['required', 'string', 'max:255', 'unique:organizations,identifier'],
            'password'              => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required', 'string', 'min:8'],
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
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()]);
            }

            $clientConfig = ['base_uri' => env('IATI_API_ENDPOINT')];
            $requestConfig = [
                'http_errors' => false,
                'query'       => ['id' => $postData['publisher_id'] ?? ''],
            ];

            if (env('APP_ENV') != 'production') {
                $clientConfig['headers']['X-CKAN-API-Key'] = env('IATI_API_KEY');
                $requestConfig['auth'] = [env('IATI_USERNAME'), env('IATI_PASSWORD')];
            }

            $client = new Client($clientConfig);
            $res = $client->request('GET', env('IATI_API_ENDPOINT') . '/action/organization_show', $requestConfig);

            if ($res->getStatusCode() === 404) {
                return response()->json([
                    'success'         => false,
                    'publisher_error' => true,
                    'errors'          => [
                        'publisher_id' => ['Publisher ID doesn\'t exist in IATI Registry.'],
                    ],
                ]);
            }

            $errors = [];
            $response = json_decode($res->getBody()->getContents())->result;

            if ($postData['publisher_name'] != $response->title) {
                $errors['publisher_name'] = ['Publisher Name doesn\'t match your IATI Registry information'];
            }

            if ($postData['registration_agency'] . '-' . $postData['registration_number'] != $response->publisher_iati_id) {
                $errors['identifier'] = ['Publisher IATI ID doesn\'t match your IATI Registry information'];
            }

            if (!empty($errors)) {
                return response()->json([
                    'success'         => false,
                    'publisher_error' => true,
                    'errors'          => $errors,
                ]);
            }

            return response()->json(['success' => true, 'message' => 'Publisher verified successfully', 'data' => $response]);
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
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'error' => 'Error has occurred while verifying the publisher.']);
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     *
     * @return Model
     * @throws \Throwable
     */
    protected function create(array $data): Model
    {
        try {
            $this->db->beginTransaction();
            $user = $this->userService->registerExistingUser($data);
            $this->db->commit();

            return $user;
        } catch (\Exception $e) {
            logger()->error($e->getMessage());
        }
    }

    /**
     * Handle a registration request for the application.
     *
     * @param Request $request
     *
     * @return RedirectResponse|JsonResponse
     */
    public function register(Request $request): JsonResponse|RedirectResponse
    {
        $request['password'] = isset($request['password']) && $request['password'] ? decryptString($request['password'], env('MIX_ENCRYPTION_KEY')) : '';
        $request['password_confirmation'] = isset($request['password_confirmation']) && $request['password_confirmation'] ? decryptString($request['password_confirmation'], env('MIX_ENCRYPTION_KEY')) : '';

        $validator = Validator::make($request->all(), [
            'username'              => ['required', 'max:255', 'string', 'regex:/^[A-Za-z]([0-9A-Za-z _])*$/', 'unique:users,username'],
            'full_name'             => ['required', 'string', 'max:255'],
            'email'                 => ['required', 'string', 'email', 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix', 'max:255', 'unique:users,email'],
            'publisher_id'          => ['required', 'string', 'max:255', 'unique:organizations,publisher_id'],
            'password'              => ['required', 'string', 'min:8', 'max:255', 'confirmed'],
            'password_confirmation' => ['required', 'string', 'min:8', 'max:255'],
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()]);
        }
        $user = $this->create($request->all());
        event(new Registered($user));
        Session::put('role_id', app(Role::class)->getOrganizationAdminId());

        return response()->json(['success' => true, 'message' => 'User registered successfully']);
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm(): \Illuminate\View\View
    {
        try {
            $countries = getCodeListArray('Country', 'OrganizationArray');
            $registration_agencies = getCodeListArray('OrganizationRegistrationAgency', 'OrganizationArray');

            return view('web.register', compact('countries', 'registration_agencies'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return view('web.welcome');
        }
    }
}
