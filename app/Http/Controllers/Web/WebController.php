<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
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

        return view('web.welcome', compact('page', 'message'));
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
}
