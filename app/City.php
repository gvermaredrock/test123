<?php

namespace App;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use Cachable;
    protected $table = 'cities';
    protected $guarded = [];
    public function usesTimestamps(){ return false;}

    public function getRouteKeyName() { return 'slug'; }

    public function locality() { return $this->hasMany(Locality::class,'city_id'); }
    public function localities() { return $this->hasMany(Locality::class,'city_id'); }
    public function blog() { return $this->hasMany(Blog::class,'city_id'); }
    public function blogs() { return $this->hasMany(Blog::class,'city_id'); }
    public function listing() { return $this->hasMany(Listing::class,'city_id'); }
    public function listings() { return $this->hasMany(Listing::class,'city_id'); }

    public function getFullLinkAttribute() { return config('my.APP_URL').'/'.$this->slug; }

}
