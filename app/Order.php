<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function getRouteKeyName()
    {
        return 'reference';
    }

    public function scopeCompleted(Builder $builder)
    {
        return $builder->whereIn('status', ['traitée', 'envoyée']);
    }

    public function scopeOwn(Builder $builder)
    {
        return $builder->where('company_id', auth()->user()->company_id);
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function deliveries()
    {
        return $this->hasMany(Delivery::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function managedBy()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function documents()
    {
        return $this->hasManyThrough(Document::class, Delivery::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
