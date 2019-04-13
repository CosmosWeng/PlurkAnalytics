<?php

namespace App\Utils;

class CustomTokenUtil
{
    //
    public function getAuthApiToken($guard, $day = 30, $str_n = 10)
    {
        $time  = time();
        $token = [
            'random' => str_random($str_n),
            'guard'  => $guard,
            'time'   => $time + (3600 * 24 * $day)
        ];
        $token = implode('@@', $token);
        $token = encrypt($token);

        return $token;
    }
}
