<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserRoleController extends Controller
{
    public function getUserRoles(Request $request)
    {
        $userRoles = UserRole::orderBy('id', 'ASC')->get();

        return response()->json($userRoles);
    }
}
