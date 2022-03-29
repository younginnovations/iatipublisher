<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\IATI\Models\User\User;
use App\Providers\RouteServiceProvider;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'identifier' => ['required', 'string', 'max:255', 'unique:organizations,identifier'],
            'publisher_id' => ['required', 'string', 'max:255', 'unique:organizations,publisher_id'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],

        ]);
    }

    public function verifyPublisher(Request $request)
    {
        try {
            $data = $request->all();

            $validator = Validator::make($data, [
          'identifier' => ['required', 'string', 'max:255', 'unique:organizations,identifier'],
          'publisher_id' => ['required', 'string', 'max:255', 'unique:organizations,publisher_id'],
          'publisher_name' => ['required', 'string', 'max:255'],
        ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()]);
            }

            $client = new Client(
                [
            'base_uri'=>'https://staging.iatiregistry.org',
            'headers'=> [
              'X-CKAN-API-Key' => env('IATI_API_KEY '), ],
            ]
            );

            $res = $client->request('GET', 'https://staging.iatiregistry.org/api/action/organization_show', [
            'auth' => [env('IATI_USERNAME '), env('IATI_PASSWORD ')],
            'query' => ['id' => $data['publisher_id']],
        ]);

            $response = json_decode($res->getBody()->getContents())->result;

            if ($data['publisher_name'] != $response->title || $data['identifier'] != $response->publisher_iati_id) {
                return response()->json(['publisher_error' => 'true', 'errors' => ['publisher_name' => ['Publisher Name doesn\'t match your IATI Registry information'], 'publisher_id' => ['Publisher ID doesn\'t match with your IATI Registry information']]]);
            }

            return response()->json(['success' => 'Publisher verified successfully']);
        } catch (ClientException $e) {
            return response()->json(['errors' => ['publisher_error' => 'true', 'publisher_name' => ['Publisher Name doesn\'t match your IATI Registry information'], 'publisher_id' => ['Publisher ID doesn\'t match with your IATI Registry information']]]);
        } catch (Exception $e) {
            dd($e);
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        try {
            $countries = trans('user.country_list');
            $registration_agencies = trans('user.registration_agency');

            return view('web.register', compact('countries', 'registration_agencies'));
        } catch (\Exception $e) {
            dd($e);
        }
    }
}
