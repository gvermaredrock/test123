<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OldLP extends Model
{
    protected $connection="oldpgsql";
    protected $table="listingspages";
    protected $casts = [
        'meta_data' => 'array',
    ];

    public function search_results()
    {
        return $this->hasOne(OldLPSR::class,'listingspage_id');
    }
}
