<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Delivery extends Model
{
    use SoftDeletes;

    /**
     * Carbon dates
     */
    protected $dates = ['deleted_at'];

    /**
     * Disable mass assignment protection on declared fields
     */
    protected $fillable = ['order_id', 'contact_id', 'internal_comment'];

    /**
     * Relationship to Contact
     */
    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    /**
     * Relationship to DeliveryComment
     */
    public function deliveryComment()
    {
        return $this->hasMany(DeliveryComment::class);
    }

    /**
     * Relationship to Document
     */
    public function document()
    {
        return $this->hasMany(Document::class);
    }

    /**
     * Relationship to Order
     */
    public function order()
    {
        return $this->belongsTo(Order::class)->withTrashed();
    }
}
