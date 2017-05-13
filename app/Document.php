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
        $this->belongsTo(Article::class);
    }

    /**
     * Relationship to Delivery
     */
    public function delivery()
    {
        $this->belongsTo(Delivery::class);
    }

    /**
     * Relationship to Format
     */
    public function format()
    {
        $this->belongsTo(Format::class);
    }
}
