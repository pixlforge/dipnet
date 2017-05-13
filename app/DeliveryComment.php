<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryComment extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected  = 'delivery_comments';

    /**
     * Relationship to Delivery
     */
    public function delivery()
    {
        $this->belongsTo(Delivery::class);
    }

    /**
     * Relationship to User
     */
    public function user()
    {
        $this->hasOne(User::class);
    }
}
