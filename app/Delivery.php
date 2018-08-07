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
        'deleted_at',
    ];

    /**
     * Deleting this model cascades to every associated document.
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($delivery) {
            $delivery->documents()->delete();
        });
    }

    /**
     * Get the route key name for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'reference';
    }

    /**
     * Fetch the deliveries that belong to the user's company.
     *
     * @param Builder $builder
     * @return mixed
     */
    public function scopeOwnedByUsersCompany(Builder $builder)
    {
        return $this->whereIn('order_id', auth()->user()->company->orders->pluck('id'));
    }

    /**
     * Fetch the deliveries that belong to the user.
     *
     * @param Builder $builder
     * @return mixed
     */
    public function scopeOwnedBySoloUser(Builder $builder)
    {
        return $this->whereIn('order_id', auth()->user()->orders->pluck('id'));
    }

    /**
     * A delivery belongs to a contact.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    /**
     * A delivery may have many documents.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    /**
     * A delivery belongs to an order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class)->withTrashed();
    }
}
