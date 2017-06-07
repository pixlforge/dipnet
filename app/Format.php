<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Format extends Model
{
    protected $fillable = ['name', 'height', 'width', 'surface'];
    /**
     * Relationship to Document
     */
    public function document()
    {
        return $this->hasMany(Document::class);
    }

    public function getRouteKeyName()
    {
        return 'name';
    }
}
