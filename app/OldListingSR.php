<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OldListingSR extends Model
{
    protected $connection="oldpgsql";
    protected $table = 'listings_places_search_results';
    public $guarded = [];
    protected $casts = [
        'raw' => 'array',
        'data' => 'array',
    ];

}
