<?php

namespace App\Auth;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use Illuminate\Support\Str;

class UserProvider extends EloquentUserProvider
{
    public function __construct(HasherContract $hasher, $model, $pwField = 'password', $apiField = 'api_token')
    {
        parent::__construct($hasher, $model);
        $this->passwordField = $pwField;
        $this->apiField      = $apiField;
    }

    public function retrieveById($identifier)
    {
    }

    public function retrieveByToken($identifier, $token)
    {
    }

    public function updateRememberToken(Authenticatable $user, $token)
    {
    }

    public function retrieveByCredentials(array $credentials)
    {
        // 用$credentials裡面的用戶名密碼去獲取用戶信息，然後返回Illuminate\Contracts\Auth\Authenticatable對象

        if (empty($credentials) || false === (
            array_key_exists($this->passwordField, $credentials) ||
                array_key_exists($this->apiField, $credentials)
            )
        ) {
            return null;
        }

        $model = $this->createModel();
        $query = $model->newQuery();

        if (isset($credentials['account'])) {
            if (method_exists($model, 'getAccount')) {
                $key               = $model->getAccount();
                $credentials[$key] = $credentials['account'];
                unset($credentials['account']);
            }
        }

        foreach ($credentials as $key => $value) {
            // 排除包含 密碼字元 的欄位
            if (! Str::contains($key, $this->passwordField)) {
                $query->where($key, $value);
            }
        }

        return $query->first();
    }

    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        // 用 $credentials 裡面的用戶名密碼校驗用戶，返回true或false

        $plain = $credentials[$this->passwordField];

        return $this->hasher->check($plain, $user->getAuthPassword());
    }
}
