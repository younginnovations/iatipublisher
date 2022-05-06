<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Log;

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

    protected Log $logger;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Log $logger)
    {
        $this->logger = $logger;
        $this->middleware('guest');
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
