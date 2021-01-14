<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, Billable;
    protected $fillable = [ 'name', 'email', 'password', 'phone','phone_verified_at' ];
    protected $hidden = [ 'password', 'remember_token','stripe_id','card_brand','card_last_four','trial_ends_at','data'];
    protected $casts = [ 'phone_verified_at' => 'datetime', 'data'=>'array' ];

    public static function createFromPhone(array $attributes = []): self
    {
        return self::create([
            'name' => $attributes['phone'],
            'email' => $attributes['phone'].'@wuchna.com',
            'phone' => $attributes['phone'],
            'password'=>bcrypt('hello@123#^&')
        ]);
    }
    public function listing(){return $this->hasOne(Listing::class,'user_id');}
    public function reportcases() { return $this->hasMany(ReportCase::class,'user_id');}
    public function reviews() { return $this->hasMany(Review::class,'user_id');}

    public function getDisplayNameAttribute() {  if($this->id ==1 ){return 'Verified User';} if( $this->email ==  strval($this->phone).'@wuchna.com' ){ return 'Verified User';} else{ return $this->name; } }

    public function interactions(){return $this->hasMany(UserInteraction::class,'user_id');}
}
