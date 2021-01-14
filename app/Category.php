<?php

namespace App;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use Cachable;
    protected $table = 'categories';
    protected $guarded = [];
    public function usesTimestamps() { return false; }

//    public $timestamps = false;
    protected $casts = ['data'=>'array'];
    public function getRouteKeyName() { return 'slug';}
    public function blog() { return $this->hasMany(Blog::class,'category_id');}
    public function blogs() { return $this->hasMany(Blog::class,'category_id');}
    public function listings() {return $this->hasManyThrough(Listing::class,Blog::class,'category_id','blog_id');}

    public function posts() { return $this->hasManyThrough(Post::class,Listing::class, Blog::class);}
    public function getFullLinkAttribute() { return config('my.APP_URL').'/'.$this->slug; }
//    public function leads(){return $this->blogs()->listings()->with}

}
