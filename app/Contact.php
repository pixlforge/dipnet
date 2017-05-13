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
        return $this->hasOne(Business::class);
    }

    /**
     * Relationship to Company
     */
    public function company()
    {
        return $this->hasOne(Company::class);
    }

    /**
     * Relationship to Delivery
     */
    public function delivery()
    {
        return $this->hasMany(Delivery::class);
    }

    /**
     * Relationship to Order
     */
    public function order()
    {
        return $this->belongsToMany(Order::class);
    }

    /**
     * Relationship to User
     */
    public function user()
    {
        return $this->hasOne(User::class);
    }
}
