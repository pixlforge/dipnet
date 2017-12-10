<?php

namespace Dipnet;

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
        'email_confirmed',
        'confirmation_token',
        'contact_confirmed',
        'company_confirmed',
        'avatar_id'
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
        'email_confirmed' => 'boolean',
        'contact_confirmed' => 'boolean',
        'company_confirmed' => 'boolean'
    ];

    /**
     * Update and confirm the user account.
     */
    public function confirm()
    {
        $this->email_confirmed = true;
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
        return $this->email_confirmed;
    }

    /**
     * Checks wether the user has entered at least one contact.
     *
     * @return int|mixed
     */
    public function hasConfirmedContact()
    {
        return $this->contact_confirmed;
    }

    /**
     * Checks wether the user has confirmed his associated company status.
     *
     * @return int|mixed
     */
    public function hasConfirmedCompany()
    {
        return $this->company_confirmed;
    }

    /**
     * Associate the user with his newly created company.
     *
     * @param $id
     */
    public function associateWithCompany($id)
    {
        $this->company_id = $id;
        $this->save();
    }

    /**
     * Associate the user's Contact with Company model.
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

    /**
     * Confirm that the user has entered his contact infos.
     */
    public function confirmContact()
    {
        $this->contact_confirmed = true;
        $this->save();
    }

    /**
     * Confirm that the user has entered his company infos.
     */
    public function confirmCompany()
    {
        $this->company_confirmed = true;
        $this->save();
    }

    /**
     * Check wether the authenticated user has an associated company.
     *
     * @return int|mixed|null
     */
    public function hasCompany()
    {
        return $this->company_id;
    }

    /**
     * OrdersCount Attribute
     *
     * @return int
     */
    public function getOrdersCountAttribute()
    {
        return $this->orders()->count();
    }

    /**
     * BusinessCount Attribute
     * @return int
     */
    public function getBusinessesCountAttribute()
    {
        return $this->businesses()->count();
    }

    /**
     * Company relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class)->withDefault(['name' => 'Particulier']);
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
     * Orders relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Contact relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    /**
     * Deliveries through Contact relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function deliveries()
    {
        return $this->hasManyThrough('Dipnet\Delivery', 'Dipnet\Contact');
    }

    /**
     * Businesses through Contact relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function businesses()
    {
        return $this->hasManyThrough('Dipnet\Business', 'Dipnet\Contact');
    }

    /**
     * Avatar relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function avatar()
    {
        return $this->belongsTo(Avatar::class);
    }

    /**
     * Get the path of the avatar.
     *
     * @return null
     */
    public function avatarPath()
    {
        if (! $this->avatar_id) {
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
}