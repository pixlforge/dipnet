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
        $this->hasOne(Business::class);
    }

    /**
     * Relationship to Contact
     */
    public function contact()
    {
        $this->hasOne(Contact::class);
    }

    /**
     * Relationship to Delivery
     */
    public function delivery()
    {
        $this->hasMany(Delivery::class);
    }

    /**
     * Relationship to User
     */
    public function user()
    {
        $this->hasOne(User::class);
    }
}
