<?php

namespace App;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use Cachable;
    protected $guarded=[];
    protected $table="products";
    public function getRouteKeyName() { return 'slug'; }
    protected $casts=[
        'created_at'=>'datetime',
        'updated_at'=>'datetime',
        'data'=>'array'
    ];
    public function getFullLinkAttribute() {
        if($this->listing->city){
            return config('my.APP_URL').'/'.$this->listing->city->slug.'/'.$this->listing->slug.'/products/'.$this->slug;
        }else{
            return config('my.APP_URL').'/'.$this->listing->category->slug.'/'.$this->listing->slug.'/products/'.$this->slug;
        }
    }

    public function listing(){return $this->belongsTo(Listing::class,'listing_id');}


}
