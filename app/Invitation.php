<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    public static function generateConfirmationToken($field)
    {
        return md5(request($field) . str_random(10));
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
