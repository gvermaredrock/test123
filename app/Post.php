<?php

namespace App;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use \Znck\Eloquent\Traits\BelongsToThrough;

    use Cachable;
    protected $guarded=[];
    protected $table="posts";
    public function getRouteKeyName() { return 'slug'; }
    protected $casts=[
        'created_at'=>'datetime',
        'updated_at'=>'datetime',
        'data'=>'array'
    ];

    public function getFullLinkAttribute() {
        if($this->listing->city){
            return config('my.APP_URL').'/'.$this->listing->city->slug.'/'.$this->listing->slug.'/posts/'.$this->slug;
        }else{
            return config('my.APP_URL').'/'.$this->listing->category->slug.'/'.$this->listing->slug.'/posts/'.$this->slug;
        }
    }
    public function listing(){return $this->belongsTo(Listing::class,'listing_id');}
    public function blog(){return $this->belongsToThrough(Blog::class,Listing::class);}
    public function author(){return $this->belongsTo(User::class,'user_id');}

}
