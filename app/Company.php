<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('user', function ($builder) {
            $builder->with('user');
        });
    }

    public function hasNoDefaultBusiness()
    {
        return $this->business_id === null;
    }

    public function business()
    {
        return $this->hasMany(Business::class);
    }

    public function defaultBusiness()
    {
        return $this->hasOne(Business::class, 'id', 'business_id');
    }

    public function contact()
    {
        return $this->hasMany(Contact::class);
    }

    public function user()
    {
        return $this->hasMany(User::class);
    }

    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }
}
