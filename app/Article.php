<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;

    /**
     * Carbon instances
     */
    protected $dates = ['deleted_at'];
    
    /**
     * Fillable fields
     */
    protected $fillable = ['reference', 'description', 'type', 'category_id'];

    /**
     * Relationship to Category
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relationship to Document
     */
    public function document()
    {
        return $this->hasMany(Document::class);
    }

    /**
     * Relationship to Company
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the reference as a key route 
     * 
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'reference';
    }
}
