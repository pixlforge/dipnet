<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes;

    /**
     * Carbon dates
     */
    protected $dates = ['deleted_at'];

    /**
     * Disable mass assignment for the following fields
     */
    protected $fillable = [
        'name', 'status', 'description', 'created_by_username'
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('user', function ($builder) {
            $builder->with('user');
        });
    }


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
        return $this->belongsToMany(BusinessComment::class);
    }

    /**
     * Relationship to Contact
     */
    public function contact()
    {
        return $this->hasMany(Contact::class);
    }

    /**
     * Relationship to User
     */
    public function user()
    {
        return $this->hasMany(User::class);
    }
}
