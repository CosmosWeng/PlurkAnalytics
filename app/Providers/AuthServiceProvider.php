<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use App\Auth\UserProvider;
use App\Auth\TokenGuard;

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

        Auth::provider('token', function ($app, $config) {
            return app(UserProvider::class);
        });

        Auth::extend('token', function ($app, $name, array $config) {
            if ($name === 'api') {
                return app()->make(TokenGuard::class, [
                    'provider' => Auth::createUserProvider($config['provider']),
                    'request'  => $app->request,
                ]);
            }
            throw new \Exception('This guard only serves "auth:api".');
        });

        //
    }
}
