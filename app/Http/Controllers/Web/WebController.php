<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

class WebController extends Controller
{
    public function index()
    {
        return view('web.join_now');
        // return view('web.welcome');
    }
}
