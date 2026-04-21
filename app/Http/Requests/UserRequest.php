<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->perfil->nombre === 'Administrador';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $isUpdate   = $this->isMethod('PUT') || $this->isMethod('PATCH');
        $isOptional = ($isUpdate ? 'sometimes' : 'required');

        return [
            'name'        => $isOptional . '|string|max:255',
            'email'       => $isOptional . '|email|max:255',
            'password'    => $isOptional . '|string|max:8',
            'perfil_ulid' => 'sometimes|nullable|exists:perfiles,ulid',
            'estatus'     => 'sometimes|boolean',
        ];
    }
}
