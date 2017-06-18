<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    /**
     * Disable mass assignment protection for the following fields
     */
    protected $fillable = [
        'file_name', 'file_path', 'mime_type', 'quantity', 'rolled_folded_flat',
        'length', 'width', 'nb_orig', 'free', 'format_id', 'delivery_id', 'article_id'
    ];

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
