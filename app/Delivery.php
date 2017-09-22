<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Delivery extends Model
{
    use SoftDeletes;

    /**
     * Carbon dates.
     */
    protected $dates = [
        'deleted_at'
    ];

    /**
     * Disable mass assignment protection for the following attributes
     */
    protected $fillable = [
        'order_id',
        'contact_id',
        'internal_comment'
    ];

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
    public function document()
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