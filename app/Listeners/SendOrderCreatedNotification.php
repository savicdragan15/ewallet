<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use Mail;

class SendOrderCreatedNotification
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
     * @param  OrderCreated  $event
     * @return void
     */
    public function handle(OrderCreated $event)
    {
        Mail::to($event->order->orderUser->email)
            ->send(new \App\Mail\OrderCreated($event->order));
    }
}
