<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (is_null($request->headers->get("authorization")) || $request->headers->get("authorization") == "") {
          return json_encode(["message" => "No Authorization header"]);
        }  
        return;
    }
}
