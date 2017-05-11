<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected  = 'documents';

    /**
     * Relationship to Article
     */
    public function article()
    {
        // TODO
    }
}
