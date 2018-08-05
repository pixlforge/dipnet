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

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($delivery) {
            $delivery->documents()->delete();
        });
    }

    public function getRouteKeyName()
    {
        return 'reference';
    }

    public function scopeOwnedByUsersCompany(Builder $builder)
    {
        return $this->whereIn('order_id', auth()->user()->company->orders->pluck('id'));
    }

    public function scopeOwnedBySoloUser(Builder $builder)
    {
        return $this->whereIn('order_id', auth()->user()->orders->pluck('id'));
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class)->withTrashed();
    }
}
