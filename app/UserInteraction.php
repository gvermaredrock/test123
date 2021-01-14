<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserInteraction extends Model
{
    protected $table="user_interaction";
    protected $guarded = [];
    protected $casts=[
        'created_at'=>'datetime',
        'updated_at'=>'datetime'
    ];

    public function user(){return $this->belongsTo(User::class,'user_id');}
    public function listing(){
        if($this->user){
            return $this->user->listing();
        }
        return $this->belongsTo(Listing::class,'listing_id');
    }

}
