<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    protected $fillable = [];

    /**
     * Relationship to BusinessComment
     */
    public function businessComment()
    {
        return $this->hasMany(BusinessComment::class);
    }

    /**
     * Relationship to Contact
     */
    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    /**
     * Relationship to Company
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Relationship to Order
     */
    public function order()
    {
        return $this->hasMany(Order::class);
    }

    public function getRouteKeyName()
    {
        return 'name';
    }
}
