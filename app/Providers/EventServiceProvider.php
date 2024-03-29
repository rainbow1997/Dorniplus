<?php

namespace App\Providers;

use App\Events\CommentSent;
use App\Listeners\CommentSentHandler;
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
        'App\Events\TempFileDownloaded' => [
            'App\Listeners\DeleteTempFiles',
        ],
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        CommentSent::class =>[
            CommentSentHandler::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
