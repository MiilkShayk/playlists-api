<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $token = $this->authService->attemptLogin($credentials);

        if ($token) {
            return response()->json(['token' => $token]);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }
    public function logout()
    {
        $this->authService->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }
    public function refresh()
    {
        $token = $this->authService->refresh();
        return response()->json(['token' => $token]);
    }
    public function getUser()
    {
        // Recupere o usuário autenticado
        $user = auth()->user();

        // Verifique se o usuário foi encontrado
        if ($user) {
            return response()->json(['user' => $user]);
        } else {
            return response()->json(['error' => 'User not found'], 404);
        }
    }
    public function loginPage()
    {
        return response()->json(['error' => 'Efetue o Login'],500);
    }
}
