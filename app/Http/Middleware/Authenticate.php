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
            $error = array();
            $error["error"] = ["message" => config("constants.Messages.IncorrectCredentials")];
            $error['code'] = 403;
            return response($error, 403);
        }

        return route('forbiddenError');
    }
}
