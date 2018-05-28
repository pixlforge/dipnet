<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticker extends Model
{
    use SoftDeletes;

    /**
     * Carbon dates.
     */
    protected $dates = ['deleted_at'];
}
