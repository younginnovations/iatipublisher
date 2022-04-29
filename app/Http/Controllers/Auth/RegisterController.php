<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\IATI\Services\Organization\OrganizationService;
use App\IATI\Services\User\UserService;
use App\Providers\RouteServiceProvider;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\DatabaseManager;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
     * Create a new controller instance.
     *
     * @return void
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
            'username'     => ['required', 'string', 'max:255', 'unique:users,username'],
            'full_name'    => ['required', 'string', 'max:255'],
            'email'        => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'publisher_id' => ['required', 'string', 'max:255', 'unique:organizations,publisher_id'],
            'password'     => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse|void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function verifyPublisher(Request $request)
    {
        try {
            $postData = $request->all();
            $validator = Validator::make($postData, [
                'publisher_id'        => ['required', 'max:255', 'unique:organizations,publisher_id'],
                'publisher_name'      => ['required', 'string', 'max:255'],
                'registration_agency' => ['required'],
                'registration_number' => ['required'],
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()]);
            }

            $client = new Client(['base_uri' => env('IATI_URL')]);
            $res = $client->request('GET', env('IATI_API_ENDPOINT') . '/action/organization_show', [
                'http_errors' => false,
                'query'       => ['id' => $postData['publisher_id']],
            ]);

            if ($res->getStatusCode() == 404) {
                return response()->json([
                    'success' => false,
                    'errors'  => ['publisher_name' => ['Publisher Name doesn\'t exists in IATI Registry']],
                ]);
            }

            $errors = [];
            $response = json_decode($res->getBody()->getContents())->result;

            if ($postData['publisher_name'] != $response->title) {
                $errors['publisher_name'] = ['Publisher Name doesn\'t match your IATI Registry information'];
            }

            if ($postData['registration_agency'] . '-' . $postData['registration_number'] != $response->publisher_iati_id) {
                $errors['publisher_iati_id'] = ['Publisher IATI ID doesn\'t match your IATI Registry information'];
            }

            if (!empty($errors)) {
                return response()->json([
                    'success'         => false,
                    'publisher_error' => 'true',
                    'errors'          => $errors,
                ]);
            }

            return response()->json(['success' => true, 'message' => 'Publisher verified successfully']);
        } catch (ClientException $e) {
            Log::error($e->getMessage());

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
            Log::error($e->getMessage());

            return response()->json(['success' => false, 'error' => 'Error has occurred while verifying the publisher.']);
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     *
     * @return \Illuminate\Database\Eloquent\Model|void
     */
    protected function create(array $data)
    {
        try {
            $this->db->beginTransaction();
            $user = $this->userService->registerExistingUser($data);

            $this->db->commit();

            return $user;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
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
            $countries = getCodeList('Country', 'Organization');
            $registration_agencies = getCodeList('OrganizationRegistrationAgency', 'Organization');

            return view('web.register', compact('countries', 'registration_agencies'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }

    /**
     * Handle a registration request for the application.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function register(Request $request): \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
    {
        $validator = Validator::make($request->all(), [
                'username'     => ['required', 'string', 'max:255', 'unique:users,username'],
                'full_name'    => ['required', 'string', 'max:255'],
                'email'        => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
                'publisher_id' => ['required', 'string', 'max:255', 'unique:organizations,publisher_id'],
                'password'     => ['required', 'string', 'min:8', 'confirmed'],
            ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()]);
        }

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        return response()->json(['success' => true, 'message' => 'User registered successfully']);
    }
}
