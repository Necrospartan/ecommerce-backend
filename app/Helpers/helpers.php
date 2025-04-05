<?php

use Illuminate\Http\JsonResponse;

if (!function_exists('responseHelper')) {
    function responseHelper(array $data) : \Illuminate\Http\JsonResponse {
        $status = $data['status'] ?? null;
        unset($data['status']);
        if (isset($data['error'])) {
            $data['message'] = $data['error'];
            unset($data['error']);
            $status = $status ? $status : JsonResponse::HTTP_INTERNAL_SERVER_ERROR;
        }
        return response()->json($data, $status ? $status : JsonResponse::HTTP_OK);
    }
}