<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    /**
     * @var array<int, string>
     */
    public const ALLOWED_LANGUAGES = [
        'Español',
        'Inglés',
        'Catalán',
        'Francés',
        'Alemán',
        'Italiano',
    ];

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'website' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string', 'max:300'],
            'languages' => ['nullable', 'array'],
            'languages.*' => ['string', Rule::in(self::ALLOWED_LANGUAGES)],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:4096'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'El nombre público es obligatorio.',
            'name.max' => 'El nombre no puede superar los 255 caracteres.',
            'bio.max' => 'La bio no puede superar los 300 caracteres.',
            'avatar.image' => 'La foto de perfil debe ser una imagen.',
            'avatar.mimes' => 'La foto debe ser JPG, PNG o WebP.',
            'avatar.max' => 'La foto no puede superar los 4 MB.',
            'languages.*.in' => 'Uno de los idiomas seleccionados no es válido.',
        ];
    }
}
