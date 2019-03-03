<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;
use App\Exceptions\UserErrorException;

class CheckUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->get('_user')) {
            return $next($request);
        } else {
            throw new UserErrorException('TOKEN_IS_EXPIRED');
        }
    }
}
