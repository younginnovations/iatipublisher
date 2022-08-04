<?php

namespace App\Providers;

use App\IATI\Models\Activity\Activity;
use App\IATI\Models\Activity\Transaction;
use App\IATI\Models\Organization\Organization;
use App\Observers\ActivityObserver;
use App\Observers\OrganizationObserver;
use App\Observers\TransactionObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class                 => [
            SendEmailVerificationNotification::class,
        ],
        'Illuminate\Auth\Events\Verified' => [
            'App\Listerners\LogVerifieduser',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Activity::observe(ActivityObserver::class);
        Organization::observe(OrganizationObserver::class);
        Transaction::observe(TransactionObserver::class);
    }
}
