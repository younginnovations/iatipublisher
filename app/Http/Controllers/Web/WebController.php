<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

/**
 * Class WebController.
 */
class WebController extends Controller
{
    /**
     * Shows the web page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($page = 'signin'): \Illuminate\Contracts\Support\Renderable
    {
        $message = Str::contains(Redirect::intended()->getTargetUrl(), '/email/verify/') ? 'User must be logged in to verify email.' : '';
        $intent = !empty($message) ? 'verify' : '';

        if (Session::has('password_changed')) {
            $message = Session::get('password_changed');
            $intent = !empty($message) ? 'password_changed' : '';
        }

        return view('web.welcome', compact('page', 'intent', 'message'));
    }

    /**
     * Shows the web page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function register(): \Illuminate\Contracts\Support\Renderable
    {
        return view('web.register');
    }

    /**
     * Shows the about page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function about(): \Illuminate\Contracts\Support\Renderable
    {
        return view('web.about');
    }

    /**
     * Shows the publisher checklist page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function publishing_checklist(): \Illuminate\Contracts\Support\Renderable
    {
        return view('web.publishing_checklist');
    }

    /**
     * Shows the iati standard checklist page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function iati_standard(): \Illuminate\Contracts\Support\Renderable
    {
        return view('web.iati_standard');
    }

    /**
     * Shows the support checklist page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function support(): \Illuminate\Contracts\Support\Renderable
    {
        return view('web.support');
    }
}
