<?php
/**
 * Created by PhpStorm.
 * User: egordm
 * Date: 10-12-2017
 * Time: 16:08
 */

namespace Infrastructure\Middleware;


use Closure;
use Illuminate\Http\JsonResponse;

class BuildApiResponse
{
	/**
	 * - Handle an incoming request.
	 *
	 * - @param  \Illuminate\Http\Request $request
	 * - @param  \Closure $next
	 * - @param  string|null $guard
	 * - @return mixed
	 */
	public function handle($request, Closure $next, $guard = null)
	{
		$response = $next($request);
		if($response instanceof JsonResponse) {
			$original = $response->getOriginalContent();
			if(!isset($original['success'])) {
				$response->setData([
					'success' => true,
					'data' => $original
				]);
			}
		}
		return $response;
	}
}