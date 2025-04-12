<?php

namespace App\Listeners;

use App\Events\OrderShippedEvent;
use App\Mail\OrderShipped;
use Illuminate\Support\Facades\Mail;

class SendOrderShippedEmail
{
    /**
     * Handle the event.
     *
     * @param  OrderShippedEvent  $event
     * @return void
     */
    public function handle(OrderShippedEvent $event)
    {
        // Send the email using the OrderShipped Mailable
        Mail::to($event->order->company->user->email)->send(new OrderShipped($event->order));
    }
}
