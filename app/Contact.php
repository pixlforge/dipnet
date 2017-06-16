<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use SoftDeletes;

    /**
     * Carbon dates
     */
    protected $dates = ['deleted_at'];

    /**
     * Disable mass assignment protection for the following fields
     */
    protected $fillable = [
        'name',
        'address_line1',
        'address_line2',
        'zip',
        'city',
        'phone_number',
        'fax',
        'email',
        'company_id',
        'created_by_username'
    ];

    /**
     * Relationship to Business
     */
    public function business()
    {
        return $this->hasMany(Business::class);
    }

    /**
     * Relationship to Company
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
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
        return $this->hasMany(Order::class);
    }

    /**
     * Relationship to User
     */
    public function user()
    {
        return $this->hasMany(User::class);
    }
}
