<?php

namespace App\Providers;

use App\Models\ContactsStage;
use Illuminate\Auth\Events\Login;
use App\Events\ContactsStageCreated;
use App\Listeners\RedirectAfterLogin;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use App\Observers\ContactsStageObserver;
use App\Listeners\NotifyContactsStageCreated;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        Login::class => [
            RedirectAfterLogin::class
        ],
        ContactsStageCreated::class => [
            NotifyContactsStageCreated::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        ContactsStage::observe(ContactsStageObserver::class);

        parent::boot();
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
