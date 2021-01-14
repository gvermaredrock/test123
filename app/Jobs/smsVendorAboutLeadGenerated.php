<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class smsVendorAboutLeadGenerated implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $listing; public $user;
    public function __construct($listing, $user)
    {
        $this->listing=$listing; $this->user = $user;
    }

    public function handle()
    {
        return \App\Services\SMS::smsVendorAboutLeadGenerated($this->listing,$this->user);
    }
}
