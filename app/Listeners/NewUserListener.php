<?php

namespace App\Listeners;

use App\Events\NewUserEvent;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewUserRegisterationEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NewUserListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(NewUserEvent $event): void
    {
        $user = $event->user;
        $role = $event->role;
        $password = $event->password;

        Mail::to($user)->send(new NewUserRegisterationEmail($user, $role, $password));
    }
}
