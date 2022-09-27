<?php

namespace App\Listeners;

use App\Notifications\CommentSentNotif;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\User;
class CommentSentHandler
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        //
        $admin = User::whereHas('roles',function($query){
            return $query->where('name','Super Admin');
        })->first();
        $sender = new User;
        $sender->email = $event->comment->email;
        $admin->notify(new CommentSentNotif($event->comment));
        $admin->notify(new CommentSentNotif($event->comment));
    }
}
