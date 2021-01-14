<?php

namespace App;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

class Listing extends Model
{
//    use SoftDeletes;
    use Cachable;
    use \Znck\Eloquent\Traits\BelongsToThrough;
//
    protected static function booted()
    {
//        static::addGlobalScope('active', function (Builder $builder) {
//            $builder->where('expires_at', '>', now());
//        });

//        static::addGlobalScope('withListingsCount', function (Builder $builder) {
//            $builder->orWhereHas('listings')->whereNotNull('city_id');
//        });

    }
    protected $table = 'listings';
    protected $guarded = [];
    protected $casts=[
        'raw'=>'array',
        'data'=>'array',
        'business_data'=>'array',
        'created_at'=>'datetime',
        'updated_at'=>'datetime'
    ];


    public function getRouteKeyName() { return 'slug'; }
    public function getCategoryIdAttribute() { return $this->blog->category_id ;}
    public function getLocalityIdAttribute() { return $this->blog->locality_id ;}
    public function user(){ return $this->belongsTo(User::class,'user_id'); }
    public function owner(){ return $this->belongsTo(User::class,'user_id'); }
    public function blog() { return $this->belongsTo(Blog::class,'blog_id'); }
    public function reviews() { return $this->hasMany(Review::class,'listing_id'); }
    public function review() { return $this->hasMany(Review::class,'listing_id'); }
    public function city() { return $this->belongsTo(City::class,'city_id'); }
    public function category() { return $this->belongsToThrough(Category::class,Blog::class); }

    public function references(){ return $this->hasMany(Reference::class,'listing_id');}
    public function reference(){ return $this->hasMany(Reference::class,'listing_id');}

    public function leads(){ return $this->hasMany(Lead::class,'listing_id');}
    public function lead(){ return $this->hasMany(Lead::class,'listing_id');}
    public function keywords(){ return $this->hasMany(Keyword::class,'listing_id');}
    public function keyword(){ return $this->hasMany(Keyword::class,'listing_id');}
//    public function locality() { return $this->hasOneThrough(Locality::class,Blog::class,'locality_id','blog_id'); }  // use blog->locality

    public function getHalfLinkAttribute() { return $this->city->slug.'/'.$this->slug; }
    public function getFullLinkAttribute() { return config('my.APP_URL').'/'.$this->city->slug.'/'.$this->slug; }
    public function getAmpLinkAttribute() { return config('my.APP_URL').'/amp/'.$this->city->slug.'/'.$this->slug; }
//    public function getApprovedReviewsAttribute() { return $this->reviews->filter(function($item){return $item->data['status'] != 'unverified'; }); }
//    public function getApprovedReviewAttribute() { return $this->reviews->filter(function($item){return $item->data['status'] != 'unverified'; }); }
//    public function review() { return $this->hasMany(Review::class,'listing_id'); }


    public function updateViews() {
        $this->timestamps = false; $this->hitcounter = $this->hitcounter + 1; $this->save();
    }

    public function interaction(){return $this->hasMany(UserInteraction::class,'listing_id');}
    public function interactions(){return $this->hasMany(UserInteraction::class,'listing_id');}

    public function posts(){ return $this->hasMany(Post::class,'listing_id');}
    public function post(){ return $this->hasMany(Post::class,'listing_id');}

    public function products(){ return $this->hasMany(Product::class,'listing_id');}
    public function product(){ return $this->hasMany(Product::class,'listing_id');}
    public function productcategories(){ return $this->hasMany(ProductCategory::class,'listing_id');}
    public function productcategory(){ return $this->hasMany(ProductCategory::class,'listing_id');}

}
