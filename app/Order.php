<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected  = 'orders';

    /**
     * Relationship to Business
     */
    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    /**
     * Relationship to Contact
     */
    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    /**
     * Relationship to Delivery
     */
    public function delivery()
    {
        return $this->hasMany(Delivery::class);
    }

    /**
     * Relationship to User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
