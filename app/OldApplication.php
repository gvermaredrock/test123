<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OldApplication extends Model
{
    protected $connection="oldpgsql";
    protected $table = 'applications';
    protected $guarded = [];

}
