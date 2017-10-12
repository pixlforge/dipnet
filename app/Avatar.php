<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Avatar extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable
     */
    protected $fillable = ['path'];

    /**
     * Get the path.
     *
     * @return string
     */
    public function path()
    {
        return config('avatar.path.relative') . $this->path;
    }
}
