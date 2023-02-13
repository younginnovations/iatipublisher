<?php

namespace App\Providers;

use Illuminate\Mail\MailServiceProvider;
use Illuminate\Support\Facades\Mail;

class ExtendedMailServiceProvider extends MailServiceProvider
{
    public function boot()
    {
        if (!app()->isProduction()) {
            Mail::fake();
        }
    }
}
