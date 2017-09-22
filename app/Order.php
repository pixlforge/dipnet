<?php

namespace App;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes, Searchable;

    /**
     * Carbon dates.
     */
    protected $dates = [
        'deleted_at'
    ];

    /**
     * Disable mass assignment protection for the following attributes.
     */
    protected $fillable = [
        'reference',
        'status',
        'business_id',
        'contact_id',
        'user_id'
    ];

    /**
     * Business relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    /**
     * Contact relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    /**
     * Delivery relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function delivery()
    {
        return $this->hasMany(Delivery::class);
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
