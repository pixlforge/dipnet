<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusinessComment extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected  = 'business_comments';

    /**
     * Relationship to Business
     */
    public function business()
    {
        return $this->hasOne(Business::class);
    }

    /**
     * Relationship to User
     */
    public function user()
    {
        return $this->hasOne(User::class);
    }
}
