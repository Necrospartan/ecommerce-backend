<?php

namespace App\Http\Requests\Media;

use App\Http\Requests\Base\BaseFormRequest;

class MediaUpdateRequest extends BaseFormRequest
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
            'name' => 'string|max:255',
            'location' => 'string|max:255',
            'type' => 'string|max:255',
            'image' => 'file|mimes:png,jpg|max:2048',
            'price_per_day' => 'numeric|min:0|max:999999.99'
        ];
    }

    public function messages()
    {
        return [
            'name.string' => 'El nombre tiene que ser una cadena.',
            'name.max' => 'El nombre no puede tener más de 255 caracteres.',
            'location.string' => 'La ubicación tiene que ser una cadena.',
            'location.max' => 'La ubicación no puede tener más de 255 caracteres.',
            'type.string' => 'El tipo tiene que ser una cadena.',
            'type.max' => 'El tipo no puede tener más de 255 caracteres.',
            'image.file' => 'La imagen tiene que ser un archivo.',
            'image.mimes' => 'La imagen tiene que ser de tipo png o jpg.',
            'image.max' => 'La imagen no puede tener más de 2MB.',
            'price_per_day.numeric' => 'El precio por día tiene que ser un número.',
            'price_per_day.min' => 'El precio por día no puede ser negativo.'
        ];
    }
}
