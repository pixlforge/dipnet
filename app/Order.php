<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'reference';
    }

    /**
     * @param Builder $builder
     * @return Builder
     */
    public function scopeCompleted(Builder $builder)
    {
        return $builder->whereIn('status', ['traitée', 'envoyée']);
    }

    /**
     * @param Builder $builder
     * @return Builder
     */
    public function scopeOwn(Builder $builder)
    {
        return $builder->where('company_id', auth()->user()->company_id);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function deliveries()
    {
        return $this->hasMany(Delivery::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function managedBy()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function documents()
    {
        return $this->hasManyThrough(Document::class, Delivery::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
