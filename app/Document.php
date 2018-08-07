<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Document extends Model implements HasMedia
{
    use HasMediaTrait;

    /**
     * Document belongs to the user.
     *
     * @return bool
     */
    public function belongsToUser()
    {
        return $this->delivery->order->user_id === auth()->id();
    }

    /**
     * Document belongs to the user's company.
     *
     * @return bool
     */
    public function belongsToUsersCompany()
    {
        return $this->delivery->order->business->company->id === auth()->user()->company_id;
    }

    /**
     * A document belongs to an article.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    /**
     * A document belongs to many articles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function articles()
    {
        return $this->belongsToMany(Article::class);
    }

    /**
     * A document belongs to a delivery.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function delivery()
    {
        return $this->belongsTo(Delivery::class);
    }
}
