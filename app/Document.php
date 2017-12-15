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
     * Check if the document's delivery's order belongs to the current user.
     *
     * @return bool
     */
    public function belongsToUser()
    {
        return $this->delivery->order->user_id === auth()->id();
    }

    /**
     * Checks if the document belongs to the user's company.
     *
     * @return bool
     */
    public function belongsToUsersCompany()
    {
        return $this->delivery->order->business->company->id === auth()->user()->company_id;
    }

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
     * Articles relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function articles()
    {
        return $this->belongsToMany(Article::class);
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