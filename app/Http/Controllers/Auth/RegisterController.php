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

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(OrganizationService $organizationService, UserService $userService, Log $logger)
    {
        $this->organizationService = $organizationService;
        $this->userService = $userService;
        $this->logger = $logger;
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
            $data = $request->all();

            $validator = Validator::make($data, [
                'publisher_id'        => ['sometimes', 'max:255', 'unique:organizations,publisher_id'],
                'publisher_name'      => ['required', 'string', 'max:255'],
                'registration_agency' => ['required'],
                'registration_number' => ['required'],
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()]);
            }

            $client = new Client(
                [
                    'base_uri' => 'https://staging.iatiregistry.org',
                    'headers'  => [
                        'X-CKAN-API-Key' => env('IATI_API_KEY'),
                    ],
                ]
            );

            $res = $client->request('GET', 'https://staging.iatiregistry.org/api/action/organization_show', [
                'auth'  => [env('IATI_USERNAME'), env('IATI_PASSWORD')],
                'query' => ['id' => $data['publisher_id']],
            ]);

            $response = json_decode($res->getBody()->getContents())->result;

            if ($data['publisher_name'] != $response->title) {
                return response()->json(['publisher_error' => 'true', 'errors' => ['publisher_name' => ['Publisher Name doesn\'t match your IATI Registry information'], 'publisher_id' => ['Publisher ID doesn\'t match with your IATI Registry information']]]);
            }

            if ($data['registration_agency'] . '-' . $data['registration_number'] != $response->publisher_iati_id) {
                return response()->json(['publisher_error' => 'true', 'errors' => ['publisher_name' => ['Publisher Name doesn\'t match your IATI Registry information']]]);
            }

            return response()->json(['success' => 'Publisher verified successfully']);
        } catch (ClientException $e) {
            Log::error($e);

            return response()->json(
                [
                    'errors' => [
                        'publisher_error' => 'true',
                        'publisher_name'  => ['Publisher Name doesn\'t match your IATI Registry information'],
                        'publisher_id'    => ['Publisher ID doesn\'t match with your IATI Registry information'],
                    ],
                ]
            );
        } catch (Exception $e) {
            Log::error($e);

            return response()->json(['error' => 'Error has occurred while verifying the publisher.']);
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     *
     * @return \App\Models\User
     */
    protected function create(array $data): \App\Models\User
    {
        try {
            return $this->userService->registerExistingUser($data);
        } catch (\Exception $e) {
            Log::error($e);
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
            $countries = $this->userService->getCodeList('Country', 'Organization');
            $registration_agencies = $this->userService->getCodeList('OrganizationRegistrationAgency', 'Organization');

            return view('web.register', compact('countries', 'registration_agencies'));
        } catch (\Exception $e) {
            Log::error($e);
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
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);
        $response = $this->registered($request, $user);

        if ($response) {
            return $response;
        }

        return response()->json(['success' => 'User registered successfully']);
    }
}
