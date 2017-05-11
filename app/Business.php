<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected  = 'businesses';

    /**
     * Relationship to BusinessComment
     */
    public function businessComment()
    {
        $this->belongsToMany(BusinessComment::class);
    }

    /**
     * Relationship to Contact
     */
    public function contact()
    {
        $this->belongsTo(Contact::class);
    }

    /**
     * Relationship to Company
     */
    public function company()
    {
        $this->hasOne(Company::class);
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
