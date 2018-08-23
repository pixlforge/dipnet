<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Ticker extends Model
{
    use SoftDeletes;

    protected $dates = [
        'deleted_at',
    ];

    protected $casts = [
        'active' => 'boolean'
    ];

    /**
     * Fetch the tickers that are active.
     *
     * @param Builder $builder
     * @return Builder
     */
    public function scopeActive(Builder $builder)
    {
        return $builder->where('active', true);
    }
}
