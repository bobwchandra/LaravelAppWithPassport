<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use League\OAuth2\Server\Exception\OAuthServerException;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if ($request->expectsJson()) {   
            $error = Helper::errorStatus(401);
            $error["error"]['message']= 'Username dan password salah';
            error_log('invalid cred');
            return response()->json($error, 401); 
        }

        error_log('forbid');

        return response()->json("Forbidden", 403);
    }
}
