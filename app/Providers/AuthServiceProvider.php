<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;
use Mockery\Generator\StringManipulation\Pass\Pass;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('isAdmin', function($user) {
            return $user->type === 'admin';
        });

        Gate::define('isAuthor', function($user) {
            return $user->type === 'author';
        });

        Gate::define('isUser', function($user) {
            return $user->type === 'user';
        });

        Gate::define('isAdminOrAuthor', function($user) {
            return ($user->type === 'admin' || $user->type === 'author');
        });

        Gate::define('isAuthorOrUser', function($user) {
            return ($user->type === 'author' || $user->type === 'user');
        });

        Passport::routes();
    }
}
