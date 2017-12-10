<?php

namespace Dipnet\Providers;

use Dipnet\Admin;
use Dipnet\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'Dipnet\Admin' => 'Dipnet\Policies\AdminPolicy',
        'Dipnet\Format' => 'Dipnet\Policies\FormatPolicy',
        'Dipnet\Company' => 'Dipnet\Policies\CompanyPolicy',
        'Dipnet\Business' => 'Dipnet\Policies\BusinessPolicy',
        'Dipnet\Article' => 'Dipnet\Policies\ArticlePolicy',
        'Dipnet\Contact' => 'Dipnet\Policies\ContactPolicy',
        'Dipnet\Order' => 'Dipnet\Policies\OrderPolicy',
        'Dipnet\Delivery' => 'Dipnet\Policies\DeliveryPolicy',
        'Dipnet\Document' => 'Dipnet\Policies\DocumentPolicy',
        'Dipnet\User' => 'Dipnet\Policies\UserPolicy',
        'Dipnet\Profile' => 'Dipnet\Policies\UpdateProfilePolicy',
        'Dipnet\Invitation' => 'Dipnet\Policies\InvitationPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
