<?php

namespace Dipnet;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    protected $fillable = [
        'email',
        'token',
        'company_id',
        'created_by'
    ];

    /**
     * Generate a confirmation token.
     *
     * @param $field
     * @return string
     */
    public static function generateConfirmationToken($field)
    {
        return md5(request($field) . str_random(10));
    }

    /**
     * Company relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
