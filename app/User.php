<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Builder;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $dates = [
        'deleted_at',
    ];

    protected $hidden = [
        'remember_token',
    ];

    protected $casts = [
        'email_confirmed' => 'boolean',
        'contact_confirmed' => 'boolean',
        'company_confirmed' => 'boolean',
        'is_solo' => 'boolean',
    ];

    /**
     * Fetch only the users whose role is user.
     *
     * @param Builder $builder
     * @return Builder
     */
    public function scopeOnlyUsers(Builder $builder)
    {
        return $builder->where('role', 'utilisateur');
    }

    /**
     * Confirm a user account.
     */
    public function confirm()
    {
        $this->email_confirmed = true;
        $this->confirmation_token = null;
        $this->save();
    }

    /**
     * Generate a random confirmation token.
     *
     * @param $field
     * @return string
     */
    public static function generateConfirmationToken($field)
    {
        return md5(request($field) . str_random(10));
    }

    /**
     * Checks whether a confirmation token exists.
     *
     * @return mixed
     */
    public function hasConfirmationToken()
    {
        return $this->confirmation_token;
    }

    /**
     * Checks whether the user confirmed his account.
     *
     * @return mixed
     */
    public function isConfirmed()
    {
        return $this->email_confirmed;
    }

    /**
     * Checks whether the user has confirmed his base mandatory contact.
     *
     * @return mixed
     */
    public function hasConfirmedContact()
    {
        return $this->contact_confirmed;
    }

    /**
     * Checks whether a user associated with a company has confirmed his company.
     *
     * @return mixed
     */
    public function hasConfirmedCompany()
    {
        return $this->company_confirmed;
    }

    /**
     * Associate a user with an existing company.
     *
     * @param $id
     */
    public function associateWithCompany($id)
    {
        $this->company_id = $id;
        $this->save();
    }

    /**
     * Associate a user's mandatory contact with his company.
     *
     * @param $id
     */
    public function associateContactWithCompany($id)
    {
        $contact = Contact::where('user_id', auth()->id())->first();
        $contact->company_id = $id;
        $contact->save();
    }

    /**
     * Checks whether the user was invited.
     *
     * @return mixed
     */
    public function wasInvited()
    {
        return $this->was_invited;
    }

    /**
     * Checks whether the user's role is admin.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role === 'administrateur';
    }

    /**
     * Checks whether the user is not an admin.
     *
     * @return bool
     */
    public function isNotAdmin()
    {
        return !$this->isAdmin();
    }

    /**
     * Checks whether the user is part of a company.
     *
     * @return bool
     */
    public function isPartOfACompany()
    {
        return !$this->is_solo;
    }

    /**
     * Checks whether the user is solo.
     *
     * @return bool
     */
    public function isSolo()
    {
        return $this->is_solo == true;
    }

    /**
     * Checks whether the user is not solo.
     *
     * @return bool
     */
    public function isNotSolo()
    {
        return $this->is_solo == false;
    }

    /**
     * Checks whether the user is not associated with a company.
     *
     * @return bool
     */
    public function isNotAssociatedWithAnyCompany()
    {
        return $this->company_id === null;
    }

    /**
     * Confirm a user's contact.
     */
    public function confirmContact()
    {
        $this->contact_confirmed = true;
        $this->save();
    }

    /**
     * Confirm a user's company.
     */
    public function confirmCompany()
    {
        $this->company_confirmed = true;
        $this->save();
    }

    /**
     * Get the count of associated orders.
     *
     * @return int
     */
    public function getOrdersCountAttribute()
    {
        return $this->orders()->count();
    }

    /**
     * Get the count of associated businesses.
     *
     * @return int
     */
    public function getBusinessesCountAttribute()
    {
        return $this->businesses()->count();
    }

    /**
     * A user belongs to a company.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class)->withDefault(['name' => 'Particulier']);
    }

    /**
     * A user may have many orders.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * An admin may manage many orders.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function manages()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * A user may have many comments.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * A user may have many contacts.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    /**
     * A user may have many deliveries through his contacts.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function deliveries()
    {
        return $this->hasManyThrough(Delivery::class, Contact::class);
    }

    /**
     * A user may have many businesses through his contacts.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function businesses()
    {
        return $this->hasManyThrough(Business::class, Contact::class);
    }

    /**
     * A user belongs to an avatar.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function avatar()
    {
        return $this->belongsTo(Avatar::class);
    }

    /**
     * Get the user's avatar path.
     *
     * @return null
     */
    public function avatarPath()
    {
        if (!$this->avatar_id) {
            return null;
        }

        return $this->avatar->path();
    }

    /**
     * Get a random avatar for the user.
     *
     * @return string
     */
    public function randomAvatar()
    {
        $avatars = collect([
            'avatar-boy',
            'avatar-fat-boy',
            'avatar-happy-woman',
            'avatar-hipster-smiling',
            'avatar-perplexed-man',
            'avatar-smiling-girl'
        ]);

        $randomAvatar = $avatars->random() . '.png';

        session(['randomAvatar' => $randomAvatar]);

        return $randomAvatar;
    }

    /**
     * Send a user a password reset link.
     *
     * @param string $token
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}
