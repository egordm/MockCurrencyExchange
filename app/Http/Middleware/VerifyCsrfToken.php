<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/api/login'
    ];

	public function handle($request, Closure $next)
	{
		if(!empty($request->header('Authorization'))) return $next($request);
		return parent::handle($request, $next);
	}


}
