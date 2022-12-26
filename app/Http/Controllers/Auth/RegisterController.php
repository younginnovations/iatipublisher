<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Constants\Enums;
use App\Http\Controllers\Controller;
use App\IATI\Models\User\Role;
use App\IATI\Services\ApiLog\ApiLogService;
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
    | validation and creation. By default, this controller uses a trait to
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
    protected ApiLogService $apiLogService;
    protected DatabaseManager $db;

    /**
     * Controller constructor.
     *
     * @param OrganizationService $organizationService
     * @param UserService         $userService
     * @param ApiLogService   $apiLogService
     * @param DatabaseManager     $db
     */
    public function __construct(OrganizationService $organizationService, UserService $userService, ApiLogService $apiLogService, DatabaseManager $db)
    {
        $this->organizationService = $organizationService;
        $this->userService = $userService;
        $this->apiLogService = $apiLogService;
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
            'username'              => ['required', 'string', 'max:255', 'unique:users,username', 'regex:/^[a-z]([0-9a-z-_])*$/'],
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
                'registration_agency' => ['required', sprintf('in:%s', implode(',', array_keys(getCodeList('OrganizationRegistrationAgency', 'Organization'))))],
                'registration_number' => ['required'],
                'country'             => ['nullable', sprintf('in:%s', implode(',', array_keys(getCodeList('Country', 'Activity'))))],
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()]);
            }

            $clientConfig = ['base_uri' => env('IATI_API_ENDPOINT')];
            $requestConfig = [
                'http_errors' => false,
                'query'       => ['id' => $postData['publisher_id'] ?? ''],
            ];
            $clientConfig['headers']['X-CKAN-API-Key'] = env('IATI_API_KEY');

            if (env('APP_ENV') !== 'production') {
                $requestConfig['auth'] = [env('IATI_USERNAME'), env('IATI_PASSWORD')];
            }

            $client = new Client($clientConfig);
            $res = $client->request('GET', env('IATI_API_ENDPOINT') . '/action/organization_show', $requestConfig);
            $this->apiLogService->store(generateApiInfo('GET', env('IATI_API_ENDPOINT') . '/action/organization_show', $requestConfig, $res));

            if ($res->getStatusCode() === 404) {
                return response()->json([
                    'success'         => false,
                    'publisher_error' => true,
                    'errors'          => [
                        'publisher_id' => [trans('common.error.element_doesnt_exist_in_iati_registry', ['element'=>trans('register.publisher_id.label')])],
                    ],
                ]);
            }

            $errors = [];
            $response = json_decode($res->getBody()->getContents(), false, 512, JSON_THROW_ON_ERROR)->result;

            if ($postData['publisher_name'] !== $response->title) {
                $errors['publisher_name'] = [trans('common.error.elements_doesnt_match_iati_registry', ['element'=>trans('register.publisher_name.label')])];
            }

            if ($postData['registration_agency'] . '-' . $postData['registration_number'] !== $response->publisher_iati_id) {
                $errors['identifier'] = [trans('common.error.elements_doesnt_match_iati_registry', ['element'=>trans('web.iati_publisher') . ' ID '])];
            }

            if (!empty($errors)) {
                return response()->json([
                    'success'         => false,
                    'publisher_error' => true,
                    'errors'          => $errors,
                ]);
            }

            return response()->json(['success' => true, 'message' => ucfirst(trans('responses.event_successfully', ['prefix'=>trans('elements_common.publisher'), 'event'=>trans('events.deleted')])), 'data' => $response]);
        } catch (ClientException $e) {
            logger()->error($e->getMessage());

            return response()->json(
                [
                    'success' => false,
                    'errors'  => [
                        'publisher_name' => [trans('responses.publisher_name_doesnt_match')],
                        'publisher_id'   => [trans('responses.publisher_id_doesnt_match')],
                    ],
                ]
            );
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'error' => trans('responses.error_has_occurred', ['event'=>trans('events.verifying'), 'suffix'=>trans('elements_common.publisher')])]);
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
     * @throws \JsonException
     * @throws \Throwable
     */
    public function register(Request $request): JsonResponse|RedirectResponse
    {
        $request['password'] = isset($request['password']) && $request['password'] ? decryptString($request['password'], env('MIX_ENCRYPTION_KEY')) : '';
        $request['password_confirmation'] = isset($request['password_confirmation']) && $request['password_confirmation'] ? decryptString($request['password_confirmation'], env('MIX_ENCRYPTION_KEY')) : '';

        $validator = Validator::make($request->all(), [
            'username'              => ['required', 'max:255', 'string', 'unique:users,username'],
            'full_name'             => ['required', 'string', 'max:255'],
            'email'                 => ['required', 'string', 'email', 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,}$/ix', 'max:255', 'unique:users,email'],
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

        return response()->json(['success' => true, 'message' => ucfirst(trans('responses.event_successfully', ['prefix'=>trans('responses.user'), 'event'=>trans('events.deleted')]))]);
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\View\View|RedirectResponse
     */
    public function showRegistrationForm(): \Illuminate\View\View|RedirectResponse
    {
        try {
            $countries = getCodeListArray('Country', 'OrganizationArray');
            $registration_agencies = getCodeList('OrganizationRegistrationAgency', 'Organization');
            $uncategorizedRegistrationAgencyPrefix = Enums::UNCATEGORIZED_ORGANISATION_AGENCY_PREFIX;

            return view('web.register', compact('countries', 'registration_agencies', 'uncategorizedRegistrationAgencyPrefix'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('web.index.login');
        }
    }
}
