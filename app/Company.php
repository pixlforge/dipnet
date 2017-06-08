<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * Relationship to Business
     */
    public function business()
    {
        return $this->hasMany(Business::class);
    }

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
        $this->hasMany(Contact::class);
    }

    /**
     * Relationship to User
     */
    public function user()
    {
        $this->hasMany(User::class);
    }

    public function getRouteKeyName()
    {
        return 'name';
    }
}
