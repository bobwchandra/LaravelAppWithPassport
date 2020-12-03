<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function getLoggedInUser(Request $request)
    {
        $userId = Auth::guard("api")->user()->id;
        $user = User::where("id", "=", $userId)->first();

        return response()->json($user);
    }

    public function getUsers(Request $request)
    {
        $users = User::all();
        return response()->json($users);
    }
}
