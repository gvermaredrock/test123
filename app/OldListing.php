<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OldListing extends Model
{
    protected $connection="oldpgsql";
    protected $table = 'listings_places';
    protected $casts = [
        'raw' => 'array',
        'meta_data' => 'array',
        'id'=>'string'
    ];
    protected $primaryKey = 'id2';
    public function search_results()
    {
        return $this->hasOne(OldListingSR::class,'listings_places_id2');
    }

}
