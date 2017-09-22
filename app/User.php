<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    /**
     * Carbon dates
     */
    protected $dates = [
        'deleted_at'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'role',
        'contact_id',
        'company_id',
        'confirmed',
        'confirmation_token',
        'contact_confirmed',
        'company_confirmed',
        'was_invited'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * The attributes that are cast into specific primitives.
     */
    protected $casts = [
        'confirmed' => 'boolean'
    ];

    /**
     * Business relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function business()
    {
        return $this->hasMany(Business::class);
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

    /**
     * DeliveryComment relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function deliveryComment()
    {
        return $this->hasMany(DeliveryComment::class);
    }

    /**
     * Order relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function order()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Contact relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    /**
     * Update and confirm the user account.
     */
    public function confirm()
    {
        $this->confirmed = true;
        $this->confirmation_token = null;
        $this->save();
    }

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
     * Checks wether the user has an unused confirmation token.
     *
     * @return mixed|null|string
     */
    public function hasConfirmationToken()
    {
        return $this->confirmation_token;
    }

    /**
     * Check wether the user has confirmed his account registration.
     *
     * @return mixed
     */
    public function isConfirmed()
    {
        return $this->confirmed;
    }

    /**
     * Check wether the user was invited.
     *
     * @return int|mixed
     */
    public function wasInvited()
    {
        return $this->was_invited;
    }

    /**
     * Check wether the user is an admin.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role === 'administrateur';
    }
}
