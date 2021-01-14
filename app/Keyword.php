<?php

namespace App;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class Keyword extends Model
{
    use Cachable;
    protected $guarded=[];
    public function usesTimestamps(){ return false; }

}
