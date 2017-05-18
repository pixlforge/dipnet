<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
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
