<?php

namespace App\Http\Requests\Reservation;

use App\Http\Requests\Base\BaseFormRequest;

class ReservationStoreRequest extends BaseFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'integer|exists:users,id',
            'media_id' => 'integer|exists:media,id',
            'start_date' => 'date|after:today',
            'end_date' => 'date|after_or_equal:start_date',
            'total_price' => 'numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.integer' => 'El id del usuario debe ser un número entero.',
            'user_id.exists' => 'El id del usuario no existe.',
            'media_id.integer' => 'El id de la media debe ser un número entero.',
            'media_id.exists' => 'El id de la media no existe.',
            'start_date.date' => 'La fecha de inicio debe ser una fecha válida.',
            'start_date.after' => 'La fecha de inicio debe ser posterior a la fecha actual.',
            'end_date.date' => 'La fecha de fin debe ser una fecha válida.',
            'end_date.after_or_equal' => 'La fecha de fin debe ser posterior o igual a la fecha de inicio.',
            'total_price.numeric' => 'El precio total debe ser un número.',
            'total_price.min' => 'El precio total debe ser mayor o igual a 0.',
        ];
    }
}
