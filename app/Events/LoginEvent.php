<?php

namespace App\Events;

use Illuminate\Auth\Events\Login;

class LoginEvent
{

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function handle(Login $event)
    {
        try {
            $user = $event->user;
            $user->lastLogin = now();
            $user->timestamps = false;
            $user->save();
        } catch (\Throwable $th) {
            report($th);
        }
    }
}
