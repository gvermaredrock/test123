<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $guarded = [];
    public $incrementing = false;
    public function usesTimestamps(){ return false; }

}
