<?php
namespace App\Services;
//use App\DBLogger;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SMS
{
    public static function sendotp($otp,$to)
    {
        $arrfields2 = "[{\"message\": \"".config('my.sms.otp').$otp."\",\"to\": [\"".$to."\"]}]";
        $js = json_decode($arrfields2);

        $response = Http::withHeaders([
            'authkey' => config('my.SMS_AUTHKEY'),
            'content-type' => 'application/json'
        ])->post('https://api.msg91.com/api/v2/sendsms',
            [
                "sender"=> "WUCHNA",
                "route"=> "4",
                "country"=> "91",
                "sms"=> $js
            ]
        );
//        \App\DBLogger::create(['event'=>'otpsent',
//            'payload'=> [
//                'user_phone' => $to,
//                'response' => $response
//            ]
//        ]);
        Log::notice('OTPSENT:to:'.$to.':at:'.now().':response:'.$response);
        return $response;
    }

//    public static function send($text,$to)
//    {
////        $arrfields2 = `{  "flow_id":"5fb9015a9a2a1454215ad011",  "sender" : "WUCHNA",   "recipients" : [
////        {   "mobiles":"919871002345", "link":"http://abc.com" }
////        ]}`;
////        $js = json_decode($arrfields2);
//
//        $response = Http::withHeaders([
//            'authkey' => "202315ARKtlurGqLND5d4c03bc",
//            'content-type' => 'application/json'
//        ])->post('https://api.msg91.com/api/v5/flow/',
//            [
//                "sender"=> "WUCHNA", "flow_id"=>"5fb9015a9a2a1454215ad011",
//                "recipients" => [
//                                [   "mobiles" => "919871002345", "link"=>"http://abc.com" ]
//                            ]
////                "route"=> "4",
////                "country"=> "91",
////                "sms"=> $js
//            ]
//        );
////       $arrfields2 = "[{\"message\": \"".$text."\",\"to\": [\"".$to."\"]}]";
////        $js = json_decode($arrfields2);
////
////        $response = Http::withHeaders([
////            'authkey' => "202315ARKtlurGqLND5d4c03bc",
////            'content-type' => 'application/json'
////        ])->post('https://api.msg91.com/api/v2/sendsms',
////            [
////                "sender"=> "WUCHNA",
////                "route"=> "4",
////                "country"=> "91",
////                "sms"=> $js
////            ]
////        );
////        \App\DBLogger::create(['event'=>'smssent',
////            'payload'=> [
////                'user_phone' => $to,
////                'text' => $text,
////                'response'=>$response
////            ]
////        ]);
//
//        Log::notice('SMSSENT:to:'.$to.':at:'.now().':response:'.$response);
//        return $response;
//    }

    public static function smsVendorReviewReplyLink($link,$to)
    {
        $response = Http::withHeaders([
            'authkey' => "202315ARKtlurGqLND5d4c03bc",
            'content-type' => 'application/json'
        ])->post('https://api.msg91.com/api/v5/flow/',
            [
                "sender"=> "WUCHNA", "flow_id"=>"5fb9015a9a2a1454215ad011",
                "recipients" => [ [   "mobiles" => "91".$to, "link"=>$link ] ]
            ]
        );
//        \App\DBLogger::create(['event'=>'smssent',
//            'payload'=> [
//                'user_phone' => $to,
//                'text' => $text,
//                'response'=>$response
//            ]
//        ]);

        Log::notice('smsVendorReviewReplyLink:to:'.$to.':at:'.now().':response:'.$response);
        return $response;
    }

    public static function smsVendorAboutLeadGenerated($listing,$user)
    {
        $to = ltrim(str_replace(' ','',$listing->phone), '0');
        $text = "Hi ".Str::words($listing->title,2,'..').", a user with verified phone ".$user->phone." just enquired about you at Wuchna Business Wikipedia";
        $arrfields2 = "[{\"message\": \"".$text."\",\"to\": [\"".$to."\"]}]";
        $js = json_decode($arrfields2);

        $response = Http::withHeaders([
            'authkey' => config('my.SMS_AUTHKEY'),
            'content-type' => 'application/json'
        ])->post('https://api.msg91.com/api/v2/sendsms',
            [
                "sender"=> "WUCHNA",
                "route"=> "4",
                "country"=> "91",
                "sms"=> $js
            ]
        );
//        \App\DBLogger::create(['event'=>'smssent',
//            'payload'=> [
//                'user_phone' => $to,
//                'text' => $text,
//                'response'=>$response
//            ]
//        ]);

        Log::notice('SMSSENT:to:'.$to.':at:'.now().':response:'.$response);
        return $response;

//        $response = Http::withHeaders([ 'authkey' => "202315ARKtlurGqLND5d4c03bc", 'content-type' => 'application/json'])
//            ->post('https://api.msg91.com/api/v5/flow/',
//            [
//                "sender"=> "WUCHNA", "flow_id"=>"5ee0092c52a1b13389e55962",
//                "recipients" => [ [
//                    "mobiles" => "91". ltrim(str_replace(' ','',$listing->raw['phone']) ,'0'),
//                    "vendorname"=>Str::words($listing->title,2,'..'),
//                    "usernum"=>$user->phone ] ]
//            ]
//        );
//        \App\DBLogger::create(['event'=>'smssent',
//            'payload'=> [
//                'user_phone' => $to,
//                'text' => $text,
//                'response'=>$response
//            ]
//        ]);
//        Log::notice('smsVendorAboutLeadGenerated:forListingId:'.$listing->id.':at:'.now().':response:'.$response);
//        return $response;
    }
}
