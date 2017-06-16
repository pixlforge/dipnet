<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    /**
     * Carbon dates
     */
    protected $dates = ['deleted_at'];

    /**
     * Disable mass assignment protection for given fields
     */
    protected $fillable = ['reference', 'status', 'business_id', 'contact_id', 'user_id'];

    /**
     * Relationship to Business
     */
    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    /**
     * Relationship to Contact
     */
    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    /**
     * Relationship to Delivery
     */
    public function delivery()
    {
        return $this->hasMany(Delivery::class);
    }

    /**
     * Relationship to User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
