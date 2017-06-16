<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Business extends Model
{
    use SoftDeletes;

    /**
     * Carbon dates
     */
    protected $dates = ['deleted_at'];

    /**
     * Disable mass assignment protection for the following fields
     */
    protected $fillable = ['name', 'reference', 'description', 'company_id', 'contact_id', 'created_by_username'];

    /**
     * Relationship to BusinessComment
     */
    public function businessComment()
    {
        return $this->hasMany(BusinessComment::class);
    }

    /**
     * Relationship to Contact
     */
    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    /**
     * Relationship to Company
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Relationship to Order
     */
    public function order()
    {
        return $this->hasMany(Order::class);
    }
}
