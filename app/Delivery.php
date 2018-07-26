<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    public function belongsToUsersCompany()
    {
        return auth()->user()->company->id === $this->order->business->company->id;
    }

    public function orderBelongsToUser()
    {
        return $this->order->user_id === auth()->id();
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
