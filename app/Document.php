<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Document extends Model implements HasMedia
{
    use HasMediaTrait;

    public function belongsToUser()
    {
        return $this->delivery->order->user_id === auth()->id();
    }

    public function belongsToUsersCompany()
    {
        return $this->delivery->order->business->company->id === auth()->user()->company_id;
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function articles()
    {
        return $this->belongsToMany(Article::class);
    }

    public function delivery()
    {
        return $this->belongsTo(Delivery::class);
    }

    public function format()
    {
        return $this->belongsTo(Format::class);
    }
}
