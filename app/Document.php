<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    /**
     * Disable mass assignment protection for the following attributes.
     */
    protected $fillable = [
        'file_name',
        'file_path',
        'mime_type',
        'quantity',
        'rolled_folded_flat',
        'length',
        'width',
        'nb_orig',
        'free',
        'format_id',
        'delivery_id',
        'article_id'
    ];

    /**
     * Article relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    /**
     * Delivery relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function delivery()
    {
        return $this->belongsTo(Delivery::class);
    }

    /**
     * Format relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function format()
    {
        return $this->belongsTo(Format::class);
    }
}