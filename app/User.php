<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    /**
     * Carbon dates
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password', 'role', 'contact_id', 'company_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password','remember_token',
    ];

    protected static function boot()
    {
        parent::boot();

        /**
         * Creates a contact when a user successfully registers
         */
//        static::creating(function () {
//            Contact::create([
//                'name' => request('username'),
//                'address_line1' => request('address_line1'),
//                'address_line2' => request('address_line2'),
//                'zip' => request('zip'),
//                'city' => request('city'),
//                'phone_number' => request('phone_number'),
//                'fax' => request('fax'),
//                'email' => request('email'),
//                'company_id' => 1,
//                'created_by_username' => request('username')
//            ]);
//        });
    }

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
     * Relationship to Contact
     */
    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    /**
     * Set the username attribute as a key used in routing
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'username';
    }

}
