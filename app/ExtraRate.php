<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExtraRate extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected  = 'extra_rates';

    /**
     * Relationship to Article
     */
    public function article()
    {
        return $this->hasMany(Article::class);
    }
}
