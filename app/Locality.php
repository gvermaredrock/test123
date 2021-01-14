<?php

namespace App;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class Locality extends Model
{
    use Cachable;
    protected $table = 'localities';
    protected $guarded = [];
    public $timestamps = false;
    protected $casts=[
      'data'=>'array',
      'nearbyplaces'=>'array',
    ];

    public function city() { return $this->belongsTo(City::class,'city_id'); }

    public function blog() { return $this->hasMany(Blog::class,'locality_id'); }
    public function blogs() { return $this->hasMany(Blog::class,'locality_id'); }

    public function listing() { return $this->hasManyThrough(Listing::class,Blog::class,'locality_id','blog_id');}
    public function listings() { return $this->hasManyThrough(Listing::class,Blog::class,'locality_id','blog_id');}

}
