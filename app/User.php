<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected  = 'users';

    /**
     * Relationship to BusinessComment
     */
    public function businessComment()
    {
        return $this->hasMany(BusinessComment::class);
    }

    /**
     * Relationship to Business
     */
    public function business()
    {
        return $this->hasMany(Business::class);
    }

    /**
     * Relationship to Contact
     */
    public function contact()
    {
        return $this->hasMany(Contact::class);
    }

    /**
     * Relationship to Company
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Relationship to DeliveryComment
     */
    public function deliveryComment()
    {
        return $this->hasMany(DeliveryComment::class);
    }

    /**
     * Relationship to Order
     */
    public function order()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
}
