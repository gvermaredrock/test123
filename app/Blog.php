<?php

namespace App;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Blog extends Model
{
    // use Searchable;
    use Cachable;
    protected static function booted()
    {
//        static::addGlobalScope('active', function (Builder $builder) {
//            $builder->where('expires_at', '>', now());
//        });

//        static::addGlobalScope('withListingsCount', function (Builder $builder) {
//            $builder->orWhereHas('listings')->whereNotNull('city_id');
//        });

    }

    protected $table = 'blogs';
    protected $guarded = [];
    public function getRouteKeyName() { return 'slug'; }
    public function searchableAs() { return strtoupper(config('my.LOCAL_COUNTRY_NAME')).'lp_index'; }

    protected $casts=[
        'data'=>'array',
        'raw'=>'array',
        'created_at'=>'datetime',
        'expires_at'=>'datetime',
        'updated_at'=>'datetime'
    ];

    public function toSearchableArray()
    {
        $array = [
            'slug' => $this->slug,
            'city' => $this->city ? $this->city->slug : '',
            'category' => $this->category ? $this->category->slug : '',
            'locality' => $this->locality ? $this->locality->slug : '',
            'places' => $this->listings()->pluck('title')
        ];

        return $array;
    }

    public function search_result() { return $this->hasOne(SearchResult::class,'listingspage_id'); }
    public function search_results() { return $this->hasOne(SearchResult::class,'listingspage_id'); }

    public function listing() { return $this->hasMany(Listing::class,'blog_id'); }
    public function listings() { return $this->hasMany(Listing::class,'blog_id'); }

    public function reference(){ return $this->hasMany(Reference::class,'blog_id');}
    public function references(){ return $this->hasMany(Reference::class,'blog_id');}

    public function city() { return $this->belongsTo(City::class,'city_id'); }
    public function locality() { return $this->belongsTo(Locality::class,'locality_id'); }
    public function category() { return $this->belongsTo(Category::class,'category_id'); }

    public function keywords(){ return $this->hasMany(Keyword::class,'blog_id');}
    public function keyword(){ return $this->hasMany(Keyword::class,'blog_id');}


    public function getHalfLinkAttribute()
    {
        if($this->city) {
            return $this->city->slug . '/' . $this->slug;
        }else{
            return $this->category->slug . '/' . $this->slug;
        }
    }

    public function getFullLinkAttribute()
    {
        if($this->city) {
            return config('my.APP_URL') . '/' . $this->city->slug . '/' . $this->slug;
        }else{
            return config('my.APP_URL') . '/' . $this->category->slug . '/' . $this->slug;
        }
    }

    public function getAmpLinkAttribute()
    {
        if($this->city) {
            return config('my.APP_URL') . '/ampb/' . $this->city->slug . '/' . $this->slug;
        }else{
            return config('my.APP_URL') . '/ampb/' . $this->category->slug . '/' . $this->slug;
        }
    }

    public function updateViews() {
        $blog = $this;
         $this::withoutSyncingToSearch(function()use($blog){
             $blog->timestamps = false; $blog->hitcounter = $blog->hitcounter + 1;
             $blog->save();
         });
    }

    public function posts(){ return $this->hasManyThrough(Post::class,Listing::class);}

}
