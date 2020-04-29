<?php

namespace App\Providers;

use App\Events\Property\PropertyBooking;
use App\Listeners\Product\ProductListener;
use App\Listeners\Property\PropertySellListener;
use App\Listeners\Service\ServiceListener;
use App\Listeners\User\UserListener;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [

    ];

    protected $subscribe =[
        ProductListener::class,
        PropertySellListener::class,
        ServiceListener::class,
        UserListener::class,


    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
