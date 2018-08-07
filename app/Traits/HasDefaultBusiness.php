<?php

namespace App\Traits;

use App\Business;

trait HasDefaultBusiness
{
    /**
     * Checks whether the company has an associated business set as default.
     *
     * @return bool
     */
    public function hasDefaultBusiness()
    {
        return $this->business_id !== null;
    }

    /**
     * Checks whether the company has no associated business set as default.
     *
     * @return bool
     */
    public function hasNoDefaultBusiness()
    {
        return !$this->hasDefaultBusiness();
    }

    /**
     * A company has a default business.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function defaultBusiness()
    {
        return $this->belongsTo(Business::class, 'business_id');
    }
}
