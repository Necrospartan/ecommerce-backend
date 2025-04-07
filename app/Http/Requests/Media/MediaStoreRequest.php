<?php

namespace App\Http\Requests\Media;

use App\Http\Requests\Base\BaseFormRequest;

class MediaStoreRequest extends BaseFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:255'],
            'image' => ['required', 'image', 'mimes:,png,jpg', 'max:2048'],
            'price_per_day' => ['required', 'numeric', 'min:0', 'max:999999.99']
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es requerido',
            'name.string' => 'El nombre debe ser un texto',
            'name.max' => 'El nombre no debe ser mayor a 255 caracteres',
            'location.required' => 'La ubicación es requerida',
            'location.string' => 'La ubicación debe ser un texto',
            'location.max' => 'La ubicación no debe ser mayor a 255 caracteres',
            'type.required' => 'El tipo es requerido',
            'type.string' => 'El tipo debe ser un texto',
            'type.max' => 'El tipo no debe ser mayor a 255 caracteres',
            'image.required' => 'La imagen es requerida',
            'image.image' => 'La imagen debe ser un archivo de imagen',
            'image.mimes' => 'La imagen debe ser un archivo tipo phg o jpg',
            'image.max' => 'La imagen no debe ser mayor a 2048 kilobytes',
            'price_per_day.required' => 'El precio por día es requerido',
            'price_per_day.numeric' => 'El precio por día debe ser un número',
            'price_per_day.min' => 'El precio por día debe ser mayor a 0',
            'price_per_day.max' => 'El precio por día no debe ser mayor a 999999.99'
        ];
    }
}
