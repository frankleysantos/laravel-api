<?php

namespace App\Listeners;

use App\Events\EventNovoUsuario;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\EmailNovoUsuario;
use Illuminate\Support\Facades\Mail;

class ListenerEmailNovoUsuario
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
     * @param  EventNovoUsuario  $event
     * @return void
     */
    public function handle(EventNovoUsuario $event)
    {
        Mail::to($event->user['email'])
                ->send(new EmailNovoUsuario($event->user));
    }
}
