<?php

namespace Dipnet;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    /**
     * Carbon dates.
     */
    protected $dates = ['deleted_at'];

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
     * Route key name.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'reference';
    }

    /**
     * Fetch all orders except those that are incomplete.
     *
     * @param Builder $builder
     * @return Builder
     */
    public function scopeCompleted(Builder $builder)
    {
        return $builder->whereIn('status', ['réceptionnée', 'traitée', 'envoyée']);
    }

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
     * Deliveries relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function deliveries()
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

    /**
     * Documents relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function documents()
    {
        return $this->hasManyThrough(Document::class, Delivery::class);
    }
}