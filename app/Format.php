<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Format extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'height', 'width', 'surface'];
    protected $dates = ['deleted_at'];

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
