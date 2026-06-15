<?php

namespace App\Listeners;

use App\Events\EnquiryCreated;
use App\Mail\EnquiryCreatedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendEnquiryNotification implements ShouldQueue
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
    public function handle(EnquiryCreated $event): void
    {
        Mail::to(
            $event->enquiry->email
        )->send(
            new EnquiryCreatedMail(
                $event->enquiry
            )
        );
    }
}
