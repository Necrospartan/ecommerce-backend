<?php

namespace App\Http\Controllers;

    /**
     * @OA\Info(
     *      version="1.0.0",
     *      title="Ecommerce-BackEnd-Documentation",
     *      description="Docuementation for Ecommerce-BackEnd",
     *      @OA\Contact(
     *          email="admin@admin.com"
     *      ),
     *      @OA\License(
     *          name="Apache 2.0",
     *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
     *      )
     * )
     *
     * @OA\Server(
     *      url=L5_SWAGGER_CONST_HOST,
     *      description="Develop Server"
     * )
     *
     * @OA\SecurityScheme(
     *     securityScheme="sanctum",
     *     type="http",
     *     scheme="bearer",
     *     bearerFormat="sanctum"
     * )
     */
abstract class Controller
{
    //
}
