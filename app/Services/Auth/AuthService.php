<?php

namespace App\Services\Auth;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthService
{
    public function login(array $credentials) : array
    {
        try {
            if (!Auth::attempt($credentials)) {
                return [
                    'message' => 'Credenciales incorrectas.',
                    'status' => JsonResponse::HTTP_UNAUTHORIZED,
                ];
            }

            $user = auth()->user();
            $token = $user->createToken('auth_token')->plainTextToken;
            if (isset($token['status']) && $token['status'] == JsonResponse::HTTP_INTERNAL_SERVER_ERROR) {
                return $token;
            }
            $user['token'] = $token;
            return [
                'data' => $user,
                'message' => 'Bienvenido ' . $user['name'] . ' ' . $user['last_name'] . '.'
            ];
        } catch(\Exception $e) {
            Log::error($e->getMessage());
            return [
                'message' => 'Error al iniciar sesión.',
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            ];
        }
    }
    public function logout() : array
    {
        try {
            $user = auth()->user();
            // $user->currentAccessToken()->delete();
            $user->tokens()->delete();
            return [
                'message' => 'Sesión cerrada.'
            ];
        } catch(\Exception $e) {
            Log::error($e->getMessage());
            return [
                'message' => 'Error al cerrar sesión.',
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            ];
        }
    }
    public function me() : array
    {
        try {
            return [
                'data' => auth()->user()->getPublicProfile(),
                'message' => 'Información de usuario.'
            ];
        } catch(\Exception $e) {
            Log::error($e->getMessage());
            return [
                'message' => 'Error al obtener información de usuario.',
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            ];
        }
    }
    public function refresh() : array
    {
        try {
            $user = auth()->user();
            // $user->currentAccessToken()->delete();
            $user->tokens()->delete();

            // Create a new token.
            $newToken = $user->createToken('RefreshToken')->plainTextToken;
            return [
                'message' => 'Token de acceso refrescado exitosamente.',
                'data' => [
                    'access_token' => $newToken,
                    'token_type' => 'bearer'
                ]
            ];
        } catch(\Exception $e) {
            Log::error($e->getMessage());
            return [
                'message' => 'Error al actualizar token.',
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            ];
        }
    }
}
