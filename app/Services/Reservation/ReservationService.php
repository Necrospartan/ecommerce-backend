<?php

namespace App\Services\Reservation;

use App\Http\Resources\Reservation\ReservationCollection;
use App\Http\Resources\Reservation\ReservationResource;
use App\Models\Availability;
use App\Repositories\Eloquent\Media\MediaRepository;
use App\Repositories\Eloquent\Reservation\ReservationRepository;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ReservationService
{
    private ReservationRepository $reservationRepository;
    private MediaRepository $mediaRepository;

    public function __construct(ReservationRepository $reservationRepository, MediaRepository $mediaRepository)
    {
        $this->reservationRepository = $reservationRepository;
        $this->mediaRepository = $mediaRepository;
    }

    public function getAllReservation(bool $trashed = false) : array
    {
        try {
            $reservation = $this->reservationRepository->getAll($trashed, 10);
            $user = auth()->user();
            if ($user->role == "Cliente") {
                $reservation->where('user_id', $user->id);
            }
            if ($reservation->isEmpty()) {
                return [
                    'data' => [],
                    'message' => 'No se encontraron Reservaciones.',
                    'status' => JsonResponse::HTTP_NOT_FOUND
                ];
            }
            new ReservationCollection($reservation);
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
            $user = auth()->user();
            if ($user->role == "Cliente") {
                $reservation->where('user_id', $user->id);
            }
            if ($reservation) {
                return [
                    'data' => new ReservationResource($reservation),
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
            $validate = $this->validateInformation($data);
            if (!empty($validate)) {
                return $validate;
            }
            $user = auth()->user();
            $data['user_id'] = $user->id;
            $reservation = $this->reservationRepository->create($data);
            if ($reservation) {
                DB::commit();
                return [
                    'message' => 'Reservacion creado correctamente.',
                    'status' => JsonResponse::HTTP_CREATED
                ];
            }
            DB::rollBack();
            throw new \Exception('Error al crear el Reservacion.');
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
            //faltaria agregar la validacion de los datos
            $reservation = $this->reservationRepository->update($id, $data);
            if ($reservation) {
                DB::commit();
                return [
                    'message' => 'Reservacion actualizado correctamente.',
                    'status' => JsonResponse::HTTP_OK
                ];
            }
            DB::rollBack();
            throw new \Exception('Error al actualizar el Reservacion.');
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
            throw new \Exception('Error al eliminar el Reservacion.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return [
                'message' => 'Error al eliminar el Reservacion.',
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            ];
        }
    }

    public function validateInformation(array $data) : array
    {
        try {
            $startDate = Carbon::parse($data['start_date']);
            $endDate = Carbon::parse($data['end_date']);
            $reservedDays = [];

            $currentDate = $startDate->copy();

            while ($currentDate->lte($endDate)) {
                $reservedDays[] = $currentDate->toDateString();
                $currentDate->addDay();
            }

            $existingReservedDays = Availability::where('media_id', $data['media_id'])
                ->pluck('reserved_date')
                ->toArray();

            $conflictingDays = array_intersect($reservedDays, $existingReservedDays);

            if (!empty($conflictingDays)) {
                return [
                    'message' => 'Las siguientes fechas ya están reservadas: ' . implode(', ', $conflictingDays),
                    'status' => JsonResponse::HTTP_CONFLICT
                ];
            }

            //valida que el total de lo pagado corresponda con los dias reservados
            $media = $this->mediaRepository->getById($data['media_id']);
            $totalPrice = $media->price_per_day * count($reservedDays);
            if ($totalPrice != $data['total_price']) {
                return [
                    'message' => 'El total de lo pagado no corresponde con los dias reservados.',
                    'status' => JsonResponse::HTTP_CONFLICT
                ];
            }
            return [];
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return [
                'message' => 'Error al Validar Informacion de la reservacion.',
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            ];
        }
    }
}
