<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class smsVendorReviewReplyLink implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $link;
    protected $to;

    public function __construct($link,$to)
    {
        $this->link = $link;
        $this->to = $to;
    }

    public function handle()
    {
        return \App\Services\SMS::smsVendorReviewReplyLink($this->link,$this->to);
    }
}
