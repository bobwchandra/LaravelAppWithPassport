<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthFailedController extends Controller
{
    public function forbiddenError(Request $request)
    {
        $error = array();
        $error["error"] = ["message" => config("constants.Messages.IncorrectCredentials")];
        $error['code'] = 403;
        return response($error, 403);
    }
}
