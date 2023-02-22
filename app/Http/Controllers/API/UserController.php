<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    //
    public function getAllUser(Request $request)
    {
        $data = User::where('role_id', '!=', 1)->get();
        return response()->json([
            'message' => 'Get all users success',
            'data' => $data
        ], 200);
    }
}
