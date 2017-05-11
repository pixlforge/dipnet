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
        $this->hasOne(Contact::class);
    }

    /**
     * Relationship to Order
     */
    public function order()
    {
        $this->hasOne(Order::class);
    }
}
