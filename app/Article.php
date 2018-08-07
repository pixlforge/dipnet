<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;

    protected $dates = [
        'deleted_at',
    ];
    
    protected $casts = [
        'greyscale' => 'boolean',
    ];

    /**
     * Fetch articles where type is impression.
     *
     * @param Builder $builder
     * @return Builder
     */
    public function scopePrintTypes(Builder $builder)
    {
        return $builder->where('type', 'impression')->orderBy('description');
    }

    /**
     * Fetch articles where type is option.
     *
     * @param Builder $builder
     * @return Builder
     */
    public function scopeOptionTypes(Builder $builder)
    {
        return $builder->where('type', 'option')->orderBy('description');
    }

    /**
     * An article has many documents.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function documents()
    {
        return $this->belongsToMany(Document::class);
    }
}
