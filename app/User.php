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

    protected $dates = ['deleted_at'];

    protected $hidden = ['remember_token'];

    protected $casts = [
        'email_confirmed' => 'boolean',
        'contact_confirmed' => 'boolean',
        'company_confirmed' => 'boolean',
        'is_solo' => 'boolean',
    ];

    /**
     * @param Builder $builder
     * @return Builder
     */
    public function scopeOnlyUsers(Builder $builder)
    {
        return $builder->where('role', 'utilisateur');
    }

    /**
     *
     */
    public function confirm()
    {
        $this->email_confirmed = true;
        $this->confirmation_token = null;
        $this->save();
    }

    /**
     * @param $field
     * @return string
     */
    public static function generateConfirmationToken($field)
    {
        return md5(request($field) . str_random(10));
    }

    /**
     * @return mixed
     */
    public function hasConfirmationToken()
    {
        return $this->confirmation_token;
    }

    /**
     * @return mixed
     */
    public function isConfirmed()
    {
        return $this->email_confirmed;
    }

    /**
     * @return mixed
     */
    public function hasConfirmedContact()
    {
        return $this->contact_confirmed;
    }

    /**
     * @return mixed
     */
    public function hasConfirmedCompany()
    {
        return $this->company_confirmed;
    }

    /**
     * @param $id
     */
    public function associateWithCompany($id)
    {
        $this->company_id = $id;
        $this->save();
    }

    /**
     * @param $id
     */
    public function associateContactWithCompany($id)
    {
        $contact = Contact::where('user_id', auth()->id())->first();
        $contact->company_id = $id;
        $contact->save();
    }

    /**
     * @return mixed
     */
    public function wasInvited()
    {
        return $this->was_invited;
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role === 'administrateur';
    }

    /**
     * @return bool
     */
    public function isNotAdmin()
    {
        return !$this->isAdmin();
    }

    /**
     * @return bool
     */
    public function isPartOfACompany()
    {
        return !$this->is_solo;
    }

    /**
     * @return bool
     */
    public function isSolo()
    {
        return $this->is_solo == true;
    }

    /**
     * @return bool
     */
    public function isNotSolo()
    {
        return $this->is_solo == false;
    }

    /**
     * @return bool
     */
    public function isNotAssociatedWithAnyCompany()
    {
        return $this->company_id === null;
    }

    /**
     * @return bool
     */
    public function companyHasDefaultBusiness()
    {
        return $this->company->business_id !== null;
    }

    /**
     * @return bool
     */
    public function companyHasNoDefaultBusiness()
    {
        return $this->company->business_id === null;
    }

    /**
     *
     */
    public function confirmContact()
    {
        $this->contact_confirmed = true;
        $this->save();
    }

    /**
     *
     */
    public function confirmCompany()
    {
        $this->company_confirmed = true;
        $this->save();
    }

    /**
     * @return mixed
     */
    public function hasCompany()
    {
        return $this->company_id;
    }

    /**
     * @return int
     */
    public function getOrdersCountAttribute()
    {
        return $this->orders()->count();
    }

    /**
     * @return int
     */
    public function getBusinessesCountAttribute()
    {
        return $this->businesses()->count();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class)->withDefault(['name' => 'Particulier']);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function deliveryComment()
    {
        return $this->hasMany(DeliveryComment::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function order()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function manages()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function deliveries()
    {
        return $this->hasManyThrough('App\Delivery', 'App\Contact');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function businesses()
    {
        return $this->hasManyThrough('App\Business', 'App\Contact');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function avatar()
    {
        return $this->belongsTo(Avatar::class);
    }

    /**
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
     * @param string $token
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}
