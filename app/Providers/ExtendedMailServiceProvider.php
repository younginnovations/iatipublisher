<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Mail\MailServiceProvider;
use Illuminate\Support\Facades\Mail;

/**
 * Class ExtendedMailServiceProvider.
 */
class ExtendedMailServiceProvider extends MailServiceProvider
{
    /**
     * Bootstrap mail service.
     *
     * @return void
     */
    public function boot(): void
    {
        if (!app()->isProduction()) {
            Mail::fake();
        }
    }
}
