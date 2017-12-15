<?php

namespace Dipnet;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Delivery extends Model
{
    use SoftDeletes;

    /**
     * Carbon dates.
     */
    protected $dates = [
        'to_deliver_at',
        'deleted_at'
    ];

    /**
     * Disable mass assignment protection for the following attributes
     */
    protected $fillable = [
        'reference',
        'order_id',
        'contact_id',
        'to_deliver_at'
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($delivery) {
            $delivery->documents()->delete();
        });
    }

    /**
     * Route key name.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'reference';
    }

    /**
     * Check of the delivery belongs to the user's company.
     *
     * @return bool
     */
    public function belongsToUsersCompany()
    {
        return auth()->user()->company->id === $this->order->business->company->id;
    }

    /**
     * Associated order belongs to current user.
     *
     * @return bool
     */
    public function orderBelongsToUser()
    {
        return $this->order->user_id === auth()->id();
    }

    /**
     * Contact relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    /**
     * DeliveryComment relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function deliveryComment()
    {
        return $this->hasMany(DeliveryComment::class);
    }

    /**
     * Document relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    /**
     * Order relationship.
     *
     * @return mixed
     */
    public function order()
    {
        return $this->belongsTo(Order::class)->withTrashed();
    }
}