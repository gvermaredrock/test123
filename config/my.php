<?php

return [
    'VUE_LINK' => env('VUE_LINK'),
    'CACHE_LIGHT_DURATION' => 1440,
    'CACHE_HEAVY_DURATION' => 7200,
    'APP_URL'=>env('APP_URL'),
    'LOCAL_COUNTRY_NAME'=>env('LOCAL_COUNTRY_NAME'),
    'SMS_AUTHKEY'=>env('SMS_AUTHKEY'),
    'sms'=>[
        'otp'=>'OTP for verification on Wuchna Business Network is ',
//        'otpsimple'=>'OTP for verification is ',
//        'warningofdeletiontomorrow' => 'Thanks for creating your Wuchna Business profile yesterday. Kindly verify your account at https://wuchna.com/verify or your profile will be deleted.',
    ],
    'rejectdomains'=>['business.site','business.google.com','google.com','facebook.com','justdial.com','g.page/'],

];
