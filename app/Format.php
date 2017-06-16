<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Format extends Model
{
    use SoftDeletes;

    /**
     * Carbon instances
     */
    protected $dates = ['deleted_at'];

    /**
     * Fillable fields
     */
    protected $fillable = ['name', 'height', 'width', 'surface'];

    /**
     * Relationship to Document
     */
    public function document()
    {
        return $this->hasMany(Document::class);
    }

    /**
     * Get the name as key route
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'name';
    }
}
