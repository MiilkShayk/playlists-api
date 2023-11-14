<?php


namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{
    public function attemptLogin($credentials)
    {
        if (Auth::attempt($credentials)) {
            return JWTAuth::attempt($credentials);
        }
        return null;
    }
    public function logout()
    {
        Auth::logout();
    }
    public function refresh()
    {
        return JWTAuth::refresh();
    }
}
