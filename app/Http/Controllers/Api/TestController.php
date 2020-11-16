<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TestController extends Controller
{
    public function testGet(Request $request) {
        return response()->json("test get api");
    }

    public function testGetWithAuth(Request $request) {
        $userId = Auth::guard("api")->user()->id;
        $user = User::where("id", "=", $userId)->first();

        return response()->json($user);
    }
}