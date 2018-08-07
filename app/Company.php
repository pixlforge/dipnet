<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     *
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('user', function ($builder) {
            $builder->with('user');
        });
    }

    /**
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * @return bool
     */
    public function hasDefaultBusiness()
    {
        return $this->business_id !== null;
    }

    /**
     * @return bool
     */
    public function hasNoDefaultBusiness()
    {
        return !$this->hasDefaultBusiness();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function business()
    {
        return $this->hasMany(Business::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function defaultBusiness()
    {
        return $this->belongsTo(Business::class, 'business_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function user()
    {
        return $this->hasMany(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
