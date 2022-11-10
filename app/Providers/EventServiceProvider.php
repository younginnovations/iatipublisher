<?php

namespace App\Providers;

use App\CsvImporter\Events\ActivityCsvWasUploaded;
use App\CsvImporter\Listeners\ActivityCsvUpload;
use App\IATI\Models\Activity\Activity;
use App\IATI\Models\Activity\Indicator;
use App\IATI\Models\Activity\Period;
use App\IATI\Models\Activity\Result;
use App\IATI\Models\Activity\Transaction;
use App\IATI\Models\Organization\Organization;
use App\Observers\ActivityObserver;
use App\Observers\IndicatorObserver;
use App\Observers\OrganizationObserver;
use App\Observers\PeriodObserver;
use App\Observers\ResultObserver;
use App\Observers\TransactionObserver;
use App\XmlImporter\Events\XmlWasUploaded;
use App\XmlImporter\Listeners\XmlUpload;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

/**
 * Class EventServiceProvider.
 */
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
        ActivityCsvWasUploaded::class => [ActivityCsvUpload::class],
        XmlWasUploaded::class => [XmlUpload::class],
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
        Result::observe(ResultObserver::class);
        Indicator::observe(IndicatorObserver::class);
        Period::observe(PeriodObserver::class);
    }
}
