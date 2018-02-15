<?php

namespace Dipnet;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;

    /**
     * Carbon instances.
     */
    protected $dates = [
        'deleted_at'
    ];
    
    /**
     * Fillable fields.
     */
    protected $fillable = [
        'reference',
        'description',
        'type'
    ];

    /**
     * Casting
     */
    protected $casts = [
        'greyscale' => 'boolean'
    ];

    /**
     * Scope the query by print.
     *
     * @param Builder $builder
     * @return $this
     */
    public function scopePrintTypes(Builder $builder)
    {
        return $builder->where('type', 'impression')->orderBy('description');
    }

    /**
     * Scope the query by option.
     *
     * @param Builder $builder
     * @return $this
     */
    public function scopeOptionTypes(Builder $builder)
    {
        return $builder->where('type', 'option')->orderBy('description');
    }

    /**
     * Document relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function document()
    {
        return $this->hasMany(Document::class);
    }

    /**
     * Documents relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function documents()
    {
        return $this->belongsToMany(Document::class);
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
}
