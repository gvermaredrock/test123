<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;

class tellVendorAboutCustomerReview extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $listing; public $user;
    public function __construct($listing,$user)
    {
        $this->listing = $listing; $this->user = $user;
    }

    public function build()
    {
        return $this
            ->subject('Review Posted by a verified user')
            ->markdown('emails.tell-vendor-about-customer-review');
    }
}
