<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;

class CheckToken
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
        if (is_null($request->user())) {
          return new JsonResponse( ['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
