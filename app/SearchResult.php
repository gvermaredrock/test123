<?php

namespace App;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class SearchResult extends Model
{
    use Cachable;
    protected $table="search_results";
    protected $casts=[
        'data'=>'array'
    ];
}
