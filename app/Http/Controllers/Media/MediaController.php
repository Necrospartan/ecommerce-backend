<?php

namespace App\Http\Controllers\Media;

use App\Http\Controllers\Controller;
use App\Http\Requests\Media\MediaStoreRequest;
use App\Http\Requests\Media\MediaUpdateRequest;
use App\Services\Media\MediaService;

class MediaController extends Controller
{
    protected $mediaService;

    public function __construct(MediaService $mediaService)
    {
        $this->mediaService = $mediaService;
    }

    /**
     * @OA\Get(
     *      path="/api/media/getMedia",
     *      summary="Obtener todos los Medios",
     *      description="Este EndPoint regresa todos los Medios.",
     *      operationId="allMedia",
     *      tags={"Media"},
     *      security={{"sanctum": {}}},
     *      @OA\Response(
     *          response=200,
     *          description="Todos los Medios",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(
     *                      type="object",
     *                      @OA\Property(
     *                          property="id",
     *                          type="integer",
     *                          example="1"
     *                      ),
     *                      @OA\Property(
     *                          property="name",
     *                          type="string",
     *                          example="prueba"
     *                      ),
     *                      @OA\Property(
     *                          property="location",
     *                          type="string",
     *                          example="México"
     *                      ),
     *                      @OA\Property(
     *                          property="type",
     *                          type="string",
     *                          example="anuncio"
     *                      ),
     *                      @OA\Property(
     *                          property="image",
     *                          type="string",
     *                          example="http://localhost:8017/api/media/getImageMedia/1"
     *                      ),
     *                      @OA\Property(
     *                          property="price_per_day",
     *                          type="number",
     *                          format="float",
     *                          example="19.99"
     *                      ),
     *                      @OA\Property(
     *                          property="created_at",
     *                          type="string",
     *                          example="2025-12-12"
     *                      ),
     *                      @OA\Property(
     *                          property="updated_at",
     *                          type="string",
     *                          example="2025-12-12"
     *                      ),
     *                      @OA\Property(
     *                          property="deleted_at",
     *                          type="string",
     *                          example="null"
     *                      ),
     *                  ),
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Medios obtenidos correctamente."
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean",
     *                  example="false"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="No autorizado"
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Server Error",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean",
     *                  example="false"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Error del servidor"
     *              )
     *          )
     *      )
     * )
     */
    public function index()
    {
        return responseHelper($this->mediaService->getAllMedia());
    }

    /**
     * @OA\Get(
     *      path="/api/media/getMedia/{id}",
     *      summary="Obtener un Medio",
     *      description="Este EndPoint regresa un Medio por su ID.",
     *      operationId="getmedia",
     *      tags={"Media"},
     *      security={{"sanctum": {}}},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID del Medio",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Medio obtenido correctamente",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  @OA\Property(
     *                      property="id",
     *                      type="integer",
     *                      example="1"
     *                  ),
     *                  @OA\Property(
     *                      property="name",
     *                      type="string",
     *                      example="prueba"
     *                  ),
     *                  @OA\Property(
     *                      property="location",
     *                      type="string",
     *                      example="México"
     *                  ),
     *                  @OA\Property(
     *                      property="type",
     *                      type="string",
     *                      example="anuncio"
     *                  ),
     *                  @OA\Property(
     *                      property="image",
     *                      type="string",
     *                      example="http://localhost:8017/api/media/getImageMedia/1"
     *                  ),
     *                  @OA\Property(
     *                      property="price_per_day",
     *                      type="number",
     *                      format="float",
     *                      example="19.99"
     *
     *                  ),
     *                  @OA\Property(
     *                      property="created_at",
     *                      type="string",
     *                      example="2025-12-12"
     *                  ),
     *                  @OA\Property(
     *                      property="updated_at",
     *                      type="string",
     *                      example="2025-12-12"
     *                  ),
     *                  @OA\Property(
     *                      property="deleted_at",
     *                      type="string",
     *                      example="null"
     *                  ),
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Medio obtenido correctamente."
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean",
     *                  example="false"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="No autorizado"
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Medio no encontrado",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean",
     *                  example="false"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Medio no encontrado"
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Server Error",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean",
     *                  example="false"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Error del servidor"
     *              )
     *          )
     *      )
     * )
     */
    public function show($id)
    {
        return responseHelper($this->mediaService->getMediaById($id));
    }

    /**
     * @OA\Post(
     *      path="/api/media/addMedia",
     *      summary="Crea un nuevo Medio.",
     *      description="Este endpoint permite crear un nuevo Medio.",
     *      operationId="addMedia",
     *      tags={"Media"},
     *      security={{"sanctum": {}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  required={
     *                      "name",
     *                      "location",
     *                      "type",
     *                      "image",
     *                      "price_per_day"
     *                  },
     *                  @OA\Property(
     *                      property="name",
     *                      type="string",
     *                      example="prueba"
     *                  ),
     *                  @OA\Property(
     *                      property="location",
     *                      type="string",
     *                      example="morelia"
     *                  ),
     *                  @OA\Property(
     *                      property="type",
     *                      type="string",
     *                      example="anuncio"
     *                  ),
     *                  @OA\Property(
     *                      property="image",
     *                      type="string",
     *                      format="binary",
     *                      description="Imagen a subir"
     *                  ),
     *                  @OA\Property(
     *                      property="price_per_day",
     *                      type="number",
     *                      format="float",
     *                      example="19.99"
     *                  ),
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Medio obtenido correctamente",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Medio creado correctamente."
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean",
     *                  example="false"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="No autorizado"
     *              )
     *          )
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
     *                      property="name",
     *                      type="array",
     *                      @OA\Items(
     *                          type="string",
     *                          example="El nombre es obligatorio."
     *                      )
     *                  ),
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
    public function store(MediaStoreRequest $request)
    {
        return responseHelper($this->mediaService->createMedia($request->all()));
    }

    /**
     * @OA\Put(
     *      path="/api/media/updateMedia/{id}",
     *      summary="Actualiza un Medio.",
     *      description="Este endpoint permite actualizar al Medio.",
     *      operationId="updateMedia",
     *      tags={"Media"},
     *      security={{"sanctum": {}}},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID del Medio",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="name",
     *                      type="string",
     *                      example="prueba"
     *                  ),
     *                  @OA\Property(
     *                      property="location",
     *                      type="string",
     *                      example="morelia"
     *                  ),
     *                  @OA\Property(
     *                      property="type",
     *                      type="string",
     *                      example="anuncio"
     *                  ),
     *                  @OA\Property(
     *                      property="image",
     *                      type="string",
     *                      format="binary",
     *                      description="Imagen a subir"
     *                  ),
     *                  @OA\Property(
     *                      property="price_per_day",
     *                      type="number",
     *                      format="float",
     *                      example="19.99"
     *                  ),
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Medio actualizado correctamente.",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Medio actualizado correctamente."
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean",
     *                  example="false"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="No autorizado"
     *              )
     *          )
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
     *                      property="name",
     *                      type="array",
     *                      @OA\Items(
     *                          type="string",
     *                          example="El nombre es obligatorio."
     *                      )
     *                  ),
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
    public function update(MediaUpdateRequest $request, $id)
    {
        return responseHelper($this->mediaService->updateMedia($id, $request->all()));
    }

    /**
     * @OA\Delete(
     *      path="/api/media/deleteMedia/{id}",
     *      summary="Eliminar medio.",
     *      description="Este endpoint permite eliminar al medio.",
     *      operationId="deleteMedia",
     *      tags={"Media"},
     *      security={{"sanctum": {}}},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID del Medio",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Medio eliminado correctamente.",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Medio eliminado correctamente."
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean",
     *                  example="false"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="No autorizado"
     *              )
     *          )
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
    public function destroy($id)
    {
        return responseHelper($this->mediaService->deleteMedia($id));
    }

    /**
     * @OA\Get(
     *      path="/api/media/getImageMedia/{id}",
     *      summary="Obtener imagen del medio.",
     *      description="Este endpoint permite obtener la imagen del medio.",
     *      operationId="getImageMedia",
     *      tags={"Media"},
     *      security={{"sanctum": {}}},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID del Medio",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Imagen obtenida correctamente.",
     *          @OA\MediaType(
     *              mediaType="image/*"
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Imagen no encontrada.",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Imagen no encontrada."
     *              )
     *          )
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
    public function getImageMedia($id)
    {
        return $this->mediaService->getImageMedia($id);
    }

    /**
     * @OA\Get(
     *      path="/api/media/getReservedDays/{id}",
     *      summary="Obtener los días reservados del medio.",
     *      description="Este endpoint permite obtener los días reservados del medio.",
     *      operationId="getReservedDays",
     *      tags={"Media"},
     *      security={{"sanctum": {}}},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID del Medio",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Días reservados obtenidos correctamente.",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Días reservados obtenidos correctamente."
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(
     *                      type="string",
     *                      example="2024-04-01"
     *                  )
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Medio no encontrado.",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Medio no encontrado."
     *              )
     *          )
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
    public function getReservedDays($id)
    {
        return responseHelper($this->mediaService->getReservedDays($id));
    }
}
