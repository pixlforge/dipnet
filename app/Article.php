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

    /**
     * @param Builder $builder
     * @return Builder
     */
    public function scopePrintTypes(Builder $builder)
    {
        return $builder->where('type', 'impression')->orderBy('description');
    }

    /**
     * @param Builder $builder
     * @return Builder
     */
    public function scopeOptionTypes(Builder $builder)
    {
        return $builder->where('type', 'option')->orderBy('description');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function document()
    {
        return $this->hasMany(Document::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function documents()
    {
        return $this->belongsToMany(Document::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
