<?php

namespace Dipnet;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    use SoftDeletes;

    /**
     * Disable mass assignment protection for the following attributes.
     */
    protected $fillable = [
        'filename',
        'mime_type',
        'size',
        'quantity',
        'finish',
        'format_id',
        'delivery_id',
        'article_id'
    ];

    protected $dates = ['deleted_at'];

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