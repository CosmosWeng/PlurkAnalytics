<?php

namespace App\Http\Middleware;

use App\Utils\Util;
use Illuminate\Support\Facades\Auth;
use Closure;

class CheckUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $auth = Auth::guard('api');
        $user = $auth->user();

        $request->attributes->add(['_user' => $user]);

        return $next($request);
    }
}
