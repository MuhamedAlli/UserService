<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
class AuthController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(LoginUserRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $user = $this->authService->login($validatedData);

            $token = $user->createToken('auth_token')->accessToken;

            
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error',
                'error' => $e->getMessage()
            ], 400);
        }
        return response()->json([
            'message' => "success",
            'data' => $user,
            'token' => $token
        ]);
            
    }

    public function register(RegisterUserRequest $request)
    {
        dd($request);
        try {
            $validatedData = $request->validated();
            $response = $this->authService->register($validatedData);
        } catch (Exception $e) {
            return response()->json([
                'status' => $e->getCode(),
                'message' => 'Error',
                'error' => $e->getMessage()
            ], 400);
        }

        return response()->json([
            'message' => "success",
            'data' => $response ?? null
        ], 200);
    }
    public function validateToken(Request $request)
    {
        try {
            return response()->json(["valid" => true]);
        } catch (\Exception $e) {
            Log::error("fajr ".$e);
            return response()->json(["valid" => false]);
        }
    }
}
