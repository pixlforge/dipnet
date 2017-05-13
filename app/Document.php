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
     * Relationships to Article
     */
    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    /**
     * Relationship to Delivery
     */
    public function delivery()
    {
        return $this->belongsTo(Delivery::class);
    }

    /**
     * Relationship to Format
     */
    public function format()
    {
        return $this->belongsTo(Format::class);
    }
}
