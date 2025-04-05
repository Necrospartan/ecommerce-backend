<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        try{
            $rolesArray = explode('|', $role);
            if (!in_array(auth()->user()->role, $rolesArray)) {
                return response()->json(['message' => 'Acceso denegado.'], 403);
            }
            return $next($request);
        } catch (\Exception $e) {
            logger($e->getMessage());
            return response()->json(['message' => 'Error inesperado.'], 500);
        }
    }
}
