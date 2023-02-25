<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()
            ->json(['data' => $user, 'access_token' => $token, 'token_type' => 'Bearer',]);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|string|min:6|max:50'
        ]);



        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $userData = User::where('email', $request->email)->first();

        if (!$userData) {
            return response()->json([
                'message' => 'Email not registered.'
            ], 422);
        } else if (!Hash::check($request->password, $userData->password)) {
            return response()->json([
                'message' => ['Wrong password.']
            ], 422);
        }

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $token = $userData->createToken('auth_token')->plainTextToken;

        return response()
            ->json([
                'message' => 'Hi ' . $userData->name . ', welcome to home',
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Logout success'
        ];
    }
}
