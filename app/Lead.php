<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Lead extends Model
{
    use \Znck\Eloquent\Traits\BelongsToThrough;
    protected $guarded=[];
    protected $table="leads";

    public function user() { return $this->belongsTo(User::class,'user_id'); }
    public function listing() { return $this->belongsTo(Listing::class,'listing_id'); }
    public function blog(){ return $this->belongsToThrough(Blog::class,Listing::class);}
    public function category(){ return $this->belongsToThrough(Category::class,[Blog::class,Listing::class]);}
    public function city(){ return $this->belongsToThrough(City::class,[Blog::class,Listing::class]);}
//    public function ofCategory($id){ return $this->listing->blog->category()->where('id',$id);}

}
