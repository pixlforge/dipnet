<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $dates = [
        'deleted_at',
    ];

    /**
     * Ge the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'reference';
    }

    /**
     * Fetch orders that are completed.
     *
     * @param Builder $builder
     * @return Builder
     */
    public function scopeCompleted(Builder $builder)
    {
        return $builder->whereIn('status', ['traitée', 'envoyée']);
    }

    /**
     * Fetch orders that belong to a company.
     *
     * @param Builder $builder
     * @return Builder
     */
    public function scopeOwn(Builder $builder)
    {
        if (auth()->user()->isPartOfACompany()) {
            return $builder->where('company_id', auth()->user()->company_id);
        } elseif (auth()->user()->isSolo()) {
            return $builder->where('user_id', auth()->id());
        }
    }

    /**
     * An order belongs to a business.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    /**
     * An order belongs to a company.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * An order belongs to a contact (billing).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    /**
     * An order may have many deliveries.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function deliveries()
    {
        return $this->hasMany(Delivery::class);
    }

    /**
     * An order may have many documents through its own deliveries.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function documents()
    {
        return $this->hasManyThrough(Document::class, Delivery::class);
    }

    /**
     * An order is managed by an admin.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function managedBy()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    /**
     * An order belongs to a user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
