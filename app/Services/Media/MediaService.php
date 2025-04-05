<?php

namespace App\Services\Media;

use App\Repositories\Eloquent\Media\MediaRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class MediaService
{
    private MediaRepository $mediaRepository;

    public function __construct(MediaRepository $mediaRepository)
    {
        $this->mediaRepository = $mediaRepository;
    }

    public function getAllMedia(bool $trashed = false) : array
    {
        try {
            $media = $this->mediaRepository->getAll($trashed);
            if ($media->isEmpty()) {
                return [
                    'data' => [],
                    'message' => 'No se encontraron medios.',
                    'status' => JsonResponse::HTTP_NOT_FOUND
                ];
            }
            return [
                'data' => $media,
                'message' => 'Medios, obtenidos correctamente.',
                'status' => JsonResponse::HTTP_OK
            ];
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return [
                'message' => 'Error al obtener los medios.',
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            ];
        }
    }

    public function getMediaById(int $id) : array
    {
        try {
            $media = $this->mediaRepository->getById($id);
            if ($media) {
                return [
                    'data' => $media,
                    'message' => 'Medio obtenido correctamente.',
                    'status' => JsonResponse::HTTP_OK
                ];
            }
            return [
                'data' => [],
                'message' => 'No se encontró el medio.',
                'status' => JsonResponse::HTTP_NOT_FOUND
            ];
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return [
                'message' => 'Error al obtener el medio.',
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            ];
        }
    }

    public function createMedia(array $data) : array
    {
        DB::beginTransaction();
        try {
            $media = $this->mediaRepository->create($data);
            if ($media) {
                DB::commit();
                return [
                    'message' => 'Medio creado correctamente.',
                    'status' => JsonResponse::HTTP_CREATED
                ];
            }
            DB::rollBack();
            return [
                'message' => 'Error al crear el medio.',
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return [
                'message' => 'Error al crear el medio.',
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            ];
        }
    }

    public function updateMedia(int $id, array $data) : array
    {
        DB::beginTransaction();
        try {
            $media = $this->mediaRepository->update($id, $data);
            if ($media) {
                DB::commit();
                return [
                    'message' => 'Medio actualizado correctamente.',
                    'status' => JsonResponse::HTTP_OK
                ];
            }
            DB::rollBack();
            return $data;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return [
                'message' => 'Error al actualizar el medio.',
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            ];
        }
    }

    public function deleteMedia(int $id) : array
    {
        DB::beginTransaction();
        try {
            $media = $this->mediaRepository->delete($id);
            if ($media) {
                DB::commit();
                return [
                    'message' => 'Medio eliminado correctamente.',
                    'status' => JsonResponse::HTTP_OK
                ];
            }
            DB::rollBack();
            return [
                'message' => 'Error al eliminar el Medio.',
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return [
                'message' => 'Error al eliminar el Medio.',
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            ];
        }
    }
}
