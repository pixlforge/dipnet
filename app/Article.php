<?php

namespace App;

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
        'type',
        'category_id'
    ];

    /**
     * Use the reference attribute in routes.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'reference';
    }

    /**
     * Category relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
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
     * Company relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
