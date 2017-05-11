<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected  = 'contacts';

    /**
     * Relationship to Business
     */
    public function business()
    {
        $this->hasOne(Business::class);
    }

    /**
     * Relationship to Company
     */
    public function company()
    {
        $this->hasOne(Company::class);
    }

    /**
     * Relationship to Delivery
     */
    public function delivery()
    {
        $this->belongsTo(Delivery::class);
    }

    /**
     * Relationship to Order
     */
    public function order()
    {
        $this->belongsToMany(Order::class);
    }

    /**
     * Relationship to User
     */
    public function user()
    {
        $this->hasOne(User::class);
    }
}
