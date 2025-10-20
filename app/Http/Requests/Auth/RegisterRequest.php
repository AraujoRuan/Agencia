<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'type' => ['required', 'in:individual,business'],
            'document' => ['required', 'string'],
            'phone' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'type.required' => 'Selecione o tipo de conta',
            'type.in' => 'Tipo de conta inválido',
            'document.required' => 'CPF/CNPJ é obrigatório',
            'phone.required' => 'Telefone é obrigatório',
        ];
    }
}