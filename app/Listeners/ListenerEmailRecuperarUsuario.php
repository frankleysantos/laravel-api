<?php

namespace App\Listeners;

use App\Events\EventRecuperarUsuario;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\EmailRecuperarUsuario;
use Illuminate\Support\Facades\Mail;

class ListenerEmailRecuperarUsuario
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
     * @param  EventRecuperarUsuario  $event
     * @return void
     */
    public function handle(EventRecuperarUsuario $event)
    {
        Mail::to($event->user['email'])
                ->send(new EmailRecuperarUsuario($event->user));
    }
}
