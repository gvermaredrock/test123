<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;

class SeoLead extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $phone;
    public function __construct($phone)
    {
        $this->phone = $phone;
    }

    public function build()
    {
        return $this->view('emails.seo-lead')->to('info@wuchna.com')->to('alka@redrockdigimark.com')->from('seolead@wuchna.com')->subject('SEOLEAD');
    }
}
