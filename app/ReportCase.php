<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportCase extends Model
{
    protected $table='report_case';
    protected $guarded = [];
    protected $casts = [
        'data'=>'array',
        'created_at'=>'datetime',
        'updated_at'=>'datetime'
    ];

    public function user() { return $this->belongsTo(User::class,'user_id');}
    public function listing() { return $this->belongsTo(Listing::class,'listing_id');}
}
