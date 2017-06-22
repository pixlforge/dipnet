<?php

namespace App\Providers;

use App\Admin;
use App\User;
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
        'App\Admin' => 'App\Policies\AdminPolicy',
        'App\Format' => 'App\Policies\FormatPolicy',
        'App\Company' => 'App\Policies\CompanyPolicy',
        'App\Category' => 'App\Policies\CategoryPolicy',
        'App\Business' => 'App\Policies\BusinessPolicy',
        'App\Article' => 'App\Policies\ArticlePolicy',
        'App\Contact' => 'App\Policies\ContactPolicy',
        'App\Order' => 'App\Policies\OrderPolicy',
        'App\Delivery' => 'App\Policies\DeliveryPolicy',
        'App\Document' => 'App\Policies\DocumentPolicy',
        'App\User' => 'App\Policies\UserPolicy',
        'App\Profile' => 'App\Policies\UpdateProfilePolicy',
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
