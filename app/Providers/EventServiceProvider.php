<?php

namespace App\Providers;

use App\Events\OrderClosed;
use App\Events\OrderCreated;
use App\Events\OrderFillCreated;
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
        'Illuminate\Auth\Events\Registered' => [
            'App\Listeners\GiveInitialBalance',
        ],
	    OrderCreated::class => ['App\Listeners\FillOrder', 'App\Listeners\InvalidateOrderBook'],
	    OrderClosed::class => ['App\Listeners\ApplyOrderToBalances', 'App\Listeners\InvalidateOrderBook'],
	    OrderFillCreated::class => ['App\Listeners\InvalidateOrderBook'],
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
