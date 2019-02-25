<?php

namespace App\Auth;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider as Provider;
use App\Models\User;

class UserProvider implements Provider
{
    public function retrieveById($identifier)
    {
        return app(User::class)::find($identifier);
    }

    public function retrieveByToken($identifier, $token)
    {
        return null;
    }

    public function updateRememberToken(Authenticatable $user, $token)
    {
        return true;
    }

    public function retrieveByCredentials(array $credentials)
    {
        if (! isset($credentials['api_token'])) {
            return null;
        }

        return app(User::class)::getUserByToken($credentials['api_token']);
    }

    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        if (! isset($credentials['api_token'])) {
            return false;
        }

        return true;
    }
}
