<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Ticker extends Model
{
    use SoftDeletes;

    /**
     * Carbon dates.
     */
    protected $dates = ['deleted_at'];

    public function scopeActive(Builder $builder)
    {
        return $builder->where('active', true);
    }
}
