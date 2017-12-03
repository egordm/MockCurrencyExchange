<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;

class MultiGuardAuthentication
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure $next
	 * @return mixed
	 * @throws AuthenticationException
	 */
    public function handle($request, Closure $next)
    {
	    if (\Auth::guard('api')->check()) {
		    $user = \Auth::guard('api')->user();
	    }

	    if (\Auth::guard('web')->check()) {
		    $user = \Auth::guard('web')->user();
	    }

	    if(! isset($user)) {
		    throw new AuthenticationException;
	    }

	    \Auth::login($user);

	    return $next($request);
    }
}
