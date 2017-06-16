<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name'];

    /**
     * Relationship to Article
     */
    public function article()
    {
        return $this->hasMany(Article::class);
    }
}
