<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\Auth\AuthService;

class AuthController extends Controller
{

    public function __construct(protected AuthService $authService)
    {
    }

    /**
     * @OA\Post(
     *      path="/api/auth/login",
     *      summary="Inicia sesión en la aplicación",
     *      description="Este endpoint permite iniciar sesión utilizando credenciales de usuario válidas.",
     *      operationId="login",
     *      tags={"Auth"},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"email", "password"},
     *              @OA\Property(
     *                  property="email",
     *                  type="string",
     *                  format="email",
     *                  example="usuario@ejemplo.com"
     *              ),
     *              @OA\Property(
     *                  property="password",
     *                  type="string",
     *                  format="password",
     *                  example="password123"
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Inicio de sesión exitoso",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  @OA\Property(
     *                      property="id",
     *                      type="number",
     *                      example="1"
     *                  ),
     *                  @OA\Property(
     *                      property="name",
     *                      type="string",
     *                      example="Nombre"
     *                  ),
     *                  @OA\Property(
     *                      property="last_name",
     *                      type="string",
     *                      example="Apellido"
     *                  ),
     *                  @OA\Property(
     *                      property="username",
     *                      type="string",
     *                      example="Usuario"
     *                  ),
     *                  @OA\Property(
     *                      property="email",
     *                      type="string",
     *                      example="prueba@example.com"
     *                  ),
     *                  @OA\Property(
     *                      property="token",
     *                      type="object",
     *                      @OA\Property(
     *                          property="access_token",
     *                          type="string",
     *                          example="xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx"
     *                      ),
     *                      @OA\Property(
     *                          property="token_type",
     *                          type="string",
     *                          example="bearer"
     *                      ),
     *                      @OA\Property(
     *                          property="expires_in",
     *                          type="number",
     *                          example=3600
     *                      )
     *                  )
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Bienvenido Usuario."
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Credenciales inválidas",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Crendenciales incorrectas."
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Datos de entrada inválidos",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Error de validación."
     *              ),
     *              @OA\Property(
     *                  property="errors",
     *                  type="object",
     *                  @OA\Property(
     *                      property="usuario",
     *                      type="array",
     *                      @OA\Items(
     *                          type="string",
     *                          example="El usuario es obligatorio si no se proporciona un correo electrónico."
     *                      )
     *                  ),
     *                  @OA\Property(
     *                      property="email",
     *                      type="array",
     *                      @OA\Items(
     *                          type="string",
     *                          example="El correo electrónico es obligatorio si no se proporciona un usuario."
     *                      )
     *                  ),
     *                  @OA\Property(
     *                      property="password",
     *                      type="array",
     *                      @OA\Items(
     *                          type="string",
     *                          example="La contraseña es obligatoria."
     *                      )
     *                  )
     *              )
     *          ),
     *      ),
     *      @OA\Response(
     *          response="500",
     *          description="Internal Server Error",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Lo sentimos, ha ocurrido un error interno en el servidor."
     *              ),
     *          ),
     *      )
     *  )
     */

    public function login(LoginRequest $request)
    {
        $credentials = $request->only(['email', 'password']);
        return responseHelper($this->authService->login($credentials));
    }

    /**
     * @OA\Get(
     *      path="/api/auth/logout",
     *      summary="Cierra la sesión del usuario",
     *      description="Este endpoint permite cerrar la sesión del usuario actual.",
     *      operationId="logout",
     *      tags={"Auth"},
     *      security={{"jwt": {}}},
     *      @OA\Response(
     *          response=200,
     *          description="Sesión cerrada exitosamente",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Sesión cerrada."
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="No autorizado",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="No autorizado."
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response="500",
     *          description="Internal Server Error",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Lo sentimos, ha ocurrido un error interno en el servidor."
     *              ),
     *          ),
     *      )
     *  )
     */
    public function logout()
    {
        return responseHelper($this->authService->logout());
    }

    /**
     * @OA\Get(
     *      path="/api/auth/checkAuth",
     *      summary="Obtiene información del usuario actual",
     *      description="Este endpoint permite obtener información del usuario actual.",
     *      operationId="checkAuth",
     *      tags={"Auth"},
     *      security={{"jwt": {}}},
     *      @OA\Response(
     *          response=200,
     *          description="Información del usuario obtenida exitosamente",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  @OA\Property(
     *                      property="id",
     *                      type="number",
     *                      example="1"
     *                  ),
     *                  @OA\Property(
     *                      property="name",
     *                      type="string",
     *                      example="Nombre"
     *                  ),
     *                  @OA\Property(
     *                      property="last_name",
     *                      type="string",
     *                      example="Apellido"
     *                  ),
     *                  @OA\Property(
     *                      property="username",
     *                      type="string",
     *                      example="Usuario"
     *                  ),
     *                  @OA\Property(
     *                      property="email",
     *                      type="string",
     *                      example="prueba@example.com"
     *                  ),
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Información del usuario obtenida exitosamente."
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="No autorizado",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="No autorizado."
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response="500",
     *          description="Internal Server Error",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Lo sentimos, ha ocurrido un error interno en el servidor."
     *              ),
     *          ),
     *      )
     *  )
     */
    public function me()
    {
        return responseHelper($this->authService->me());
    }

    /**
     * @OA\Get(
     *      path="/api/auth/refreshToken",
     *      summary="Refresca el token de acceso",
     *      description="Este endpoint permite refrescar el token de acceso.",
     *      operationId="refresh",
     *      tags={"Auth"},
     *      security={{"jwt": {}}},
     *      @OA\Response(
     *          response=200,
     *          description="Token de acceso refrescado exitosamente",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  @OA\Property(
     *                      property="access_token",
     *                      type="string",
     *                      example="xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx"
     *                  ),
     *                  @OA\Property(
     *                      property="token_type",
     *                      type="string",
     *                      example="bearer"
     *                  ),
     *                  @OA\Property(
     *                      property="expires_in",
     *                      type="number",
     *                      example=3600
     *                  )
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Token de acceso refrescado exitosamente."
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="No autorizado",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="No autorizado."
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response="500",
     *          description="Internal Server Error",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Lo sentimos, ha ocurrido un error interno en el servidor."
     *              ),
     *          ),
     *      )
     *  )
     */
    public function refresh()
    {
        return responseHelper($this->authService->refresh());
    }
}
