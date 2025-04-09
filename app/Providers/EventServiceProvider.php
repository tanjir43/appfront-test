<?php

namespace App\Providers;

use App\Events\ProductPriceChanged;
use App\Listeners\SendPriceChangeNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{

    protected $listen = [
        # Authentication events
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        # Product events
        ProductPriceChanged::class => [
            SendPriceChangeNotification::class,
        ],
    ];

    public function boot(): void
    {
        //
    }

    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
