<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAdRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $isPublish = $this->input('action') === 'publish';

        $rules = [
            'action' => ['required', Rule::in(['draft', 'publish'])],
            'title' => ['required', 'string', 'max:80'],
            'description' => ['nullable', 'string', 'max:5000'],
            'category' => ['nullable', Rule::in(['manuales', 'energeticas', 'cursos', 'productos'])],
            'certifications' => ['nullable', 'array'],
            'certifications.*' => ['string', 'max:100'],
            'mode' => ['nullable', Rule::in(['presencial', 'online', 'domicilio'])],
            'city' => ['nullable', 'string', 'max:100'],
            'address' => ['nullable', 'string', 'max:255'],
            'availability' => ['nullable', 'array'],
            'availability.*' => [Rule::in(['L', 'M', 'X', 'J', 'V', 'S', 'D'])],
            'price_unit' => ['nullable', Rule::in(['por_sesion', 'por_hora', 'por_paquete', 'por_curso'])],
            'price' => ['nullable', 'numeric', 'min:0', 'max:99999.99'],
            'duration' => ['nullable', 'integer', 'min:1', 'max:1440'],
            'photos' => ['nullable', 'array', 'max:5'],
            'photos.*' => ['image', 'mimes:jpeg,jpg,png,webp', 'max:4096'],
            'terms' => ['nullable'],
        ];

        if ($isPublish) {
            $rules['category'] = ['required', Rule::in(['manuales', 'energeticas', 'cursos', 'productos'])];
            $rules['mode'] = ['required', Rule::in(['presencial', 'online', 'domicilio'])];
            $rules['price_unit'] = ['required', Rule::in(['por_sesion', 'por_hora', 'por_paquete', 'por_curso'])];
            $rules['price'] = ['required', 'numeric', 'min:0', 'max:99999.99'];
            $rules['duration'] = ['required', 'integer', 'min:1', 'max:1440'];
            $rules['terms'] = ['accepted'];
            $rules['photos'] = ['required', 'array', 'min:1', 'max:5'];
        }

        return $rules;
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'action.required' => 'Indica si quieres guardar un borrador o publicar el anuncio.',
            'action.in' => 'La acción seleccionada no es válida.',
            'title.required' => 'El título del anuncio es obligatorio.',
            'title.max' => 'El título no puede superar los 80 caracteres.',
            'category.required' => 'Selecciona una categoría para publicar.',
            'category.in' => 'La categoría seleccionada no es válida.',
            'mode.required' => 'Selecciona una modalidad para publicar.',
            'mode.in' => 'La modalidad seleccionada no es válida.',
            'price_unit.required' => 'Selecciona una unidad de precio para publicar.',
            'price_unit.in' => 'La unidad de precio seleccionada no es válida.',
            'price.required' => 'Indica un precio para publicar.',
            'price.numeric' => 'El precio debe ser un número válido.',
            'duration.required' => 'Indica la duración para publicar.',
            'duration.integer' => 'La duración debe ser un número entero.',
            'photos.required' => 'Sube al menos una foto para publicar.',
            'photos.min' => 'Sube al menos una foto para publicar.',
            'photos.max' => 'Puedes subir un máximo de 5 fotos.',
            'photos.*.image' => 'Cada archivo debe ser una imagen.',
            'photos.*.mimes' => 'Las fotos deben ser JPG, PNG o WebP.',
            'photos.*.max' => 'Cada foto no puede superar los 4 MB.',
            'terms.accepted' => 'Debes aceptar las condiciones de publicación.',
        ];
    }

    public function isPublish(): bool
    {
        return $this->input('action') === 'publish';
    }
}
