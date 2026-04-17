<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PerfilRequest extends FormRequest
{
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
            'nombre'      => $isOptional . '|string|max:30',
            'descripcion' => 'nullable|string',
            'estatus'     => 'sometimes|boolean',
            'modulos'     => 'nullable|array',
            'modulos.*'   => 'string',
        ];
    }
}
