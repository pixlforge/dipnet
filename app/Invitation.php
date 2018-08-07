<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    /**
     * @param $field
     * @return string
     */
    public static function generateConfirmationToken($field)
    {
        return md5(request($field) . str_random(10));
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
