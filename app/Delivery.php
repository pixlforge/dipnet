<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Delivery extends Model
{
    use SoftDeletes;

    protected $dates = [
        'to_deliver_at',
        'deleted_at'
    ];

    /**
     *
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($delivery) {
            $delivery->documents()->delete();
        });
    }

    /**
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'reference';
    }

    /**
     * @param Builder $builder
     * @return mixed
     */
    public function scopeOwnedByUsersCompany(Builder $builder)
    {
        return $this->whereIn('order_id', auth()->user()->company->orders->pluck('id'));
    }

    /**
     * @param Builder $builder
     * @return mixed
     */
    public function scopeOwnedBySoloUser(Builder $builder)
    {
        return $this->whereIn('order_id', auth()->user()->orders->pluck('id'));
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class)->withTrashed();
    }
}
