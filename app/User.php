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

    public function scopeOnlyUsers(Builder $builder)
    {
        return $builder->where('role', 'utilisateur');
    }

    public function confirm()
    {
        $this->email_confirmed = true;
        $this->confirmation_token = null;
        $this->save();
    }

    public static function generateConfirmationToken($field)
    {
        return md5(request($field) . str_random(10));
    }

    public function hasConfirmationToken()
    {
        return $this->confirmation_token;
    }

    public function isConfirmed()
    {
        return $this->email_confirmed;
    }

    public function hasConfirmedContact()
    {
        return $this->contact_confirmed;
    }

    public function hasConfirmedCompany()
    {
        return $this->company_confirmed;
    }

    public function associateWithCompany($id)
    {
        $this->company_id = $id;
        $this->save();
    }

    public function associateContactWithCompany($id)
    {
        $contact = Contact::where('user_id', auth()->id())->first();
        $contact->company_id = $id;
        $contact->save();
    }

    public function wasInvited()
    {
        return $this->was_invited;
    }

    public function isAdmin()
    {
        return $this->role === 'administrateur';
    }

    public function isNotAdmin()
    {
        return !$this->isAdmin();
    }

    public function isPartOfACompany()
    {
        return !$this->is_solo;
    }

    public function isSolo()
    {
        return $this->is_solo == true;
    }

    public function isNotSolo()
    {
        return $this->is_solo == false;
    }

    public function isNotAssociatedWithAnyCompany()
    {
        return $this->company_id === null;
    }

    public function companyHasDefaultBusiness()
    {
        return $this->company->business_id !== null;
    }

    public function companyHasNoDefaultBusiness()
    {
        return $this->company->business_id === null;
    }

    public function confirmContact()
    {
        $this->contact_confirmed = true;
        $this->save();
    }

    public function confirmCompany()
    {
        $this->company_confirmed = true;
        $this->save();
    }

    public function hasCompany()
    {
        return $this->company_id;
    }

    public function getOrdersCountAttribute()
    {
        return $this->orders()->count();
    }

    public function getBusinessesCountAttribute()
    {
        return $this->businesses()->count();
    }

    public function company()
    {
        return $this->belongsTo(Company::class)->withDefault(['name' => 'Particulier']);
    }

    public function deliveryComment()
    {
        return $this->hasMany(DeliveryComment::class);
    }

    public function order()
    {
        return $this->hasMany(Order::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function manages()
    {
        return $this->hasMany(Order::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function deliveries()
    {
        return $this->hasManyThrough('App\Delivery', 'App\Contact');
    }

    public function businesses()
    {
        return $this->hasManyThrough('App\Business', 'App\Contact');
    }

    public function avatar()
    {
        return $this->belongsTo(Avatar::class);
    }

    public function avatarPath()
    {
        if (!$this->avatar_id) {
            return null;
        }

        return $this->avatar->path();
    }

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

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}
