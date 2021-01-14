<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;

class DigitalMarketingLead extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $phone;
    public function __construct($phone)
    {
        $this->phone = $phone;
    }

    public function build()
    {
        return $this->view('emails.digital-marketing-lead')->to('info@wuchna.com')->cc('alka@redrockdigimark.com')->from('digitalmarketinglead@wuchna.com')->subject('Digital Marketing Lead');
    }
}
