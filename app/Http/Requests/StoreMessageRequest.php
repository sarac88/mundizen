<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreMessageRequest extends FormRequest
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
        $rules = [
            'body' => ['required', 'string', 'max:5000'],
            'subject' => ['nullable', 'string', 'max:120'],
        ];

        if (! $this->user()) {
            $rules['guest_name'] = ['required', 'string', 'max:100'];
            $rules['guest_email'] = ['required', 'email', 'max:255'];
        }

        return $rules;
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'body.required' => 'Escribe un mensaje antes de enviar.',
            'body.max' => 'El mensaje no puede superar los 5000 caracteres.',
            'subject.max' => 'El asunto no puede superar los 120 caracteres.',
            'guest_name.required' => 'Indica tu nombre.',
            'guest_name.max' => 'El nombre no puede superar los 100 caracteres.',
            'guest_email.required' => 'Indica tu email.',
            'guest_email.email' => 'El email no es válido.',
        ];
    }
}
