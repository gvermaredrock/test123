<?php

namespace App;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class LeadDistributionRules extends Model
{
    protected $guarded = [];
    protected static function booted()
    {
        static::addGlobalScope('active', function (Builder $builder) {
            $builder->where('expired_at', '>',now());
        });
    }

    use Cachable;

    protected $casts = [
        'data'=>'array',
        'updated_at'=>'datetime',
        'created_at'=>'datetime',
        'expired_at'=>'datetime',
    ];

    public function listing(){return $this->belongsTo(Listing::class,'listing_id');}
}
