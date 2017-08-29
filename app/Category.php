<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $fillable = ['name'];

    /**
     * Relationship to Article
     */
    public function article()
    {
        return $this->hasMany(Article::class);
    }
}
