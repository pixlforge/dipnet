<?php

namespace Dipnet;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Business extends Model
{
    use SoftDeletes;

    /**
     * Carbon dates.
     */
    protected $dates = [
        'deleted_at'
    ];

    /**
     * Disable mass assignment protection for the following fields
     */
    protected $fillable = [
        'name',
        'reference',
        'description',
        'company_id',
        'contact_id',
        'created_by_username'
    ];

    /**
     * BusinessComment relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function businessComment()
    {
        return $this->hasMany(BusinessComment::class);
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
     * Company relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
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
}
