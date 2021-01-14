<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OldLPSR extends Model
{
    protected $connection="oldpgsql";
    protected $table = 'search_results';
    public $guarded = [];
    protected $casts = [
        'raw' => 'array',
        'data' => 'array',
    ];

}
