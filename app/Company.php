<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected  = 'companies';

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
        $this->hasOne(User::class);
    }
}
