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
    protected $dates = [
        'deleted_at'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password', 'role', 'contact_id', 'company_id',
        'confirmed', 'confirmation_token', 'contact_confirmed', 'company_confirmed'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * The attributes that are cast into specific primitives.
     */
    protected $casts = [
        'confirmed' => 'boolean'
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

    public function confirm()
    {
        $this->confirmed = true;
        $this->save();
    }
}
