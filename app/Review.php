<?php

namespace App;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Znck\Eloquent\Traits\BelongsToThrough;

class Review extends Model
{
    use Cachable; use BelongsToThrough;
//    use SoftDeletes;
//    protected static function booted()
//    {
//        static::addGlobalScope('verified', function (Builder $builder) {
//            $builder->whereNotIn('data->status',  ['unverified','Rejected by Admin']);
//        });
//    }

    protected $table = "reviews";
    protected $guarded = [];
    protected $casts = [
        'created_at' => 'datetime',
        'replied_at' => 'datetime',
        'data'=>'array'
    ];


    public function listing()
    {
        return $this->belongsTo(Listing::class,'listing_id');
    }
    public function blog()
    {
        return $this->belongsToThrough(Blog::class, Listing::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

//    public function scopeVerified($query)
//    {
//        return $query->where('data->status', '!=', 'unverified');
//    }
}
