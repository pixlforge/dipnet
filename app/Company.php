<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes;

    /**
     * Carbon dates.
     */
    protected $dates = ['deleted_at'];

    /**
     * Disable mass assignment for the following fields
     */
    protected $fillable = [
        'name',
        'status',
        'description',
        'created_by_username'
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
     * Business relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function business()
    {
        return $this->hasMany(Business::class);
    }

    /**
     * Default business relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function defaultBusiness()
    {
        return $this->hasOne(Business::class, 'id', 'business_id');
    }

    /**
     * Contact relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contact()
    {
        return $this->hasMany(Contact::class);
    }

    /**
     * User relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function user()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Invitations relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }
}