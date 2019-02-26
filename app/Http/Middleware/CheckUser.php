<?php

namespace App\Http\Middleware;

use App\Utils\Util;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Closure;

class CheckUser
{
    public function __construct(Request $request)
    {
    }

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
        $response = $next($request);

        return $response;
    }
}
