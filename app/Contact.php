<?php

namespace Dipnet;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use SoftDeletes;

    /**
     * Carbon dates
     */
    protected $dates = [
        'deleted_at'
    ];

    /**
     * Disable mass assignment protection for the following attributes
     */
    protected $fillable = [
        'name',
        'address_line1',
        'address_line2',
        'zip',
        'city',
        'phone_number',
        'fax',
        'email',
        'user_id',
        'company_id'
    ];

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
     * Company relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Delivery relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function deliveries()
    {
        return $this->hasMany(Delivery::class);
    }

    /**
     * Order relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function order()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * User relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
