<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Format extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function document()
    {
        return $this->hasMany(Document::class);
    }
}
