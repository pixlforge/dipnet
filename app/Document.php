<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Document extends Model implements HasMedia
{
    use HasMediaTrait;

    /**
     * @return bool
     */
    public function belongsToUser()
    {
        return $this->delivery->order->user_id === auth()->id();
    }

    /**
     * @return bool
     */
    public function belongsToUsersCompany()
    {
        return $this->delivery->order->business->company->id === auth()->user()->company_id;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function articles()
    {
        return $this->belongsToMany(Article::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function delivery()
    {
        return $this->belongsTo(Delivery::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function format()
    {
        return $this->belongsTo(Format::class);
    }
}
