<?php

namespace App;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use Cachable;
    protected $guarded=[];
    protected $table="product_category";
    protected $casts=[
        'created_at'=>'datetime',
        'updated_at'=>'datetime',
        'data'=>'array'
    ];
    public function listing(){return $this->belongsTo(Listing::class,'listing_id');}

}
