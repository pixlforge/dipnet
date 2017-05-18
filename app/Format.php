<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Format extends Model
{
    /**
     * Relationship to Document
     */
    public function document()
    {
        return $this->hasMany(Document::class);
    }
}
