<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Format extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected  = 'formats';

    /**
     * Relationship to Document
     */
    public function document()
    {
        $this->hasMany(Document::class);
    }
}
