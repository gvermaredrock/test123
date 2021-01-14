<?php

namespace App\Http\Controllers;
// use App\Jobs\SMSOTP;
use App\Lead;
use App\Listing;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function loginviaotp(Request $request)
    {
        $validated = $request->validate([
            'email'=>'required|email'
        ]);
        $user = User::where('email',$validated['email'])->first();
        if(!$user){return back()->withMessage('No Such User');}
        $otp = rand(100000,999999);

        $data = $user->data; $data['otpsent'] = $otp; $user->data = $data; $user->save();
        // send OTP via SMS
        // SMSOTP::dispatch($otp,ltrim($validated['phone'],'0'))
        //     ->delay(now()->addSeconds(1));

        Mail::to($validated['email'])->queue(new otpSender($otp));

        return view('auth.loginviaotp',compact(['user']));
    }

    public function apiLoginviaotp(Request $request)
    {
        $validated = $request->validate([
            'email'=>'required|email'
        ]);
        $user = User::where('email',$validated['email'])->first();
        if(!$user){
            throw ValidationException::withMessages([
                'email' => ['No such user'],
            ]);
        }
        $otp = rand(100000,999999);

        $data = $user->data; $data['otpsent'] = $otp; $user->data = $data; $user->save();
        // send OTP via SMS
        // SMSOTP::dispatch($otp,ltrim($validated['phone'],'0'))
        //     ->delay(now()->addSeconds(1));

        Mail::to($validated['email'])->queue(new otpSender($otp));

        return ['status'=>'ok'];
    }

    public function clicktocall(Request $request)
    {
        $validated = $request->validate([
            'email'=>'required|email'
        ]);
        $user = User::where('email',$validated['email'])->first();
        if(!$user){
            try {
                // make a user
                $user = User::create([
                    'name'=>$validated['email'], 'email' => $validated['email'], 'password'=>bcrypt(Str::random('12')), 'phone'=>$validated['email']
                ]);
            }catch(\Exception $e){
                return 'error';
            }
        }

        $otp = rand(100000,999999);
        $data = $user->data; $data['otpsent'] = $otp; $user->data = $data; $user->save();
        // // send OTP via SMS
        // SMSOTP::dispatch($otp,ltrim($validated['phone'],'0'))
        //     ->delay(now()->addSeconds(1));

        Mail::to($validated['email'])->queue(new otpSender($otp));

        return 'ok';
    }

    public function clicktocallotp(Request $request)
    {
        $validated = $request->validate([
            'otp'=>'required|numeric|min:100000',
            'email'=>'required',
            'listing'=>'required|exists:listings,id'
        ]);
        $user = User::where('email',$validated['email'])->first();
        if(!$user){return back()->withMessage('No Such User');}
        if($user->data['otpsent'] == $validated['otp']){
            $user->update(['phone_verified_at' => now()]);
            Auth::login($user, true);
            // send SMS to Vendor that a lead has been generated for his business
            $listing = Listing::find($validated['listing']);
            if($listing->phone) {
                \App\Jobs\smsVendorAboutLeadGenerated::dispatch($listing, $user)
                    ->delay(now()->addSeconds(1));
            }
            Lead::create(['user_id'=>auth()->id(),'listing_id'=>$listing->id]);
            return 'ok';
        }
        return 'wrongotp';
    }

    public function enterotp(Request $request)
    {
        $validated = $request->validate([
            'otp'=>'required|numeric|min:100000',
            'email'=>'required'
        ]);
        $user = User::where('email',$validated['email'])->first();
        if(!$user){return back()->withMessage('No Such User');}

        if($user->data['otpsent'] == $validated['otp']){
            Auth::login($user, true);
            return redirect('/home');
        }
    }

    public function apiEnterotp(Request $request)
    {
        $validated = $request->validate([
            'otp'=>'required|numeric|min:100000',
            'email'=>'required'
        ]);
        $user = User::where('email',$validated['email'])->first();
        if(!$user){
            throw ValidationException::withMessages([
                'email' => ['No such user'],
            ]);
        }

        if($user->data['otpsent'] == $validated['otp']){
            return $user->createToken('mobile')->plainTextToken;
//
//            Auth::login($user, true);
//            return redirect('/home');
        }


    }
}
