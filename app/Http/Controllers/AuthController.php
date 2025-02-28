<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Activity;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'phone' => 'nullable|string|max:20',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone ?? null,
        ]);

        Activity::create([
            'user_id' => $user->id,
            'action' => 'register',
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json(['user' => $user, 'token' => $token], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = Auth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        Activity::create([
            'user_id' => Auth::id(),
            'action' => 'login',
        ]);

        return response()->json(['token' => $token]);
    }

    public function me()
    {
        return response()->json(Auth::user());
    }

    public function logout()
    {
        Activity::create([
            'user_id' => Auth::id(),
            'action' => 'logout',
        ]);

        Auth::logout();
        return response()->json(['message' => 'Successfully logged out']);
    }
}
