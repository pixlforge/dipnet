<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected  = 'categories';

    /**
     * Relationship to Article
     */
    public function article()
    {
        return $this->hasMany(Article::class);
    }
}
