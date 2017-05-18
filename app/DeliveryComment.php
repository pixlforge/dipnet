<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryComment extends Model
{
    /**
     * Relationship to Delivery
     */
    public function delivery()
    {
        return $this->belongsTo(Delivery::class);
    }

    /**
     * Relationship to User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
