<?php

namespace App\Services\Reservation;

use App\Repositories\Eloquent\Reservation\ReservationRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ReservationService
{
    private ReservationRepository $reservationRepository;

    public function __construct(ReservationRepository $reservationRepository)
    {
        $this->reservationRepository = $reservationRepository;
    }

    public function getAllReservation(bool $trashed = false) : array
    {
        try {
            $reservation = $this->reservationRepository->getAll($trashed);
            if ($reservation->isEmpty()) {
                return [
                    'data' => [],
                    'message' => 'No se encontraron Reservaciones.',
                    'status' => JsonResponse::HTTP_NOT_FOUND
                ];
            }
            return [
                'data' => $reservation,
                'message' => 'Reservaciones, obtenidos correctamente.',
                'status' => JsonResponse::HTTP_OK
            ];
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return [
                'message' => 'Error al obtener los Reservaciones.',
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            ];
        }
    }

    public function getReservationById(int $id) : array
    {
        try {
            $reservation = $this->reservationRepository->getById($id);
            if ($reservation) {
                return [
                    'data' => $reservation,
                    'message' => 'Reservacion obtenido correctamente.',
                    'status' => JsonResponse::HTTP_OK
                ];
            }
            return [
                'data' => [],
                'message' => 'No se encontró el Reservacion.',
                'status' => JsonResponse::HTTP_NOT_FOUND
            ];
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return [
                'message' => 'Error al obtener el Reservacion.',
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            ];
        }
    }

    public function createReservation(array $data) : array
    {
        DB::beginTransaction();
        try {
            $reservation = $this->reservationRepository->create($data);
            if ($reservation) {
                DB::commit();
                return [
                    'message' => 'Reservacion creado correctamente.',
                    'status' => JsonResponse::HTTP_CREATED
                ];
            }
            DB::rollBack();
            return [
                'message' => 'Error al crear el Reservacion.',
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return [
                'message' => 'Error al crear el Reservacion.',
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            ];
        }
    }

    public function updateReservation(int $id, array $data) : array
    {
        DB::beginTransaction();
        try {
            $reservation = $this->reservationRepository->update($id, $data);
            if ($reservation) {
                DB::commit();
                return [
                    'message' => 'Reservacion actualizado correctamente.',
                    'status' => JsonResponse::HTTP_OK
                ];
            }
            DB::rollBack();
            return $data;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return [
                'message' => 'Error al actualizar el Reservacion.',
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            ];
        }
    }

    public function deleteReservation(int $id) : array
    {
        DB::beginTransaction();
        try {
            $reservation = $this->reservationRepository->delete($id);
            if ($reservation) {
                DB::commit();
                return [
                    'message' => 'Reservacion eliminado correctamente.',
                    'status' => JsonResponse::HTTP_OK
                ];
            }
            DB::rollBack();
            return [
                'message' => 'Error al eliminar el Reservacion.',
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return [
                'message' => 'Error al eliminar el Reservacion.',
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            ];
        }
    }
}
