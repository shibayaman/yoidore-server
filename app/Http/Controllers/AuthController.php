<?php

namespace App\Http\Controllers;

use Auth;
use App;
use Cookie;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('login');
    }

    public function login()
    {
        $credentials = request(['username', 'password']);
        if (! $token = Auth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithCookie($token);
    }

    public function user(Request $request)
    {
        return $request->user();
    }

    //logout currently uses local cache to manage blacklist
    //might going to move blacklist to db
    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithCookie(auth()->refresh());
    }

    protected function respondWithCookie($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ])->cookie(
            'token',
            $token,
            Auth::factory()->getTTL() * 60,
            null,
            null,
            App::environment('production'),
            true
        );
    }
}
