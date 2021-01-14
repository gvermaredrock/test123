<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Redirect extends Model
{
    protected $guarded=[];
    public function usesTimestamps(){ return false; }
    protected $primaryKey="from";
//    public function getPrimaryKey(): string{ return 'from'; }
}
