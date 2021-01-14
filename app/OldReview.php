<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OldReview extends Model
{
    protected $connection="oldpgsql";
    protected $table="listings_places_reviews";
    protected $casts = [
        'meta_data' => 'array',
    ];

    public function listing()
    {
        return $this->belongsTo(OldListing::class,'listings_place_id2');
    }


}
