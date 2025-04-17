<?php

namespace App\Http\Requests\Base;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class BaseFormRequest extends FormRequest
{
    protected array $allowlist = [];

    protected function prepareForValidation()
    {
        // Eliminar campos con valor null
        $input = $this->all();
        foreach ($input as $key => $value) {
            if ($value === null) {
                unset($input[$key]);
            }
        }
        $this->replace($input);
        // Si el request tiene su propia lista blanca personalizada, la usamos
        $allowed = $this->allowlist ?: array_keys($this->rules());

        $inputKeys = array_keys($this->all());
        $unexpected = array_diff($inputKeys, $allowed);

        if (!empty($unexpected)) {
            $this->throwUnexpectedFieldsError($unexpected);
        }
    }

    protected function throwUnexpectedFieldsError(array $fields)
    {
        throw new HttpResponseException(
            response()->json([
                'message' => 'Error de validación.',
                'errors' => [
                    'unexpected_fields' => ['Campos no permitidos: ' . implode(', ', $fields)]
                ]
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
        );
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'message' => 'Error de validación.',
                'errors' => $validator->errors()
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
        );
    }

    public function onlyExpectedFields()
    {
        $allowed = $this->allowlist ?: array_keys($this->rules());
        return $this->only($allowed);
    }
}
