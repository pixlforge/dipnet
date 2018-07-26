<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

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
