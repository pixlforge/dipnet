<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected  = 'articles';

    /**
     * Relationship to Category
     */
    public function category()
    {
        $this->hasOne(Category::class);
    }

    /**
     * Relationship to Document
     */
    public function document()
    {
        // TODO
    }

    /**
     * Relationship to ExtraRate
     */
    public function extraRate()
    {
        $this->hasOne(ExtraRate::class);
    }
}
