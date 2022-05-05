<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

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
        return view('web.welcome', compact('page'));
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
