<?php

namespace App\Http\Controllers\Reservation;

use App\Http\Controllers\Controller;
use App\Http\Requests\Reservation\ReservationStoreRequest;
use App\Http\Requests\Reservation\ReservationUpdateRequest;
use App\Services\Reservation\ReservationService;

class ReservationController extends Controller
{
    protected $reservationService;

    public function __construct(ReservationService $reservationService)
    {
        $this->reservationService = $reservationService;
    }

    /**
     * @OA\Get(
     *      path="/api/reservation/getreservation",
     *      summary="Obtener todos las reservaciones",
     *      description="Este EndPoint regresa todos las reservaciones.",
     *      operationId="allreservation",
     *      tags={"Reservations"},
     *      security={{"sanctum": {}}},
     *      @OA\Response(
     *          response=200,
     *          description="Todos las reservaciones",
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
     *                          property="phone_number",
     *                          type="string",
     *                          example="1234567899"
     *                      ),
     *                      @OA\Property(
     *                          property="skype",
     *                          type="string",
     *                          example="example.skype"
     *                      ),
     *                      @OA\Property(
     *                          property="created_at",
     *                          type="string",
     *                          example="2024-12-12"
     *                      ),
     *                      @OA\Property(
     *                          property="updated_at",
     *                          type="string",
     *                          example="2024-12-12"
     *                      ),
     *                      @OA\Property(
     *                          property="deleted_at",
     *                          type="string",
     *                          example="null"
     *                      ),
     *                  )
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Reservaciones obtenidas correctamente."
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
        return responseHelper($this->reservationService->getAllReservation());
    }

    /**
     * @OA\Get(
     *      path="/api/reservation/getReservation/{id}",
     *      summary="Obtener una reservacion",
     *      description="Este EndPoint regresa una reservacion por su ID.",
     *      operationId="getreservation",
     *      tags={"Reservations"},
     *      security={{"sanctum": {}}},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID de la reservacion",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Reservacion obtenido correctamente",
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
     *                      property="phone_number",
     *                      type="string",
     *                      example="1234567899"
     *                  ),
     *                  @OA\Property(
     *                      property="skype",
     *                      type="string",
     *                      example="example.skype"
     *                  ),
     *                  @OA\Property(
     *                      property="created_at",
     *                      type="string",
     *                      example="2024-12-12"
     *                  ),
     *                  @OA\Property(
     *                      property="updated_at",
     *                      type="string",
     *                      example="2024-12-12"
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
     *                  example="Reservacion obtenido correctamente."
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
     *                  example="Reservacion no encontrada"
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
        return responseHelper($this->reservationService->getReservationById($id));
    }

    /**
     * @OA\Post(
     *      path="/api/reservation/addReservation",
     *      summary="Crea una nueva Reservacion.",
     *      description="Este endpoint permite crear una nueva Reservacion.",
     *      operationId="addReservation",
     *      tags={"Reservations"},
     *      security={{"sanctum": {}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={
     *                  "user_id",
     *                  "media_id",
     *                  "start_date",
     *                  "end_date",
     *                  "total_price"
     *              },
     *              @OA\Property(
     *                  property="user_id",
     *                  type="integer",
     *                  example="1"
     *              ),
     *              @OA\Property(
     *                  property="media_id",
     *                  type="integer",
     *                  example="1"
     *              ),
     *              @OA\Property(
     *                  property="start_date",
     *                  type="string",
     *                  example="2025-01-01"
     *              ),
     *              @OA\Property(
     *                  property="end_date",
     *                  type="string",
     *                  example="2025-01-01"
     *              ),
     *              @OA\Property(
     *                  property="total_price",
     *                  type="number",
     *                  format="float",
     *                  example="99.99"
     *              ),
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Reservacion obtenida correctamente",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Reservacion creada correctamente."
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
     *                      property="user_id",
     *                      type="array",
     *                      @OA\Items(
     *                          type="string",
     *                          example="El id del usuario tiene que ser un numero."
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
    public function store(ReservationStoreRequest $request)
    {
        return responseHelper($this->reservationService->createReservation($request->all()));
    }

    /**
     * @OA\Put(
     *      path="/api/reservation/updateReservation/{id}",
     *      summary="Actualiza una Reservacion.",
     *      description="Este endpoint permite actualizar la Reservacion.",
     *      operationId="updateReservation",
     *      tags={"Reservations"},
     *      security={{"sanctum": {}}},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID de la Reservacion",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="user_id",
     *                  type="integer",
     *                  example="1"
     *              ),
     *              @OA\Property(
     *                  property="media_id",
     *                  type="integer",
     *                  example="1"
     *              ),
     *              @OA\Property(
     *                  property="start_date",
     *                  type="string",
     *                  example="2025-01-01"
     *              ),
     *              @OA\Property(
     *                  property="end_date",
     *                  type="string",
     *                  example="2025-01-01"
     *              ),
     *              @OA\Property(
     *                  property="total_price",
     *                  type="number",
     *                  format="float",
     *                  example="99.99"
     *              ),
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Reservacion actualizada correctamente.",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Reservacion actualizada correctamente."
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
     *                      property="user_id",
     *                      type="array",
     *                      @OA\Items(
     *                          type="string",
     *                          example="El id del usuario tiene que ser un numero."
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
    public function update(ReservationUpdateRequest $request, $id)
    {
        return responseHelper($this->reservationService->updateReservation($id, $request->all()));
    }

    /**
     * @OA\Delete(
     *      path="/api/reservation/deleteReservacion/{id}",
     *      summary="Eliminar la reservacion.",
     *      description="Este endpoint permite eliminar la reservacion.",
     *      operationId="deleteReservation",
     *      tags={"Reservations"},
     *      security={{"sanctum": {}}},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID de la reservacion",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Reservacion eliminada correctamente.",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Reservacion eliminado correctamente."
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
        return responseHelper($this->reservationService->deleteReservation($id));
    }
}
