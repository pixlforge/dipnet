<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Format extends Model
{
    use SoftDeletes;

    /**
     * Carbon dates.
     */
    protected $dates = [
        'deleted_at'
    ];

    /**
     * Disable mass assignment protection for the following attributes.
     */
    protected $fillable = [
        'name',
        'height',
        'width',
        'surface'
    ];

    /**
     * Document relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function document()
    {
        return $this->hasMany(Document::class);
    }
}
