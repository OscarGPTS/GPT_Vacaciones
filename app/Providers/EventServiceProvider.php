<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;


class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        // 'OwenIt\Auditing\Events\Audited' => [
        //     'App\Listeners\AuditedListener',
        // ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {

    }

    protected $observers = [

    ];
}
