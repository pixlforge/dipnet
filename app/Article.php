<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    
    protected $casts = ['greyscale' => 'boolean'];

    public function scopePrintTypes(Builder $builder)
    {
        return $builder->where('type', 'impression')->orderBy('description');
    }

    public function scopeOptionTypes(Builder $builder)
    {
        return $builder->where('type', 'option')->orderBy('description');
    }

    public function document()
    {
        return $this->hasMany(Document::class);
    }

    public function documents()
    {
        return $this->belongsToMany(Document::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
