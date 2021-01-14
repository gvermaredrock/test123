<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OldGeocoding extends Model
{
    protected $connection="oldpgsql";
    protected $table = 'geocoding';
    protected $casts = [
        'raw' => 'array',
        '_geoloc' => 'array',
        'nearbyplaces' => 'array',
    ];
}
