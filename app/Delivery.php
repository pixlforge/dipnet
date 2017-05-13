<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected  = 'deliveries';

    /**
     * Relationship to Contact
     */
    public function contact()
    {
        $this->belongsTo(Contact::class);
    }

    /**
     * Relationship to DeliveryComment
     */
    public function deliveryComment()
    {
        $this->hasMany(DeliveryComment::class);
    }

    /**
     * Relationship to Document
     */
    public function document()
    {
        $this->hasMany(Document::class);
    }

    /**
     * Relationship to Order
     */
    public function order()
    {
        $this->belongsTo(Order::class);
    }
}
